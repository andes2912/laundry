<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,customer,transaksi,harga,LaundrySetting};
use Auth;
use Rupiah;
use DB;
use Session;
use Spatie\Permission\Models\Role;

use Carbon\carbon;

class AdminController extends Controller
{
    // Halaman admin
    public function adm()
    {
      $adm = User::where('auth','Admin')->get();
      return view('modul_admin.pengguna.admin', compact('adm'));
    }

    // Tambah dan Data Harga
    public function dataharga()
    {
      $harga = harga::selectRaw('hargas.*,a.nama_cabang')
      ->leftJoin('users as a','a.id','=','hargas.user_id')
      ->orderBy('id','DESC')->get(); // Ambil data harga
      $karyawan = User::where('auth','Karyawan')->first(); // Cek Apakah sudah ada karyawan atau belum
      $getcabang = User::where('auth','Karyawan')->where('status','Active')->get();
      return view('modul_admin.laundri.harga', compact('harga','karyawan','getcabang'));
    }

    // Proses Simpan Harga
    public function hargastore(Request $request)
    {
       $request->validate([
        'jenis' => 'required',
        'harga' => 'required',
        'hari'  => 'required'
      ]);

      $addharga = new harga();
      $addharga->user_id = $request->user_id;
      $addharga->jenis = $request->jenis;
      $addharga->kg = 1000; // satuan gram
      $addharga->harga = $request->harga;
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

// Laporan

    // Hitung Jumlah Transaksi Keseluruhan
    public function jmlTransaksi(Request $request)
    {
        $jml = customer::select(DB::raw('t.id,t.nama,t.alamat,t.kelamin,t.no_telp,a.kg'))
        ->from(DB::raw('(SELECT * from customers order by created_at DESC) t'))
        ->leftJoin('transaksis as a' ,'a.customer_id' , '=' , 't.id')
        ->groupBy('t.id')
        ->get();

        return view('modul_admin.customer.jmltransaksi', compact('jml'));
    }

    // Data Finance Cabang
    public function finance(Request $request)
    {
      // Uang yg di dapat by keseluruhan
      $all = transaksi::where('status_payment','Success')->sum('harga_akhir');

      // Uang yg di dapat by hari
      $hari = transaksi::where('status_payment','Success')->where('tgl', Carbon::now()->day)->where('bulan', Carbon::now()->month)->where('tahun', Carbon::now()->year)->sum('harga_akhir');

      // Uang yg di dapat by bulan
      $bulan = transaksi::where('status_payment','Success')->where('bulan', Carbon::now()->month)->where('tahun', Carbon::now()->year)->sum('harga_akhir');

      // Uang yg di dapat by tahunan
      $tahun = transaksi::where('status_payment','Success')->where('tahun', Carbon::now()->year)->sum('harga_akhir');

      $tTahun = LaundrySetting::first(); //Target tahunan
      $tBulan = LaundrySetting::first(); //Target Bulanan
      $tHari  = LaundrySetting::first(); //Target Harian

      $thn = transaksi::where('status_payment','Success')->where('tahun', Carbon::now()->year)->count();
      $bln = transaksi::where('status_payment','Success')->where('bulan', Carbon::now()->month)->where('tahun', Carbon::now()->year)->count();
      $hri = transaksi::where('status_payment','Success')->where('tgl', Carbon::now()->day)->where('bulan', Carbon::now()->month)->where('tahun', Carbon::now()->year)->count();

      // Ambil data persen by year
      $hy = NULL;
      $year = ($tTahun->target_year - $thn) * 100;
      if ($tTahun->target_year == 0) {
        $hy = 0;
      } else {
        $hy = $year * 100 / $tTahun->target_year;
      }

      $hys = $hy / 100;
      $ny = 100 - $hys;

      // Ambil data persen by month
      $hm = NULL;
      $month = ($tBulan->target_month - $bln) * 100;

      if ($tBulan->target_month == 0) {
        $hm = 0;
      } else {
        $hm = $month * 100 / $tBulan->target_month;
      }
      $hms = $hm / 100;
      $nm = 100 - $hms;

      // Ambil data persen by day
      $hd = null;
      $day = ($tHari->target_day - $hri) * 100;
      if ($tHari->target_day == 0) {
        $hd= 0;
      } else {
      $hd = $day * 100 / $tHari->target_day;

      }
      $hds = $hd / 100;
      $nd = 100 - $hds;

      // Jumlah laundry by kg
      $kg = transaksi::sum('kg');

      $transaksi = transaksi::get();

      $user = transaksi::select('customer_id')->groupBy('customer_id')->get();
      return view('modul_admin.finance.cabang', compact('all','hari','bulan','tahun','kg','transaksi','user','ny','nm','nd'));
    }

    // Profile
    public function profile()
    {
      $profile = User::where('id',Auth::id())->first();
      return view('modul_admin.setting.profile', compact('profile'));
    }

    // Proses edit profile
    public function edit_profile(Request $request)
    {
      $profile = User::find($request->id_profile);
      $profile->update([
        'name'  => $request->name,
        'email'  => $request->email
      ]);

      Session::flash('success','Update Profile Berhasil');
      return $profile;
    }
}
