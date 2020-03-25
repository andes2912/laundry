<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transaksi;
use App\customer;
use Auth;
use DB;
use Carbon\carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::check()){
            if (Auth::user()->auth === "Admin") {
                $masuk = transaksi::whereIN('status_order',['Proses','Selesai','Diambil'])->count();
                $selesai = transaksi::where('status_order','Selesai')->count();
                $diambil = transaksi::where('status_order','Diambil')->count();
                $customer = customer::all();
                $sudahbayar = transaksi::where('status_payment','Lunas')->count();
                $belumbayar = transaksi::where('status_payment','Belum')->count();
                $data = DB::table("transaksis")
                    ->select("id" ,DB::raw("(COUNT(*)) as customer"))
                    ->orderBy('created_at')
                    ->groupBy(DB::raw("MONTH(created_at)"))
                    ->count();

                // Statistik Harian
                $hari = DB::table('transaksis')
                ->  select('tgl', DB::raw('count(id) AS jml'))
                ->  whereYear('created_at','=',date("Y", strtotime(now())))
                ->  whereMonth('created_at','=',date("m", strtotime(now())))
                ->  groupBy('tgl')
                ->  get();

                $tanggal = '';
                $batas =  31;
                $nilai = '';
                for($_i=1; $_i <= $batas; $_i++){
                    $tanggal = $tanggal . (string)$_i . ',';
                    $_check = false;
                    foreach($hari as $_data){
                        if((int)@$_data->tgl === $_i){
                            $nilai = $nilai . (string)$_data->jml . ',';
                            $_check = true;
                        }
                    }
                    if(!$_check){
                        $nilai = $nilai . '0,';
                    }
                }

                // Statistik Bulanan
                $jan = transaksi::where('bulan', 1)->count();
                $feb = transaksi::where('bulan', 2)->count();
                $mar = transaksi::where('bulan', 3)->count();
                $apr = transaksi::where('bulan', 4)->count();
                $mey = transaksi::where('bulan', 5)->count();
                $juni = transaksi::where('bulan', 6)->count();
                $july = transaksi::where('bulan', 7)->count();
                $aug = transaksi::where('bulan', 8)->count();
                $sep = transaksi::where('bulan', 9)->count();
                $oct = transaksi::where('bulan', 10)->count();
                $nov = transaksi::where('bulan', 11)->count();
                $dec = transaksi::where('bulan', 12)->count();

                return view('modul_admin.index')
                    ->  with('data', $data)
                    ->  with('masuk',$masuk)
                    ->  with('selesai',$selesai)
                    ->  with('customer', $customer)
                    ->  with('sudahbayar', $sudahbayar)
                    ->  with('belumbayar', $belumbayar)
                    ->  with('_tanggal', substr($tanggal, 0,-1))
                    ->  with('_nilai', substr($nilai, 0, -1))
                    ->  with('diambil',$diambil)
                    ->  with('jan', $jan)->  with('feb', $feb)->  with('mar', $mar)->  with('apr', $apr)->  with('mey', $mey)->  with('juni', $juni)->  with('july', $july)->  with('aug', $aug)->  with('sep', $sep)->  with('oct', $oct)->  with('nov', $nov)->  with('dec', $dec);

            } elseif(Auth::user()->auth === "Karyawan") {
                $masuk = transaksi::whereIN('status_order',['Proses','Selesai','Diambil'])->where('id_karyawan',auth::user()->id)->count();
                $selesai = transaksi::where('status_order','Selesai')->where('id_karyawan',auth::user()->id)->count();
                $diambil = transaksi::where('status_order','Diambil')->where('id_karyawan',auth::user()->id)->count();
                $customer = customer::where('id_karyawan',auth::user()->id)->get();
                $sudahbayar = transaksi::where('status_payment','Lunas')->where('id_karyawan',auth::user()->id)->count();
                $belumbayar = transaksi::where('status_payment','Belum')->where('id_karyawan',auth::user()->id)->count();

                // Statistik Harian
                $hari = DB::table('transaksis')
                ->  select('tgl', DB::raw('count(id) AS jml'))
                ->  whereYear('created_at','=',date("Y", strtotime(now())))
                ->  whereMonth('created_at','=',date("m", strtotime(now())))
                ->  groupBy('tgl')
                ->where('id_karyawan',auth::user()->id)
                ->  get();

                $tanggal = '';
                $batas =  31;
                $nilai = '';
                for($_i=1; $_i <= $batas; $_i++){
                    $tanggal = $tanggal . (string)$_i . ',';
                    $_check = false;
                    foreach($hari as $_data){
                        if((int)@$_data->tgl === $_i){
                            $nilai = $nilai . (string)$_data->jml . ',';
                            $_check = true;
                        }
                    }
                    if(!$_check){
                        $nilai = $nilai . '0,';
                    }
                }

                // Statistik Bulanan
                $jan = transaksi::where('bulan', 1)->where('id_karyawan',auth::user()->id)->count();
                $feb = transaksi::where('bulan', 2)->where('id_karyawan',auth::user()->id)->count();
                $mar = transaksi::where('bulan', 3)->where('id_karyawan',auth::user()->id)->count();
                $apr = transaksi::where('bulan', 4)->where('id_karyawan',auth::user()->id)->count();
                $mey = transaksi::where('bulan', 5)->where('id_karyawan',auth::user()->id)->count();
                $juni = transaksi::where('bulan', 6)->where('id_karyawan',auth::user()->id)->count();
                $july = transaksi::where('bulan', 7)->where('id_karyawan',auth::user()->id)->count();
                $aug = transaksi::where('bulan', 8)->where('id_karyawan',auth::user()->id)->count();
                $sep = transaksi::where('bulan', 9)->where('id_karyawan',auth::user()->id)->count();
                $oct = transaksi::where('bulan', 10)->where('id_karyawan',auth::user()->id)->count();
                $nov = transaksi::where('bulan', 11)->where('id_karyawan',auth::user()->id)->count();
                $dec = transaksi::where('bulan', 12)->where('id_karyawan',auth::user()->id)->count();

                return view('karyawan.index')
                    ->  with('diambil', $diambil)
                    ->  with('masuk',$masuk)
                    ->  with('selesai',$selesai)
                    ->  with('customer', $customer)
                    ->  with('sudahbayar', $sudahbayar)
                    ->  with('belumbayar', $belumbayar)
                    ->  with('_tanggal', substr($tanggal, 0,-1))
                    ->  with('_nilai', substr($nilai, 0, -1))
                    ->  with('jan', $jan)->  with('feb', $feb)->  with('mar', $mar)->  with('apr', $apr)->  with('mey', $mey)->  with('juni', $juni)->  with('july', $july)->  with('aug', $aug)->  with('sep', $sep)->  with('oct', $oct)->  with('nov', $nov)->  with('dec', $dec);
            }else{
                Auth::logout();
            }
        }
    }

}
