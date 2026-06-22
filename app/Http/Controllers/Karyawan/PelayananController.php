<?php

namespace App\Http\Controllers\Karyawan;

use carbon\carbon;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddOrderRequest;
use Illuminate\Support\Facades\Session;
use App\Models\{transaksi,User,harga,DataBank, Notification};
use App\Jobs\DoneCustomerJob;
use App\Jobs\OrderCustomerJob;
use App\Notifications\{OrderMasuk,OrderSelesai};

class PelayananController extends Controller

{

    // Halaman list order masuk
    public function index()
    {
      $order = transaksi::with('price','items')->where('user_id',Auth::user()->id)
      ->orderBy('id','DESC')->get();
      return view('karyawan.transaksi.order', compact('order'));
    }

    // Proses simpan order (multi-item)
    public function store(AddOrderRequest $request)
    {
      try {
        DB::beginTransaction();

        $items = $request->input('items', []);
        $disc  = (float) $request->input('disc', 0);

        // 1. Lookup semua harga sekaligus
        $hargaIds  = collect($items)->pluck('harga_id')->unique();
        $hargaMap  = harga::whereIn('id', $hargaIds)->get()->keyBy('id');

        // 2. Hitung subtotal per item + grand total
        $itemRows = [];
        $grandTotal = 0;
        $longestHari = 0;
        foreach ($items as $it) {
            $h = $hargaMap->get($it['harga_id']);
            if (!$h) continue;
            $kg       = (float) $it['kg'];
            $subtotal = (int) round($kg * $h->harga);
            $grandTotal += $subtotal;
            $longestHari = max($longestHari, (int) $h->hari);

            $itemRows[] = [
                'harga_id' => $h->id,
                'jenis'    => $h->jenis,
                'kg'       => $kg,
                'hari'     => (int) $h->hari,
                'harga'    => (int) $h->harga,
                'subtotal' => $subtotal,
            ];
        }

        if (empty($itemRows)) {
            DB::rollBack();
            return back()->withInput()->withErrors(['items' => 'Item tidak valid.']);
        }

        // 3. Aplikasikan diskon ke grand total
        $hargaAkhir = $grandTotal;
        if ($disc > 0) {
            $hargaAkhir = (int) round($grandTotal - ($grandTotal * $disc / 100));
        }

        // 4. Simpan transaksi (header). Field harga_id/kg/harga/hari = ITEM PERTAMA
        //    untuk backward-compat dengan template invoice/laporan lama.
        $first = $itemRows[0];
        $order = new transaksi();
        $order->invoice          = $request->invoice;
        $order->tgl_transaksi    = Carbon::now()->format('d-m-Y');
        $order->status_payment   = $request->status_payment;
        $order->customer_id      = $request->customer_id;
        $order->user_id          = Auth::user()->id;
        $order->customer         = namaCustomer($order->customer_id);
        $order->email_customer   = email_customer($order->customer_id);
        $order->harga_id         = $first['harga_id'];
        $order->kg               = collect($itemRows)->sum('kg');  // total kg semua item
        $order->harga            = $first['harga'];
        $order->hari             = $longestHari;                   // ambil yang paling lama
        $order->disc             = $request->disc;
        $order->harga_akhir      = $hargaAkhir;
        $order->jenis_pembayaran = $request->jenis_pembayaran;
        $order->tgl              = Carbon::now()->day;
        $order->bulan            = Carbon::now()->month;
        $order->tahun            = Carbon::now()->year;
        $order->save();

        // 5. Simpan setiap item
        foreach ($itemRows as $row) {
            $order->items()->create($row);
        }

        // 6. Notifikasi (best-effort, tidak gagalkan order)
        try {
            if (setNotificationTelegramIn(1) == 1) {
                $order->notify(new OrderMasuk());
            }
        } catch (\Throwable $e) {
            \Log::warning('Telegram notif failed: '.$e->getMessage());
        }

        try {
            if (setNotificationEmail(1) == 1) {
                $bank = DataBank::get();
                $data = [
                    'email'         => $order->email_customer,
                    'invoice'       => $order->invoice,
                    'customer'      => $order->customer,
                    'tgl_transaksi' => $order->tgl_transaksi,
                    'items'         => $itemRows,
                    'pakaian'       => $first['jenis'],   // backward-compat single
                    'berat'         => $order->kg,
                    'harga'         => $order->harga,
                    'harga_disc'    => $disc > 0 ? (int) round($grandTotal * $disc / 100) : 0,
                    'disc'          => $order->disc,
                    'total'         => $grandTotal,
                    'harga_akhir'   => $order->harga_akhir,
                    'laundry_name'  => optional(Auth::user()->cabang)->nama ?? Auth::user()->nama_cabang,
                    'bank'          => $bank,
                ];
                dispatch(new OrderCustomerJob($data));
            }
        } catch (\Throwable $e) {
            \Log::warning('Email order notif failed: '.$e->getMessage());
        }

        DB::commit();
        Session::flash('success', 'Order berhasil dibuat dengan '.count($itemRows).' item.');
        return redirect('pelayanan');

      } catch (\Throwable $e) {
        DB::rollBack();
        \Log::error('PelayananController@store error: '.$e->getMessage());
        return back()->withInput()->with('error', 'Gagal simpan order: '.$e->getMessage());
      }
    }

