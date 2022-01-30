<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCustomerRequest;
use Illuminate\Http\Request;
use App\Models\customer;
use Auth;
use Session;

class CustomerController extends Controller
{
    // index
    public function index()
    {
      $customer = customer::orderBy('id','DESC')->where('user_id',Auth::user()->id)->get();
      return view('karyawan.customer.index', compact('customer'));
    }

    // Detail Customer
    public function detail($id)
    {
      $customer = customer::with(['transaksi' => function($a) {
        $a->orderBy('created_at','desc');
      }])->where('user_id',Auth::user()->id)
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
      $cekNumber = substr($request->no_telp,0,1); // ambil angka pertama dari string
      $cekNumber1 = substr($request->no_telp,0,2); // ambil angka pertama & kedua dari string

      if ($cekNumber == 0) { // cek jika angka pertama sama dengan 0, jalankan perintah ini
        $removeNol = '62'. ltrim($request->no_telp, 0); // Hapus angka kosong
      } elseif($cekNumber1 == 62) { // cek jika angka pertama & kedua sama dengan 62, jalankan perintah ini
        $removeNol = $request->no_telp; // Balikan jika format sudah benar
      }

      $addplg = New customer();
      $addplg->nama = $request->nama;
      $addplg->email_customer = $request->email_customer;
      $addplg->alamat = $request->alamat;
      $addplg->kelamin = $request->kelamin;
      $addplg->no_telp = $removeNol;
      $addplg->user_id = Auth::user()->id;
      $addplg->save();

      Session::flash('success','Customer Berhasil Ditambah !');

      return redirect('customers');
    }
}
