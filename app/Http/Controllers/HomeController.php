<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transaksi;
use App\customer;
use Auth;
use DB;

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

                return view('modul_admin.index')
                    ->  with('data', $data)
                    ->  with('masuk',$masuk)
                    ->  with('selesai',$selesai)
                    ->  with('customer', $customer)
                    ->  with('sudahbayar', $sudahbayar)
                    ->  with('belumbayar', $belumbayar)
                    ->  with('_tanggal', substr($tanggal, 0,-1))
                    ->  with('_nilai', substr($nilai, 0, -1))
                    ->  with('diambil',$diambil);

            } elseif(Auth::user()->auth === "Karyawan") {
                $masuk = transaksi::whereIN('status_order',['Proses','Selesai','Diambil'])->count();
                $selesai = transaksi::where('status_order','Selesai')->count();
                $diambil = transaksi::where('status_order','Diambil')->count();
                $customer = customer::all();
                $sudahbayar = transaksi::where('status_payment','Lunas')->count();
                $belumbayar = transaksi::where('status_payment','Belum')->count();

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

                return view('pelayanan.index')
                    ->  with('diambil', $diambil)
                    ->  with('masuk',$masuk)
                    ->  with('selesai',$selesai)
                    ->  with('customer', $customer)
                    ->  with('sudahbayar', $sudahbayar)
                    ->  with('belumbayar', $belumbayar)
                    ->  with('_tanggal', substr($tanggal, 0,-1))
                    ->  with('_nilai', substr($nilai, 0, -1));
            }else{
                Auth::logout();
            }
        }
    }

}