    // Resource route /pelayanan/create — delegate ke addorders()
    public function create()
    {
      return $this->addorders();
    }

    // Tambah Order
    public function addorders()
    {
      $cek_harga    = harga::where('user_id',Auth::user()->id)->where('status',1)->first();
      $cek_customer = User::select('id','karyawan_id')->where('karyawan_id',Auth::id())->count();

      // Guard: data harga belum ada -> arahkan ke list harga karyawan
      if (!$cek_harga) {
        Session::flash('error',
          'Tidak bisa buat order: belum ada data harga aktif untuk cabang kamu. Mohon hubungi admin untuk mengisi data harga terlebih dahulu.');
        return redirect('listharga-karyawan');
      }

      // Guard: customer belum ada -> arahkan ke form tambah customer
      if ($cek_customer == 0) {
        Session::flash('error',
          'Tidak bisa buat order: belum ada customer terdaftar. Tambahkan minimal 1 customer dulu.');
        return redirect('customers-create');
      }

      $customer     = User::where('karyawan_id',Auth::user()->id)->get();
      $jenisPakaian = harga::where('user_id',Auth::id())->where('status','1')->get();

      $y = date('Y');
      $number = mt_rand(1000, 9999);
      $newID  = $number. Auth::user()->id .''.$y;

      return view('karyawan.transaksi.addorder',
        compact('customer','newID','cek_harga','cek_customer','jenisPakaian'));
    }

    // List harga (read-only) untuk karyawan
    public function viewHarga()
    {
      $hargaList = harga::where('user_id', Auth::id())->orderBy('jenis')->get();
      return view('karyawan.harga.index', compact('hargaList'));
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
        // Wajib pilih jenis pembayaran kalau masih "Belum Diketahui"
        $jp = $request->jenis_pembayaran;
        $needsJp = empty($transaksi->jenis_pembayaran) || $transaksi->jenis_pembayaran === 'Belum Diketahui';
        if ($needsJp) {
            if (!in_array($jp, ['Tunai', 'Transfer'], true)) {
                return response()->json([
                    'ok'    => false,
                    'code'  => 'need_payment',
                    'error' => 'Pilih jenis pembayaran (Tunai / Transfer) dulu.',
                ], 422);
            }
            $transaksi->jenis_pembayaran = $jp;
        }
        $transaksi->status_payment = 'Success';
        $transaksi->save();
      } elseif ($transaksi->status_payment == 'Success') {
        if ($transaksi->status_order == 'Process') {
          $transaksi->update([
            'status_order' => 'Done'
          ]);

            // Tambah point +1
            $points = User::where('id',$transaksi->customer_id)->firstOrFail();
            $points->point =  $points->point + 1;
            $points->update();

            // Create Notifikasi
            $id         = $transaksi->id;
            $user_id    = $transaksi->customer_id;
            $title      = 'Pakaian Selesai';
            $body       = 'Pakaian Sudah Selesai dan Sudah Bisa Diambil :)';
            $kategori   = 'info';
            sendNotification($id,$user_id,$kategori,$title,$body);

            // Cek email notif
            if (setNotificationEmail(1) == 1) {

              // Menyiapkan data
              $data = array(
                  'email'           => $transaksi->email_customer,
                  'invoice'         => $transaksi->invoice,
                  'customer'        => $transaksi->customer,
                  'nama_laundry'    => Auth::user()->nama_cabang,
                  'alamat_laundry'  => Auth::user()->alamat_cabang,
              );

            // Kirim Email
            dispatch(new DoneCustomerJob($data));
            }

            // Cek status notif untuk telegram
            if (setNotificationTelegramFinish(1) == 1) {
              $transaksi->notify(new OrderSelesai());
            }

            // Notifikasi WhatsApp
            if (setNotificationWhatsappOrderSelesai(1) == 1 && getTokenWhatsapp() != null) {
              $waCustomer = $transaksi->customers->no_telp; // get nomor whatsapp customer
              $nameCustomer = $transaksi->customers->name; // get name customer
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
