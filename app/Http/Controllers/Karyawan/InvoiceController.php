<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{transaksi};
use Auth;
use PDF;
class InvoiceController extends Controller
{
       // Invoice
    public function invoicekar(Request $request)
    {
      $invoice = transaksi::selectRaw('transaksis.*,a.jenis')
        ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.harga_id')
        ->where('transaksis.id', $request->id)
        ->where('transaksis.user_id',Auth::user()->id)
        ->orderBy('id','DESC')->get();

        $data = transaksi::selectRaw('transaksis.*,a.nama,a.alamat,a.no_telp,a.kelamin,b.name,b.nama_cabang,b.alamat_cabang,b.no_telp as no_telpc')
        ->leftJoin('customers as a' , 'a.id' , '=' ,'transaksis.id')
        ->leftJoin('users as b' , 'b.id' , '=' ,'transaksis.user_id')
        ->where('transaksis.id', $request->id)
        ->where('transaksis.user_id',Auth::user()->id)
        ->orderBy('id','DESC')->first();

      return view('karyawan.laporan.invoice', compact('invoice','data'));
    }

    // Cetak invoice
    public function cetakinvoice(Request $request)
    {
      $invoice = transaksi::selectRaw('transaksis.*,a.jenis')
      ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.harga_id')
      ->where('transaksis.id', $request->id)
      ->where('transaksis.user_id',Auth::user()->id)
      ->orderBy('id','DESC')->get();

      $data = transaksi::selectRaw('transaksis.*,a.nama,a.alamat,a.no_telp,a.kelamin,b.name,b.nama_cabang,b.alamat_cabang,b.no_telp as no_telpc')
          ->leftJoin('customers as a' , 'a.id' , '=' ,'transaksis.id')
          ->leftJoin('users as b' , 'b.id' , '=' ,'transaksis.user_id')
          ->where('transaksis.id', $request->id)
          ->where('transaksis.user_id',Auth::user()->id)
          ->orderBy('id','DESC')->first();

      $pdf = PDF::loadView('karyawan.laporan.cetak', compact('invoice','data'))->setPaper('a4', 'landscape');
      return $pdf->stream();
    }
}
