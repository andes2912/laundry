<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{transaksi,DataBank};
use Auth;
use PDF;
class InvoiceController extends Controller
{
       // Invoice
    public function invoicekar(Request $request)
    {
      $invoice = transaksi::with('price')
      ->where('user_id',Auth::id())
      ->where('id',$request->id)
      ->get();

      $data = transaksi::with('customers','user')
      ->where('user_id',Auth::id())
      ->where('id',$request->id)
      ->first();

      $bank = DataBank::get();
      return view('karyawan.laporan.invoice', compact('invoice','data','bank'));
    }

    // Cetak invoice
    public function cetakinvoice(Request $request)
    {
       $invoice = transaksi::with('price')
      ->where('user_id',Auth::id())
      ->where('id',$request->id)
      ->get();

      $data = transaksi::with('customers','user')
      ->where('user_id',Auth::id())
      ->where('id',$request->id)
      ->first();

      $bank = DataBank::get();

      $pdf = PDF::loadView('karyawan.laporan.cetak', compact('invoice','data','bank'))->setPaper('a4', 'landscape');
      return $pdf->stream();
    }
}
