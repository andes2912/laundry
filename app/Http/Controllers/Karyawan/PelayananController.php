<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{transaksi,user,harga};
use App\Http\Requests\AddCustomerRequest;
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
          $jenisPakaian = harga::where('id', $order->harga_id)->first();
          $data = array(
              'invoice' => $order->invoice,
              'customer' => $order->customer,
              'tgl_transaksi' => $order->tgl_transaksi,
              'pakaian'       => $jenisPakaian->jenis,
              'berat'         => $order->kg,
              'harga'         => $order->harga,
              'harga_disc'    => ($hitung * $order->disc) / 100,
              'disc'          => $order->disc,
              'total'         => $order->kg * $order->harga,
              'harga_akhir'   => $order->harga_akhir,
              'laundry_name'  => Auth::user()->nama_cabang
          );

          // Kirim Email
          Mail::send('emails.orders', $data, function($mail) use ($email, $data){
          $mail->to($email,'no-replay')
                  ->subject("E-Laundry - Invoice")
                  ->from($address = Auth::user()->email, $name = Auth::user()->nama_cabang);
          });
        }

        Session::flash('success','Order Berhasil Ditambah !');
        return redirect('pelayanan');
      }
    }

    // Tambah Order
    public function addorders()
    {
      $customer = User::where('karyawan_id',Auth::user()->id)->get();

      $y = date('Y');
      $number = mt_rand(1000, 9999);
      // Nomor Form otomatis
      $newID = $number. Auth::user()->id .''.$y;
      $tgl = date('d-m-Y');

      $cek_harga = harga::where('user_id',Auth::user()->id)->where('status',1)->first();
      $cek_customer = User::select('id','karyawan_id')->where('karyawan_id',Auth::id())->count();
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
        $select .= '<option value="'.$studi->harga.'">'.'Rp. ' .number_format($studi->harga,0,",",".").'</option>';
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


    // Update Status Laundry
    public function updateStatusLaundry(Request $request)
    {
      $transaksi = transaksi::find($request->id);
      if ($transaksi->status_payment == 'Pending') {
        $transaksi->update([
          'status_payment' => 'Success'
        ]);
      } elseif ($transaksi->status_payment == 'Success') {
        if ($transaksi->status_order == 'Process') {
          $transaksi->update([
            'status_order' => 'Done'
          ]);

            // Cek email notif
            if (setNotificationEmail(1) == 1) {

              // Menyiapkan data
              $email = $transaksi->email_customer;
              $data = array(
                  'invoice'         => $transaksi->invoice,
                  'customer'        => $transaksi->customer,
                  'nama_laundry'    => Auth::user()->nama_cabang,
                  'alamat_laundry'  => Auth::user()->alamat_cabang,
              );

              // Kirim Email
              Mail::send('emails.done', $data, function($mail) use ($email, $data){
              $mail->to($email,'no-replay')
                      ->subject("E-Laundry - Laundry Selesai")
                      ->from($address = Auth::user()->email, $name = Auth::user()->nama_cabang);
              });
            }

            // Cek status notif untuk telegram
            if (setNotificationTelegramFinish(1) == 1) {
              $transaksi->notify(new OrderSelesai());
            }

            // Notifikasi WhatsApp
            if (setNotificationWhatsappOrderSelesai(1) == 1 && getTokenWhatsapp() != null) {
              $waCustomer = $transaksi->customers->no_telp; // get nomor whatsapp customer
              $nameCustomer = $transaksi->customers->nama; // get name customer
              notificationWhatsapp(
                getTokenWhatsapp(), // Token
                $waCustomer, // nomor whatsapp
                'Halo Kak '.$nameCustomer.' Laundry kamu sudah selesai dan sudah bisa diambil nih :) ' // pesan
              );
            }

        } elseif ($transaksi->status_order == 'Done') {
          $transaksi->update([
            'status_order' => 'Delivery'
          ]);
        }
      }

      if ($transaksi->status_payment == 'Success') {
          Session::flash('success', "Status Pembayaran Berhasil Diubah !");
      }
      if($transaksi->status_order == 'Done' || $transaksi->status_order == 'Delivery') {
          Session::flash('success', "Status Laundry Berhasil Diubah !");
      }
    }
}
