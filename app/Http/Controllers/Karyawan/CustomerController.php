<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use ErrorException;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AddCustomerRequest;
use Illuminate\Support\Facades\Hash;
use App\Jobs\RegisterCustomerJob;
use Mail;
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
      $customer = User::with('transaksiCustomer')
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

      try {
        DB::beginTransaction();


        $phone_number = preg_replace('/^0/','62',$request->no_telp);
        $password = str::random(8);

        $addCustomer = User::create([
          'karyawan_id' => Auth::id(),
          'name'        => $request->name,
          'email'       => $request->email,
          'auth'        => 'Customer',
          'status'      => 'Active',
          'no_telp'     => $phone_number,
          'alamat'      => $request->alamat,
          'password'    => Hash::make($password)
        ]);

        $addCustomer->assignRole($addCustomer->auth);

        if ($addCustomer) {
          // Menyiapkan data Email
          $data = array(
              'name'            => $addCustomer->name,
              'email'           => $addCustomer->email,
              'password'        => $password,
              'url_login'       => url('/login'),
              'nama_laundry'    => Auth::user()->nama_cabang,
              'alamat_laundry'  => Auth::user()->alamat_cabang,
          );
          // Kirim email
           if (setNotificationEmail(1) == 1) {
            dispatch(new RegisterCustomerJob($data));
           }
        }
        DB::commit();
        Session::flash('success','Customer Berhasil Ditambah !');
        return redirect('customers');
      } catch (ErrorException $e) {
        DB::rollback();
        throw new ErrorException($e->getMessage());
      }
    }
}
