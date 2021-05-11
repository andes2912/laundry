<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{transaksi,customer,harga};
use Auth;

class LaporanController extends Controller
{
    //Halaman Laporan
    public function laporan()
    {
      $laporan = transaksi::where('user_id', Auth::id())->whereIn('status_order',['Done','Delivery'])->get();
      return view('karyawan.laporan.index', compact('laporan'));
    }
}
