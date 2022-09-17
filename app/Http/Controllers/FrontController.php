<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{transaksi,PageSettings, User};

class FrontController extends Controller
{

    //Index
    public function index(Request $request)
    {
        $setpage = PageSettings::first();
        $cari = $request->cari;
        $search = transaksi::with('customers')
        ->whereHas('customers', function($q) use ($cari) {
            $q->where('no_telp', 'like', "%".$cari."%");
        })
        ->orwhere('invoice', 'like', "%".$cari."%")->first();
        return view('frontend.index', compact('setpage','search'));
    }

    //Search
    public function search(Request $request)
    {
        $cari = $request->cari;

        $setpage = PageSettings::first();
        $search = transaksi::with('customers')
        ->whereHas('customers', function($q) use ($cari) {
            $q->where('no_telp', 'like', "%".$cari."%");
        })
        ->orwhere('invoice', 'like', "%".$cari."%")->first();
        if(!$search){
            return redirect('/');
        }
        return view('frontend.search', compact('setpage','search'));
    }

    // History
    public function history(Request $request)
    {
        $setpage = PageSettings::first();

        $history = User::where('no_telp', $request->no_telp)
        ->with('transaksiCustomer', function($a) {
            $a->orderBy('id','desc');
        })
        ->whereHas('transaksiCustomer')
        ->get();
        if(!$history){
            return redirect('/');
        }
        return view('frontend.history', compact('setpage','history'));
    }
}
