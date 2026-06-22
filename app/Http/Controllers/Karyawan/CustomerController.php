<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AddCustomerRequest;
use Illuminate\Support\Facades\Hash;
use App\Jobs\RegisterCustomerJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class CustomerController extends Controller
{
    // index
    public function index()
    {
      $customer = User::where('karyawan_id',Auth::user()->id)
      ->where('auth','Customer')
      ->orderBy('id','DESC')->get();
      return view('karyawan.customer.index', compact('customer'));
    }

    // Detail Customer
    public function detail($id)
    {
      $customer = User::with(['transaksiCustomer' => function ($q) {
          $q->with('items','price')->orderByDesc('id');
      }])
      ->where('karyawan_id',Auth::user()->id)
      ->where('id',$id)->first();
      return view('karyawan.customer.detail', compact('customer'));
    }

    // Create
    public function create()
    {
      return view('karyawan.customer.create');
    }

    // Store
    public function store(AddCustomerRequest $request)
    {
        // 1. Buat user dulu (DB transaction). Mail dipisah supaya gagal mail
        //    tidak membatalkan pembuatan customer.
        try {
            DB::beginTransaction();

            $phone_number = preg_replace('/^0/', '62', $request->no_telp);
            $password     = Str::random(8);

            $addCustomer = User::create([
                'karyawan_id' => Auth::id(),
                'name'        => $request->name,
                'email'       => $request->email,
                'auth'        => 'Customer',
                'status'      => 'Active',
                'no_telp'     => $phone_number,
                'alamat'      => $request->alamat,
                'password'    => Hash::make($password),
            ]);

            $addCustomer->assignRole($addCustomer->auth);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('CustomerController@store DB error: '.$e->getMessage());
            Session::flash('error', 'Gagal menyimpan customer: '.$e->getMessage());
            return back()->withInput();
        }

        // 2. Coba kirim email — kalau gagal, customer tetap ada, hanya warn karyawan.
        $emailStatus = 'skipped';   // skipped | sent | failed
        $emailError  = null;

        if (setNotificationEmail(1) == 1) {
            try {
                $data = [
                    'name'           => $addCustomer->name,
                    'email'          => $addCustomer->email,
                    'password'       => $password,
                    'url_login'      => url('/login'),
                    'nama_laundry'   => optional(Auth::user()->cabang)->nama ?? Auth::user()->nama_cabang,
                    'alamat_laundry' => optional(Auth::user()->cabang)->alamat ?? Auth::user()->alamat_cabang,
                ];
                dispatch(new RegisterCustomerJob($data));
                $emailStatus = 'sent';
            } catch (Throwable $e) {
                $emailStatus = 'failed';
                $emailError  = $e->getMessage();
                Log::warning('RegisterCustomerJob dispatch failed: '.$e->getMessage());
            }
        }

        // 3. Flash hasil + password sekali pakai (untuk ditampilkan di list page).
        Session::flash('success', 'Customer '.$addCustomer->name.' berhasil ditambahkan.');
        Session::flash('new_customer', [
            'name'         => $addCustomer->name,
            'email'        => $addCustomer->email,
            'password'     => $password,
            'no_telp'      => $addCustomer->no_telp,
            'email_status' => $emailStatus,
            'email_error'  => $emailError,
        ]);

        return redirect('customers');
    }
}
