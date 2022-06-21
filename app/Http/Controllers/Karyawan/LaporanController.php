<?php

namespace App\Http\Controllers\Karyawan;

use App\Exports\LaporanExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{transaksi,customer,harga};
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    //Halaman Laporan
    public function laporan()
    {
      $laporan = transaksi::where('user_id', Auth::id())->get();
      return view('karyawan.laporan.index', compact('laporan'));
    }

    // Export Excel
    public function exportExcel()
    {
      return Excel::download(new LaporanExport, 'laporan_laundry.xlsx');
    }
}
