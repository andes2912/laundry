<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transaksi;
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
                $data = DB::table("transaksis")
                    ->select("id" ,DB::raw("(COUNT(*)) as customer"))
                    ->orderBy('created_at')
                    ->groupBy(DB::raw("MONTH(created_at)"))
                    ->count();

                // return view('modul_admin.index', compact('masuk','selesai','diambil','nilai','tanggal'));
                return view('modul_admin.index')
                    ->  with('data', $data)
                    ->  with('masuk',$masuk)
                    ->  with('selesai',$selesai)
                    ->  with('diambil',$diambil);
            } elseif(Auth::user()->auth === "Karyawan") {
                return view('pelayanan.index');
            }else{
                Auth::logout();
            }
        }
    }

}
