<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transaksi;
use App\customer;
use App\harga;
use Auth;
use PDF;
use Mail;
use carbon\carbon;
use Alert;

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
            $order = transaksi::selectRaw('transaksis.id,transaksis.invoice,transaksis.id_customer,transaksis.tgl_transaksi,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg,transaksis.hari,transaksis.harga,transaksis.id_karyawan,transaksis.harga_akhir,a.jenis')
            ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.id_jenis')
            ->where('id_karyawan',auth::user()->id)
            ->orderBy('id','DESC')->get();
            return view('karyawan.transaksi.order', compact('order'));
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
           
            return view('karyawan.transaksi.addorder');
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

            try {
                $order = new transaksi();
                $order->invoice = $request->invoice;
                $order->tgl_transaksi = Carbon::now()->parse($order->tgl_transaksi)->format('d-m-Y');
                $order->status_order = $request->status_order;
                $order->status_payment = $request->status_payment;
                $order->id_jenis = $request->id_jenis;
                $order->id_customer = $request->id_customer;
                $order->id_karyawan = Auth::user()->id;
                $order->customer = $request->customer;
                $order->email_customer = $request->email_customer;
                $order->hari    = $request->hari;
                $order->kg      = $request->kg;
                $order->harga   = $request->harga;
                $order->disc    = $request->disc;
                $hitung = ( $order->kg * $order->harga) / 1000;
                $disc = ($hitung * $order->disc) / 100;
                $total = $hitung - $disc;
                $order->harga_akhir = $total;
                $order->notif   = 0;
                $order->notif_admin   = 0;
                $order->tgl     = Carbon::now()->day;
                $order->bulan     = Carbon::now()->month;
                $order->tahun     = Carbon::now()->year;
                if ($order->save()) {

                    // Menyiapkan data
                    $email = $order->email_customer;
                    $data = array(
                        'invoice' => $order->invoice,
                        'customer' => $order->customer,
                        'tgl_transaksi' => $order->tgl_transaksi,
                    );
                        
                    // Kirim Email
                    Mail::send('karyawan.email.email', $data, function($mail) use ($email, $data){
                    $mail->to($email,'no-replay')
                            ->subject("E-Laundry - Nomor Invoice");
                    $mail->from('laundri.dev@gmail.com');
                    });
                }
                alert()->success('Data Laundry Berhasil Ditambah');
            } catch (\Throwable $e) {
                alert()->error('SMTP MAIL BELUM DI SETTING !');
            }

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
            $customer = customer::orderBy('id_customer','DESC')->where('id_karyawan',auth::user()->id)->get();
            return view('karyawan.transaksi.customer', compact('customer'));
        } else {
            return redirect('home');
        }
    }

    // Tambah Order
    public function addorders()
    {
        if (Auth::user()->auth == "Karyawan") {
            $customer = customer::where('id_karyawan',auth::user()->id)->get();

            $y = date('Y');
            $number = mt_rand(1000, 9999);
            // Nomor Form otomatis
            $newID = $number. auth::user()->id .''.$y;
            $tgl = date('d-m-Y');

            $cek_harga = harga::where('id_cabang',auth::user()->id)->first();
            return view('karyawan.transaksi.addorder', compact('customer','newID','cek_harga'));
        } else {
            return redirect('home');
        }
    }

    // Filter List Harga
    public function listharga(Request $request)
    {
        if (Auth::user()->auth == "Karyawan") {
            $list_harga = harga::select('id','harga')
            ->where('id_cabang',auth::user()->id)
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
        ->where('id_cabang',auth::user()->id)
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

    public function getcustomer(Request $request)
    {
        if (auth::user()->auth == "Karyawan") {
            $customer = customer::select('id_customer','nama')
            ->where('id_customer',$request->id_customer)
            ->where('id_karyawan',auth::user()->id)
            ->get();

            $select = '';
            $select .= '
                    <div class="form-group has-success" hidden>
                    <select class="form-control" name="customer">
                    ';
                    foreach ($customer as $item) {
            $select .= '<option value="'.$item->nama.'">'.$item->nama.'</option>';
                        }'
                        </select>
                        </div>';
            return $select;

        } else {
            return redirect('/home');
        }
    }

    public function getemailcustomer(Request $request)
    {
        if (auth::user()->auth == "Karyawan") {
            $customer = customer::select('id_customer','email_customer')
            ->where('id_customer',$request->id_customer)
            ->where('id_karyawan',auth::user()->id)
            ->get();

            $select = '';
            $select .= '
                    <div class="form-group has-success" hidden>
                    <select class="form-control" name="email_customer">
                    ';
                    foreach ($customer as $item) {
            $select .= '<option value="'.$item->email_customer.'">'.$item->email_customer.'</option>';
                        }'
                        </select>
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
            try {
                $statusorder = transaksi::find($request->id);
                $statusorder->update([
                    'status_order' => $request->status_order,
                ]);
                if ($statusorder->status_order == 'Selesai') {
                    // Menyiapkan data
                    $email = $statusorder->email_customer;
                    $data = array(
                        'invoice' => $statusorder->invoice,
                        'customer' => $statusorder->customer,
                        'tgl_transaksi' => $statusorder->tgl_transaksi,
                    );
                        
                    // Kirim Email
                    Mail::send('karyawan.email.selesai', $data, function($mail) use ($email, $data){
                    $mail->to($email,'no-replay')
                            ->subject("E-Laundry - Laundry Selesai");
                    $mail->from('laundri.dev@gmail.com');
                    });
                }
            } catch (\Throwable $th) {
                alert()->error('SMTP MAIL BELUM DI SETTING !');
            }
        } else {
            return redirect('/home');
        }
    }

    // Proses Ubah Status Pembayaran
    public function ubahstatusbayar(Request $request)
    {
        if (Auth::user()->auth == "Karyawan") {
            try {
                $statusbayar = transaksi::find($request->id);
                $statusbayar->update([
                    'status_payment' => $request->status_payment,
                ]);
                return $statusbayar;
            } catch (\Throwable $th) {
                alert()->error('Ups ada yang tidak beres !');
            }
        } else {
            return redirect('/home');
        }
    }

    // Proses Ubah Status Diambil
    public function ubahstatusambil(Request $request)
    {
        if (Auth::user()->auth == "Karyawan") {
            try {
                $statusbayar = transaksi::find($request->id);
                $statusbayar->update([
                    'tgl_ambil' => Carbon::today(),
                    'status_order' => 'Diambil'
                ]);
                if ($statusbayar->status_order == 'Diambil') {
                    // Menyiapkan data
                    $email = $statusbayar->email_customer;
                    $data = array(
                        'invoice' => $statusbayar->invoice,
                        'customer' => $statusbayar->customer,
                        'tgl_transaksi' => $statusbayar->tgl_transaksi,
                        'tgl_ambil' => $statusbayar->tgl_ambil,
                    );
                        
                    // Kirim Email
                    Mail::send('karyawan.email.diambil', $data, function($mail) use ($email, $data){
                    $mail->to($email,'no-replay')
                            ->subject("E-Laundry - Laundry Sudah Diambil");
                    $mail->from('laundri.dev@gmail.com');
                    });
                }
            } catch (\Throwable $th) {
                alert()->error('SMTP MAIL BELUM DI SETTING !');
            }
        } else {
           return redirect('/home');
        }
       
    }

    // Tambah Customer
    public function listcsadd()
    {
        if (Auth::user()->auth == "Karyawan") {
            return view('karyawan.transaksi.addcustomer');
        } else {
            return redirect('/home');
        }
        
    }

    // Proses Tambah Customer
    public function addcs(Request $request)
    {
        if (Auth::user()->auth == "Karyawan") {
            try {
                    $addplg = New customer();
                $addplg->nama = $request->nama;
                $addplg->email_customer = $request->email_customer;
                $addplg->alamat = $request->alamat;
                $addplg->kelamin = $request->kelamin;
                $addplg->no_telp = $request->no_telp;
                $addplg->id_karyawan = auth::user()->id;
                $addplg->save();

                alert()->success('Data Customer Berhasil Ditambah');
            } catch (\Throwable $th) {
                alert()->success('Data Customer Gagal Ditambah !');
            }
            return redirect('list-customer');
        } else {
            return redirect('/home');
        }
        
    }

    // Invoice
    public function invoicekar(Request $request)
    {
        if (Auth::user()->auth == "Karyawan") {
            $invoice = transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.tgl_transaksi,transaksis.tgl_ambil,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg,transaksis.hari,transaksis.harga,transaksis.disc,transaksis.id_karyawan,transaksis.harga_akhir,a.jenis')
            ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.id_jenis')
            ->where('transaksis.id', $request->id)
            ->where('transaksis.id_karyawan',auth::user()->id)
            ->orderBy('id','DESC')->get();

            $data = transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.id_karyawan,transaksis.tgl_transaksi,transaksis.tgl_ambil,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg,transaksis.tgl_ambil,transaksis.disc,transaksis.invoice,transaksis.id_karyawan,transaksis.harga_akhir,a.nama,a.alamat,a.no_telp,a.kelamin,b.name,b.nama_cabang,b.alamat_cabang,b.no_telp as no_telpc')
            ->leftJoin('customers as a' , 'a.id_customer' , '=' ,'transaksis.id_customer')
            ->leftJoin('users as b' , 'b.id' , '=' ,'transaksis.id_karyawan')
            ->where('transaksis.id', $request->id)
            ->where('transaksis.id_karyawan',auth::user()->id)
            ->orderBy('id','DESC')->first();
            
        return view('karyawan.laporan.invoice', compact('invoice','data'));
        } else {
            return redirect('/home');
        }
    }

    public function cetakinvoice(Request $request)
    {
        //GET DATA BERDASARKAN ID
        $invoice = transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.tgl_transaksi,transaksis.tgl_ambil,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg,transaksis.harga_akhir,transaksis.hari,transaksis.harga,transaksis.disc,transaksis.id_karyawan,a.jenis')
        ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.id_jenis')
        ->where('transaksis.id', $request->id)
        ->where('transaksis.id_karyawan',auth::user()->id)
        ->orderBy('id','DESC')->get();

        $data = transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.id_karyawan,transaksis.tgl_transaksi,transaksis.tgl_ambil,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg,transaksis.tgl_ambil,transaksis.invoice,transaksis.disc,transaksis.id_karyawan,transaksis.harga_akhir,a.nama,a.alamat,a.no_telp,a.kelamin,b.name,b.nama_cabang,b.alamat_cabang,b.no_telp as no_telpc,transaksis.created_at')
            ->leftJoin('customers as a' , 'a.id_customer' , '=' ,'transaksis.id_customer')
            ->leftJoin('users as b' , 'b.id' , '=' ,'transaksis.id_karyawan')
            ->where('transaksis.id', $request->id)
            ->where('transaksis.id_karyawan',auth::user()->id)
            ->orderBy('id','DESC')->first();

        $pdf = PDF::loadView('karyawan.laporan.cetak', compact('invoice','data'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
