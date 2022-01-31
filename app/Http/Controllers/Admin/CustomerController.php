<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class CustomerController extends Controller
{

    public function index()
    {
      $customer = User::where('auth','Customer')->get();
      return view('modul_admin.customer.index', compact('customer'));
    }

    public function show($id)
    {
      $customer = User::with('transaksiCustomer')->where('id',$id)->first();
      return view('modul_admin.customer.infoCustomer', compact('customer'));
    }
}
