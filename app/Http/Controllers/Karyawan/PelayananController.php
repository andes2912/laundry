<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{transaksi,customer,harga,Notification};
use Auth;
use PDF;
use Mail;
use carbon\carbon;
use Alert;
use Session;

class PelayananController extends Controller

{

    // Halaman list order masuk
    public function index()
    {
      $order = transaksi::with('harga')->where('user_id',auth::user()->id)
      ->orderBy('id','DESC')->get();
      return view('karyawan.transaksi.order', compact('order'));
    }


    // Halaman create order
    public function create()
    {
      return view('karyawan.transaksi.addorder');
    }


    // Proses simpan order
    public function store(Request $request)
    {
      $request->validate([
        'status_payment'  => 'required',
        'customer'        => 'required',
        'email_customer'  => 'required',
        'kg'              => 'required|regex:/^[0-9.]+$/',
        'hari'            => 'required',
        'harga'           => 'required',
      ]);

      $order = new transaksi();
      $order->invoice         = $request->invoice;
      $order->tgl_transaksi   = Carbon::now()->parse($order->tgl_transaksi)->format('d-m-Y');
      $order->status_payment  = $request->status_payment;
      $order->harga_id        = $request->harga_id;
      $order->customer_id     = $request->customer_id;
      $order->user_id         = Auth::user()->id;
      $order->customer        = $request->customer;
      $order->email_customer  = $request->email_customer;
      $order->hari            = $request->hari;
      $order->kg              = $request->kg;
      $order->harga           = $request->harga;
      $order->disc            = $request->disc;
      $hitung                 = $order->kg * $order->harga;
      if ($request->disc != NULL) {
          $disc                = ($hitung * $order->disc) / 100;
          $total               = $hitung - $disc;
          $order->harga_akhir  = $total;
      } else {
        $order->harga_akhir    = $hitung;
      }

      $order->tgl             = Carbon::now()->day;
      $order->bulan           = Carbon::now()->month;
      $order->tahun           = Carbon::now()->year;
      // dd($order);

      if ($order->save()) {
        // Set to notification table
        Notification::create([
          'transaction_id' => $order->id
        ]);

        if (auth::user()->email_set == 1) {
          // Menyiapkan data Email
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

        Session::flash('success','Order Berhasil Ditambah !');
        return redirect('pelayanan');
      }
    }


    // Daftar Costomer
    public function listcs()
    {
      $customer = customer::orderBy('id','DESC')->where('user_id',auth::user()->id)->get();
      return view('karyawan.transaksi.customer', compact('customer'));
    }

    // Tambah Order
    public function addorders()
    {
      $customer = customer::where('user_id',auth::user()->id)->get();

      $y = date('Y');
      $number = mt_rand(1000, 9999);
      // Nomor Form otomatis
      $newID = $number. auth::user()->id .''.$y;
      $tgl = date('d-m-Y');

      $cek_harga = harga::where('user_id',auth::user()->id)->where('status',1)->first();
      $cek_customer = customer::select('id','user_id')->where('user_id',auth::id())->count();
      return view('karyawan.transaksi.addorder', compact('customer','newID','cek_harga','cek_customer'));
    }

    // Filter List Harga
    public function listharga(Request $request)
    {
       $list_harga = harga::select('id','harga')
        ->where('user_id',auth::user()->id)
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
    }

    // Filter List Jumlah Hari
    public function listhari(Request $request)
    {
      $list_jenis = harga::select('id','hari')
        ->where('user_id',auth::user()->id)
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
    }

    // Get nama customer
    public function getcustomer(Request $request)
    {
      $customer = customer::select('id','nama')
        ->where('id',$request->customer_id)
        ->where('user_id',auth::user()->id)
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
    }

    // Get email customer
    public function getemailcustomer(Request $request)
    {
      $customer = customer::select('id','email_customer')
        ->where('id',$request->customer_id)
        ->where('user_id',auth::user()->id)
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
    }

    // Proses Ubah Status Order
    public function ubahstatusorder(Request $request)
    {
      $statusorder = transaksi::find($request->id);
      $statusorder->update([
          'status_order' => $request->status_order,
      ]);
      if ($statusorder->status_order == 'Done') {

        // Cek email notif
        if (auth::user()->email_set == 1) {
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
        Session::flash('success','Status Laundry Berhasil Diubah !');
      }
    }

    // Proses Ubah Status Pembayaran
    public function ubahstatusbayar(Request $request)
    {
      $statusbayar = transaksi::find($request->id);
      $statusbayar->update([
          'status_payment' => $request->status_payment,
      ]);
      Session::flash('success','Status Pembayaran Berhasil Diubah !');
      return $statusbayar;
    }

    // Proses Ubah Status Diambil
    public function ubahstatusambil(Request $request)
    {
      $statusbayar = transaksi::find($request->id);
      $statusbayar->update([
          'tgl_ambil' => Carbon::today(),
          'status_order' => 'Delivery'
      ]);
      if ($statusbayar->status_order == 'Delivery') {
          // Cek email notif
          if (auth::user()->email_set == 1) {
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
        Session::flash('success','Status Laundry Berhasi Diubah !');
      }
    }

    // Tambah Customer
    public function listcsadd()
    {
      return view('karyawan.transaksi.addcustomer');
    }

    // Proses Tambah Customer
    public function addcs(Request $request)
    {
      $request->validate([
        'nama'                => 'required|unique:customers|max:25',
        'email_customer'      => 'required|unique:customers',
        'alamat'              => 'required',
        'kelamin'             => 'required',
        'no_telp'             => 'required|unique:customers',
      ]);

      $addplg = New customer();
      $addplg->nama = $request->nama;
      $addplg->email_customer = $request->email_customer;
      $addplg->alamat = $request->alamat;
      $addplg->kelamin = $request->kelamin;
      $addplg->no_telp = $request->no_telp;
      $addplg->user_id = Auth::user()->id;
      $addplg->save();

      Session::flash('success','Customer Berhasil Ditambah !');

      return redirect('list-customer');

    }

    // Invoice
    public function invoicekar(Request $request)
    {
      $invoice = transaksi::selectRaw('transaksis.*,a.jenis')
        ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.harga_id')
        ->where('transaksis.id', $request->id)
        ->where('transaksis.user_id',auth::user()->id)
        ->orderBy('id','DESC')->get();

        $data = transaksi::selectRaw('transaksis.*,a.nama,a.alamat,a.no_telp,a.kelamin,b.name,b.nama_cabang,b.alamat_cabang,b.no_telp as no_telpc')
        ->leftJoin('customers as a' , 'a.id' , '=' ,'transaksis.id')
        ->leftJoin('users as b' , 'b.id' , '=' ,'transaksis.user_id')
        ->where('transaksis.id', $request->id)
        ->where('transaksis.user_id',auth::user()->id)
        ->orderBy('id','DESC')->first();

      return view('karyawan.laporan.invoice', compact('invoice','data'));
    }

    // Cetak invoice
    public function cetakinvoice(Request $request)
    {
      $invoice = transaksi::selectRaw('transaksis.*,a.jenis')
      ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.harga_id')
      ->where('transaksis.id', $request->id)
      ->where('transaksis.user_id',auth::user()->id)
      ->orderBy('id','DESC')->get();

      $data = transaksi::selectRaw('transaksis.*,a.nama,a.alamat,a.no_telp,a.kelamin,b.name,b.nama_cabang,b.alamat_cabang,b.no_telp as no_telpc')
          ->leftJoin('customers as a' , 'a.id' , '=' ,'transaksis.id')
          ->leftJoin('users as b' , 'b.id' , '=' ,'transaksis.user_id')
          ->where('transaksis.id', $request->id)
          ->where('transaksis.user_id',auth::user()->id)
          ->orderBy('id','DESC')->first();

      $pdf = PDF::loadView('karyawan.laporan.cetak', compact('invoice','data'))->setPaper('a4', 'landscape');
      return $pdf->stream();
    }
}
