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
use App\Models\MembershipPrice;
use App\Models\Memberships;
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
      $customer = User::with('membership_price')
      ->where('karyawan_id',Auth::user()->id)
      ->where('auth','Customer')
      ->orderBy('id','DESC')->get();

      $membership = MembershipPrice::where('is_active',1)->get();
      return view('karyawan.customer.index', compact('customer','membership'));
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
        $membership = MembershipPrice::where('is_active',1)->get();
        return view('karyawan.customer.create', compact('membership'));
    }

    // Store
    public function store(AddCustomerRequest $request)
    {

      try {
        DB::beginTransaction();
        $cekNumber = substr($request->no_telp,0,1); // ambil angka pertama dari string
        $cekNumber1 = substr($request->no_telp,0,2); // ambil angka pertama & kedua dari string

        if ($cekNumber == 0) { // cek jika angka pertama sama dengan 0, jalankan perintah ini
          $removeNol = '62'. ltrim($request->no_telp, 0); // Hapus angka kosong
        } elseif($cekNumber1 == 62) { // cek jika angka pertama & kedua sama dengan 62, jalankan perintah ini
          $removeNol = $request->no_telp; // Balikan jika format sudah benar
        }

        $password = str::random(8);

        $addCustomer = new User;
        $addCustomer->karyawan_id   = Auth::id();
        $addCustomer->name          = $request->name;
        $addCustomer->email         = $request->email;
        $addCustomer->auth          = 'Customer';
        $addCustomer->status        = 'Active';
        $addCustomer->no_telp       = $removeNol;
        $addCustomer->alamat        = $request->alamat;
        $addCustomer->membership_id = $request->membership_id;
        $addCustomer->is_membership = $request->membership_id != null || $request->membership_id != ''  ? 1 : 0;
        $addCustomer->password      = Hash::make($password);
        $addCustomer->assignRole($addCustomer->auth);
        $addCustomer->save();

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
        //   dispatch(new RegisterCustomerJob($data));
        }
        DB::commit();
        Session::flash('success','Customer Berhasil Ditambah !');
        return redirect('customers');
      } catch (ErrorException $e) {
        DB::rollback();
        throw new ErrorException($e->getMessage());
      }
    }

    // Deactive Membership
    public function deactiveMembership(Request $request)
    {
        try {
            DB::beginTransaction();
            $customer = User::find($request->id);
            $customer->update([
                'is_membership' => 0,
                'membership_price_id' => null
            ]);

            $member = Memberships::where('user_id',$customer->id)->first();
            $member->update([
                'curent_kg' => 0,
                'addtional' => null
            ]);
            DB::commit();
            Session::flash('success', "Deactive Membership Success!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Session::flash('error', "Deactive Membership Error!");
        }
    }

    // Add Membership
    public function addMembership(Request $request)
    {
        try {
            DB::beginTransaction();
            $membership = User::find($request->id);
            $membership->update([
                'membership_price_id' => $request->membership_price_id,
                'is_membership' => 1
            ]);

            $member = Memberships::firstOrNew(['user_id' => $membership->id]);
            $member->user_id                = $membership->id;
            $member->membership_price_id    = $membership->membership_price_id;
            $member->curent_kg              = $membership->membership_price->kg + $member->curent_kg;
            $member->addtional              = $membership->membership_price->kg;
            $member->save();

            DB::commit();
            Session::flash('success', "Add Membership Success!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Session::flash('error', "Add Membership Error!");
        }
    }
}
