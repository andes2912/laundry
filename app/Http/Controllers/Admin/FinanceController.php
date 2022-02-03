<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{transaksi,customer,LaundrySetting,User,harga,DataBank};
use App\Http\Requests\HargaRequest;
use DB;
use Auth;
use Session;
use Carbon\carbon;

class FinanceController extends Controller
{
  // Finance
  public function index()
  {
    $chartMonthSalary = DB::table('transaksis')
    ->select('bulan', DB::raw('sum(harga_akhir) AS jml'))
    ->whereYear('created_at','=',date("Y", strtotime(now())))
    ->whereMonth('created_at','=',date("m", strtotime(now())))
    ->groupBy('bulan')
    ->get();

    $bulans = '';
    $batas =  12;
    $chartMonth = '';
    for($_i=1; $_i <= $batas; $_i++){
        $bulans = $bulans . (string)$_i . ',';
        $_check = false;
        foreach($chartMonthSalary as $_data){
            if((int)@$_data->bulan === $_i){
                $chartMonth = $chartMonth . (string)$_data->jml . ',';
                $_check = true;
            }
        }
        if(!$_check){
            $chartMonth = $chartMonth . '0,';
        }
    }

    $incomeAll = transaksi::where('status_payment','Success')->sum('harga_akhir');
    $incomeY = transaksi::where('status_payment','Success')->where('tahun',date('Y'))
    ->sum('harga_akhir');

    $incomeM = transaksi::where('status_payment','Success')->where('tahun',date('Y'))
    ->where('bulan', ltrim(date('m'),'0'))->sum('harga_akhir');

    $incomeYOld = transaksi::where('status_payment','Success')->where('tahun',date("Y",strtotime("-1 year")))
    ->sum('harga_akhir');

    $incomeD = transaksi::where('status_payment','Success')->where('tahun',date('Y'))
    ->where('bulan', ltrim(date('m'),'0'))->where('tgl',ltrim(date('d'),'0'))->sum('harga_akhir');

    $incomeDOld = transaksi::where('status_payment','Success')->where('tahun',date('Y'))
    ->where('bulan', ltrim(date('m'),'0'))->where('tgl',ltrim(date("d",strtotime("-1 day")),'0'))->sum('harga_akhir');

    $kgDay = transaksi::where('tahun',date('Y'))->where('bulan', ltrim(date('m'),'0'))->where('tgl',ltrim(date('d'),'0'))->sum('kg');
    $kgMonth = transaksi::where('tahun',date('Y'))->where('bulan', ltrim(date('m'),'0'))->sum('kg');
    $kgYear = transaksi::where('tahun',date('Y'))->sum('kg');

    $getCabang = User::whereHas('transaksi', function($a) {
      $a->where('tahun',date('Y'))
      ->where('bulan', ltrim(date('m'),'0'));
    })
    ->get();

    $target = LaundrySetting::first();

    return view('modul_admin.finance.index', \compact(
      'chartMonth','incomeY','incomeM','incomeYOld','incomeD','incomeDOld',
      'target','incomeAll','getCabang','kgDay','kgMonth','kgYear'
    ));
  }


   // Tambah dan Data Harga
    public function dataharga()
    {
      // Ambil data harga
      $harga = harga::with('harga_user')->orderBy('id','DESC')->get();
      // Cek Apakah sudah ada karyawan atau belum
      $karyawan = User::where('auth','Karyawan')->first();
      // Ambil list cabang
      $getcabang = User::where('auth','Karyawan')->where('status','Active')->get();

      // Get Data Bank
      $getBank = DataBank::where('user_id',Auth::id())->count();

      return view('modul_admin.laundri.harga', compact('harga','karyawan','getcabang','getBank'));
    }

    // Proses Simpan Harga
    public function hargastore(HargaRequest $request)
    {
      $addharga = new harga();
      $addharga->user_id = $request->user_id;
      $addharga->jenis = $request->jenis;
      $addharga->kg = 1000; // satuan gram
      $addharga->harga = preg_replace('/[^A-Za-z0-9\-]/', '', $request->harga); // Remove special caracter
      $addharga->hari = $request->hari;
      $addharga->status = 1; //aktif
      $addharga->save();

      Session::flash('success','Tambah Data Harga Berhasil');
      return redirect('data-harga');
    }

    // Proses edit harga
    public function hargaedit(Request $request)
    {
      $editharga = harga::find($request->id_harga);
      $editharga->update([
          'jenis' => $request->jenis,
          'kg'    => $request->kg,
          'harga' => $request->harga,
          'hari' => $request->hari,
          'status' => $request->status,
      ]);
      Session::flash('success','Edit Data Harga Berhasil');
      return $editharga;

    }
}
