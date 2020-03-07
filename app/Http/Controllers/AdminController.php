<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\customer;
use App\transaksi;
use App\harga;
use Auth;
use DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    private $user ;
    function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->user = \Auth::user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adm()
    {
        if (Auth::user()->auth === "Admin") {
            $adm = User::where('auth','Admin')->get();
            return view('modul_admin.pengguna.admin', compact('adm'));
        } else {
            return redirect('home');
        }
    }

    public function kry()
    {
       if (Auth::user()->auth === "Admin") {
            $kry = User::where('auth','Karyawan')->get();
            return view('modul_admin.pengguna.kry', compact('kry'));
       } else {
            return redirect('home');
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->auth === "Admin") {
            return view('modul_admin.pengguna.addadm');
        } else {
            return redirect('home');
        }   
    }

    public function addkry()
    {
        if (Auth::user()->auth === "Admin") {
            return view('modul_admin.pengguna.addkry');
        } else {
            return redirect('home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->auth === "Admin") {

            if (User::where('email', $request->email)->exists()) {
                return redirect()->back()->withErrors(['errors' => 'Email Sudah Terdaftar !!']);
            } elseif (User::where('nama_cabang', $request->nama_cabang)->exists()) {
                return redirect()->back()->withErrors(['errors' => 'Nama Cabang Sudah Terdaftar !!']);
            } elseif (User::where('alamat_cabang', $request->alamat_cabang)->exists()) {
                return redirect()->back()->withErrors(['errors' => 'Alamat Cabang Sudah Terdaftar !!']);
            }

            $adduser = New User();
            $adduser->name = $request->name;
            $adduser->email = $request->email;
            $adduser->status = 'Aktif';
            $adduser->nama_cabang = $request->nama_cabang;
            $adduser->alamat = $request->alamat;
            $adduser->alamat_cabang = $request->alamat_cabang;
            $adduser->no_telp = $request->no_telp;
            $adduser->auth = $request->auth;
            $adduser->password = bcrypt('123456');
            $adduser->save();            

            if ($adduser->auth == "Admin") {
                return redirect('adm');
            } else {
                return redirect('kry');
            }
            
        } else {
            return redirect('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->auth === "Admin") {
            $edit = User::find($id);
            if ($edit->auth == "Admin") {
                return view('modul_admin.pengguna.editadm', compact('edit'));
            } else {
                return view('modul_admin.pengguna.editkry', compact('edit'));
            }
            
        } else {
            return redirect('home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->auth === "Admin") {
            $adduser = User::find($id);
            $adduser->name = $request->name;
            $adduser->email = $request->email;
            $adduser->status = $request->status;
            $adduser->nama_cabang = $request->nama_cabang;
            $adduser->alamat = $request->alamat;
            $adduser->alamat_cabang = $request->alamat_cabang;
            $adduser->no_telp = $request->no_telp;
            $adduser->auth = $request->auth;
            $adduser->save();

            if ($adduser->auth == "Admin") {
                return redirect('adm');
            } else {
                return redirect('kry');
            }
            
        } else {
            return redirect('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->auth == "Admin") {
            $del = User::find($id);
            $del->delete();

            if ($del->auth == "Admin") {
                return redirect('adm');
            } else {
                return redirect('kry');
            }
            
        } else {
            return redirect('home');
        }
    }

// Modul Customer
    public function customer()
    {
        if (Auth::user()->auth == "Admin") {
            $customer = customer::all();
            return view('modul_admin.customer.index', compact('customer'));
        } else {
            return redirect('home');
        }
    }

    public function addcustomer()
    {
        if (Auth::user()->auth == "Admin") {
            return view('modul_admin.customer.create');
        } else {
            return redirect('home');
        }
    }

    public function storecustomer(Request $request)
    {
        if (Auth::user()->auth == "Admin") {
            $addplg = New customer();
            $addplg->nama = $request->nama;
            $addplg->alamat = $request->alamat;
            $addplg->kelamin = $request->kelamin;
            $addplg->no_telp = $request->no_telp;
            $addplg->save();

            return redirect('customer');
        } else {
            return redirect('home');
        }
    }

    public function editcustomer($id_customer)
    {
       if (Auth::user()->auth == "Admin") {
            $edit = customer::find($id_customer);
            return view('modul_admin.customer.edit', compact('edit'));
       } else {
           return redirect('home');
       }
    }

    public function updatecustomer(Request $request,$id_customer)
    {
        if (Auth::user()->auth == "Admin") {
            $addplg =  customer::find($id_customer);
            $addplg->nama = $request->nama;
            $addplg->alamat = $request->alamat;
            $addplg->kelamin = $request->kelamin;
            $addplg->no_telp = $request->no_telp;
            $addplg->save();

            return redirect('customer');
        } else {
            return redirect('home');
        }
    }

    public function deletecustomer($id_customer)
    {
        if (Auth::user()->auth == "Admin") {
            $del = customer::find($id_customer);
            $del->delete();
                return redirect('customer');
        } else {
            return redirect('home');
        }
    }

// Modul Data Laundri
    public function datatransaksi()
    {
        if (Auth::user()->auth == "Admin") {
            $transaksi = transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.tgl_transaksi,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg,transaksis.hari,transaksis.harga,a.jenis')
            ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.id_jenis')
            ->orderBy('id','DESC')->get();
            return view('modul_admin.laundri.transaksi', compact('transaksi'));
        } else {
            return redirect('home');
        }
    }

    // Tambah dan Data Harga
    public function dataharga()
    {
       if (Auth::user()->auth == "Admin") {
            $harga = harga::orderBy('id','DESC')->get(); // Ambil data harga
            $karyawan = User::where('auth','Karyawan')->first(); // Cek Apakah sudah ada karyawan atau belum 
            return view('modul_admin.laundri.harga', compact('harga','karyawan'));
       } else {
           return redirect('home');
       }
       
    }

    // Proses Simpan Harga
    public function hargastore(Request $request)
    {
        if (Auth::user()->auth == "Admin") {
            
            $addharga = new harga();
            $addharga->id_cabang = $request->id_cabang;
            $addharga->jenis = $request->jenis;
            $addharga->kg = $request->kg;
            $addharga->harga = $request->harga;
            $addharga->hari = $request->hari;
            $addharga->status = 1;
            $addharga->save();

            return redirect('data-harga');
        } else {
            return redirect('home');
        }
    }

    public function hargaedit(Request $request)
    {
       if (Auth::user()->auth == "Admin") {
        $editharga = harga::find($request->id_harga);
        $editharga->update([
            'jenis' => $request->jenis,
            'kg'    => $request->kg,
            'harga' => $request->harga,
            'hari' => $request->hari,
            'status' => $request->status,
        ]);
        return $editharga;
       } else {
           return redirect('/home');
       }
       
    }

// Laporan

    // Invoice
    public function invoice( Request $request,$id)
    {
        if (Auth::user()->auth == "Admin") {
            $invoice = transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.tgl_transaksi,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg,transaksis.hari,transaksis.harga,a.jenis')
            ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.id_jenis')
            ->where('transaksis.id', $request->id)
            ->orderBy('id','DESC')->get();

            $data = transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.id_karyawan,transaksis.tgl_transaksi,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg,transaksis.tgl_ambil,transaksis.invoice,a.nama,a.alamat,a.no_telp,a.kelamin,b.name,b.nama_cabang,b.alamat_cabang,b.telp_cabang')
            ->leftJoin('customers as a' , 'a.id_customer' , '=' ,'transaksis.id_customer')
            ->leftJoin('users as b' , 'b.id' , '=' ,'transaksis.id_karyawan')
            ->where('transaksis.id', $request->id)
            ->orderBy('id','DESC')->first();

            return view('modul_admin.laporan.invoice', compact('invoice','data'));
        } else {
            return redirect('/home');
        }
    }

    // Notifikasi 
    public function notif(Request $request)
    {
        $aktif = transaksi::find($request->id);
        $aktif->update([
            'notif' => 1
        ]);
        return redirect('data-transaksi');
    }

    // Hitung Jumlah Transaksi Keseluruhan
    public function jmlTransaksi(Request $request)
    {
        $jml = customer::select(DB::raw('t.id_customer,t.nama,t.alamat,t.kelamin,t.no_telp'))
        ->from(DB::raw('(SELECT * from customers order by created_at DESC) t'))
        ->leftJoin('transaksis as a' ,'a.id_customer' , '=' , 't.id_customer')
        ->groupBy('t.id_customer')
        ->get();

        // $jm = transaksi::select(DB::raw('t.kg,t.id_customer'))
        // ->from(DB::raw('(SELECT * from transaksis order by created_at DESC) t'))
        // ->groupby('t.kg')
        // // ->where('t.id_customer',1)
        // // ->sum('t.kg')
        // ->count();

        // $jm = transaksi::orderby('created_at','DESC')->first();

        // $jml = DB::table('transaksis')->sum('kg')->get();
        // $jml = customer::selectRaw('customers.id_customer,customers.nama')
        // ->leftJoin('transaksis as A' , function($join){
        //     $join->on('a.id_customer' ,'=' ,'customers.id_customer');
        // })
        // ->get();

        // $jml = customer::all();

        return view('modul_admin.customer.jmltransaksi', compact('jml','jm'));
    }
}
