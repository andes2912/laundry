<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{transaksi,user};
use Rupiah;

class TransaksiController extends Controller
{

    public function index()
    {
      $transaksi = transaksi::with('price','items','user')
      ->orderBy('created_at','desc')->get();

      $filter = User::select('id','name')->where('auth','Karyawan')->get();

      return view('modul_admin.transaksi.index', compact('transaksi','filter'));
    }

    // Filter Transaksi
    public function filtertransaksi(Request $request)
    {
      $q = transaksi::with('price','items','user')->orderBy('created_at','desc');
      if ($request->user_id != 'all') {
        $q->where('user_id', $request->user_id);
      }
      $transaksi = $q->get();

      return view('modul_admin.transaksi._rows', compact('transaksi'))->render();
    }

    // Invoice
    public function invoice( Request $request)
    {
      $invoice = transaksi::with('price','items')
      ->where('invoice', $request->invoice)
      ->orderBy('id','DESC')->get();

      $dataInvoice = transaksi::with('customers','user','items')
      ->where('invoice', $request->invoice)
      ->first();

      return view('modul_admin.transaksi.invoice', compact('invoice','dataInvoice'));
    }
}
