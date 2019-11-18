<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transaksi;
use App\customer;
use App\harga;
use Auth;
use PDF;
use carbon\carbon;

class PelayananController extends Controller

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
    public function index()
    {
        if (Auth::user()->auth == "Karyawan") {
            $order = transaksi::selectRaw('transaksis.id,transaksis.invoice,transaksis.id_customer,transaksis.tgl_transaksi,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg_transaksi,transaksis.hari,transaksis.harga,a.jenis')
            ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.id_jenis')
            ->orderBy('id','DESC')->get();
            return view('pelayanan.transaksi.order', compact('order'));
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
        if (Auth::user()->auth == "Karyawan") {
           
            return view('pelayanan.transaksi.addorder');
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
        if (Auth::user()->auth == "Karyawan") {

            $invoice = transaksi::selectRaw('LPAD(CONVERT(COUNT("id") + 1, char(8)) , 8,"0") as invoice')-> first();
            $order = new transaksi();
            $order->invoice = '#'. $invoice->invoice;
            $order->tgl_transaksi = Carbon::now();
            $order->status_order = $request->status_order;
            $order->status_payment = $request->status_payment;
            $order->id_jenis = $request->id_jenis;
            $order->id_customer = $request->id_customer;
            $order->id_karyawan = Auth::user()->id;
            $order->customer = $request->customer;
            $order->kg_transaksi      = $request->kg_transaksi;
            $order->hari    = $request->hari;
            $order->harga   = $request->harga;
            $order->notif   = 0;
            $order->disc    = $request->disc;
            $order->tgl     = Carbon::now()->day;
            // dd($order);
            $order->save();

            return redirect('pelayanan');
        } else {
            return redirect('/home');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Daftar Costomer
    public function listcs()
    {
        if (Auth::user()->auth == "Karyawan") {
            $customer = customer::orderBy('id_customer','DESC')->get();
            return view('pelayanan.transaksi.customer', compact('customer'));
        } else {
            return redirect('home');
        }
    }

    // Tambah Order
    public function addorders($id_customer)
    {
        if (Auth::user()->auth == "Karyawan") {
            $addorder =customer::find($id_customer);
            return view('pelayanan.transaksi.addorder', compact('addorder'));
        } else {
            return redirect('home');
        }
        
    }

    // Filter List Harga
    public function listharga(Request $request)
    {
        if (Auth::user()->auth == "Karyawan") {
            $list_harga = harga::select('id','harga')
            ->where('id',$request->id)
            ->get();
            $select = '';
            $select .= '
                        <div class="form-group has-success">
                        <label for="id" class="control-label">Harga</label>
                        <select id="harga" class="form-control" name="harga" value="harga">
                        ';
                        foreach ($list_harga as $studi) {
            $select .= '<option value="'.$studi->harga.'">'.$studi->harga.'</option>';
                        }'
                        </select>
                        </div>
                        </div>';
            return $select;
        } else {
            return redirect('/home');
        }
    }

    // Filter List Jumlah Hari
    public function listhari(Request $request)
    {
       if (Auth::user()->auth == "Karyawan") {
        $list_jenis = harga::select('id','hari')
        ->where('id',$request->id)
        ->get();
        $select = '';
        $select .= '
                    <div class="form-group has-success">
                    <label for="id" class="control-label">Pilih Hari</label>
                    <select id="hari" class="form-control" name="hari" value="hari">
                    ';
                    foreach ($list_jenis as $hari) {
        $select .= '<option value="'.$hari->hari.'">'.$hari->hari.'</option>';
                    }'
                    </select>
                    </div>
                    </div>';
        return $select;
       } else {
           return redirect('/home');
       }
       
    }

    // Proses Ubah Status Order
    public function ubahstatusorder(Request $request)
    {
        if (Auth::user()->auth == "Karyawan") {
            $statusorder = transaksi::find($request->id);
            $statusorder->update([
                'status_order' => $request->status_order,
            ]);
            return $statusorder;
        } else {
            return redirect('/home');
        }
        
    }

    // Proses Ubah Status Pembayaran
    public function ubahstatusbayar(Request $request)
    {
       if (Auth::user()->auth == "Karyawan") {
        $statusbayar = transaksi::find($request->id);
        $statusbayar->update([
            'status_payment' => $request->status_payment,
        ]);
        return $statusbayar;
       } else {
           return redirect('/home');
       }
       
    }

    // Proses Ubah Status Diambil
    public function ubahstatusambil(Request $request)
    {
       if (Auth::user()->auth == "Karyawan") {
        $statusbayar = transaksi::find($request->id);
        $statusbayar->update([
            'tgl_ambil' => Carbon::today(),
            'status_order' => 'Diambil'
        ]);
        return $statusbayar;
       } else {
           return redirect('/home');
       }
       
    }

    // Tambah Customer
    public function listcsadd()
    {
        if (Auth::user()->auth == "Karyawan") {
            return view('pelayanan.transaksi.addcustomer');
        } else {
            return redirect('/home');
        }
        
    }

    // Proses Tambah Customer
    public function addcs(Request $request)
    {
        if (Auth::user()->auth == "Karyawan") {
            $addplg = New customer();
            $addplg->nama = $request->nama;
            $addplg->alamat = $request->alamat;
            $addplg->kelamin = $request->kelamin;
            $addplg->no_telp = $request->no_telp;
            $addplg->save();

            $addplg->save();

        return redirect('list-customer');
        } else {
            return redirect('/home');
        }
        
    }

    // Invoice
    public function invoicekar(Request $request)
    {
        if (Auth::user()->auth == "Karyawan") {
            $invoice = transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.tgl_transaksi,transaksis.tgl_ambil,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg_transaksi,transaksis.hari,transaksis.harga,transaksis.disc,a.jenis')
            ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.id_jenis')
            ->where('transaksis.id', $request->id)
            ->orderBy('id','DESC')->get();

            $data = transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.id_karyawan,transaksis.tgl_transaksi,transaksis.tgl_ambil,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg_transaksi,transaksis.tgl_ambil,transaksis.disc,transaksis.invoice,a.nama,a.alamat,a.no_telp,a.kelamin,b.name,b.nama_cabang,b.alamat_cabang,b.telp_cabang')
            ->leftJoin('customers as a' , 'a.id_customer' , '=' ,'transaksis.id_customer')
            ->leftJoin('users as b' , 'b.id' , '=' ,'transaksis.id_karyawan')
            ->where('transaksis.id', $request->id)
            ->orderBy('id','DESC')->first();
            
        return view('pelayanan.laporan.invoice', compact('invoice','data'));
        } else {
            return redirect('/home');
        }
    }

    public function cetakinvoice(Request $request)
    {
        //GET DATA BERDASARKAN ID
        $invoice = transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.tgl_transaksi,transaksis.tgl_ambil,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg_transaksi,transaksis.hari,transaksis.harga,transaksis.disc,a.jenis')
        ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.id_jenis')
        ->where('transaksis.id', $request->id)
        ->orderBy('id','DESC')->get();

        $data = transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.id_karyawan,transaksis.tgl_transaksi,transaksis.tgl_ambil,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg_transaksi,transaksis.tgl_ambil,transaksis.invoice,transaksis.disc,a.nama,a.alamat,a.no_telp,a.kelamin,b.name,b.nama_cabang,b.alamat_cabang,b.telp_cabang,transaksis.created_at')
            ->leftJoin('customers as a' , 'a.id_customer' , '=' ,'transaksis.id_customer')
            ->leftJoin('users as b' , 'b.id' , '=' ,'transaksis.id_karyawan')
            ->where('transaksis.id', $request->id)
            ->orderBy('id','DESC')->first();

        $pdf = PDF::loadView('pelayanan.laporan.cetak', compact('invoice','data'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
