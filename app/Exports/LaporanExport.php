<?php

namespace App\Exports;

use App\Models\transaksi;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
      $data = transaksi::where('user_id',Auth::id())->get();

      return view(
        'karyawan.laporan.excelExport',
        [
          'data'  => $data
        ]
      );
    }
}
