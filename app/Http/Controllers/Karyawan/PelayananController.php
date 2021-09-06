<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{transaksi,customer,harga};
use Auth;
use PDF;
use Mail;
use carbon\carbon;
use Alert;
use Session;
use App\Notifications\{OrderMasuk,OrderSelesai};

class PelayananController extends Controller

{

    // Halaman list order masuk
    public function index()
    {
      $order = transaksi::with('price')->where('user_id',Auth::user()->id)
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
        'status_payment'    => 'required',
        'kg'                => 'required|regex:/^[0-9.]+$/',
        'hari'              => 'required',
        'harga'             => 'required',
        'jenis_pembayaran'  => 'required'
      ]);

      $order = new transaksi();
      $order->invoice         = $request->invoice;
      $order->tgl_transaksi   = Carbon::now()->parse($order->tgl_transaksi)->format('d-m-Y');
      $order->status_payment  = $request->status_payment;
      $order->harga_id        = $request->harga_id;
      $order->customer_id     = $request->customer_id;
      $order->user_id         = Auth::user()->id;
      $order->customer        = namaCustomer($order->customer_id);
      $order->email_customer  = email_customer($order->customer_id);
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
      $order->jenis_pembayaran  = $request->jenis_pembayaran;
      $order->tgl               = Carbon::now()->day;
      $order->bulan             = Carbon::now()->month;
      $order->tahun             = Carbon::now()->year;
      $order->save();

      if ($order) {
        // Notification Telegram
        if (setNotificationTelegramIn(1) == 1) {
          $order->notify(new OrderMasuk());
        }

        // Notification email
        if (setNotificationEmail(1) == 1) {
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
      $customer = customer::orderBy('id','DESC')->where('user_id',Auth::user()->id)->get();
      return view('karyawan.transaksi.customer', compact('customer'));
    }

    // Tambah Order
    public function addorders()
    {
      $customer = customer::where('user_id',Auth::user()->id)->get();

      $y = date('Y');
      $number = mt_rand(1000, 9999);
      // Nomor Form otomatis
      $newID = $number. Auth::user()->id .''.$y;
      $tgl = date('d-m-Y');

      $cek_harga = harga::where('user_id',Auth::user()->id)->where('status',1)->first();
      $cek_customer = customer::select('id','user_id')->where('user_id',Auth::id())->count();
      return view('karyawan.transaksi.addorder', compact('customer','newID','cek_harga','cek_customer'));
    }

    // Filter List Harga
    public function listharga(Request $request)
    {
       $list_harga = harga::select('id','harga')
        ->where('user_id',Auth::user()->id)
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
        ->where('user_id',Auth::user()->id)
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

    // Proses Ubah Status Order
    public function ubahstatusorder(Request $request)
    {
      $statusorder = transaksi::find($request->id);
      $statusorder->update([
          'status_order' => $request->status_order,
      ]);
      if ($statusorder->status_order == 'Done') {

        // Cek email notif
        if (setNotificationEmail(1) == 1) {

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

        // Cek status notif untuk telegram
        if (setNotificationTelegramFinish(1) == 1) {
          $statusorder->notify(new OrderSelesai());
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
          if (setNotificationEmail(1) == 1) {
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
}
