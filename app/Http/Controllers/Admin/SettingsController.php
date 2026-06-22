<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{PageSettings,User,LaundrySetting,DataBank,notifications_setting};
use Auth;
use Session;

class SettingsController extends Controller
{

  // Settings
  public function setting()
  {
    $setpage    = PageSettings::first();
    $settarget  = LaundrySetting::first();
    $databank   = DataBank::where('user_id',Auth::id())->get();
    $setnotif   = notifications_setting::first();

    return view('modul_admin.setting.index', compact('setpage','settarget','databank','setnotif'));
  }

  // Proses setting page
  public function proses_set_page(Request $request, $id)
  {
    $request->validate([
      'judul'   => 'required|max:15'
    ]);

    $img_hero = $request->file('img_hero');
    if ($img_hero) {
        $img_heros = time()."_".$img_hero->getClientoriginalName();
        // Folder Penyimpanan
        $tujuan_upload = 'frontend/img/logo';
        $img_hero->move($tujuan_upload, $img_heros);
    }

    $setpage = PageSettings::find($id);
    $setpage->judul     = $request->judul;
    $setpage->img_hero  = $img_hero;
    $setpage->tentang   = $request->tentang;
    $setpage->facebook  = $request->facebook;
    $setpage->instagram = $request->instagram;
    $setpage->twitter   = $request->twitter;
    $setpage->whatsapp  = $request->whatsapp;
    $setpage->no_telp   = $request->no_telp;
    $setpage->email     = $request->email;
    $setpage->save();

    if ($setpage) {
      Session::flash('success','Setting Berhasil Disimpan !');
      return back();
    }
  }

  // Check Setting Theme
  public function set_theme(Request $request)
  {
    $id = Auth::id();
    $user = User::all();

    $set_theme = User::findOrFail($id);
    if ($request->theme == NULL) {
      $set_theme->theme = '0';
    } else {
      $set_theme->theme = $request->theme;
    }

    $set_theme->save();

    Session::flash('success','Setting Berhasil Disimpan !');
    return back();
  }

  // Setting Laundry Target
  public function set_target_laundry(Request $request, $id)
  {
    $set_target = LaundrySetting::findOrFail($id);
    $set_target->target_day = $request->target_day;
    $set_target->target_month = $request->target_month;
    $set_target->target_year = $request->target_year;
    $set_target->save();

    Session::flash('success','Target Berhasil Diupdate !');
    return back();
  }

  // Simpan Bank
  public function bank(Request $request)
  {

    $cek = DataBank::get()->count();
    if ($cek >= 3) {
      Session::flash('error','Maksimal bank hanya 3 !');
      return back();
    }

    $request->validate([
      'nama_bank'   => 'required|unique:data_banks',
      'no_rekening' => 'required|unique:data_banks',
      'no_rekening' => 'required',
    ]);

    DataBank::create([
      'nama_bank'     => $request->nama_bank,
      'no_rekening'   => $request->no_rekening,
      'nama_pemilik'  => $request->nama_pemilik,
      'user_id'       => Auth::id(),
    ]);

    Session::flash('success','Bank Berhasil Ditambah !');
    return back();
  }

  // Notification
  public function notif(Request $request, $id)
  {
    // Normalisasi toggle
    $email  = (int) $request->boolean('email');
    $tgIn   = (int) $request->boolean('telegram_order_masuk');
    $tgDone = (int) $request->boolean('telegram_order_selesai');
    $waDone = (int) $request->boolean('wa_order_selesai');

    // String fields
    $tgChannelIn   = trim((string) $request->telegram_channel_masuk);
    $tgChannelDone = trim((string) ($request->telegram_channel_selesai ?: $tgChannelIn));
    $tgBotToken    = trim((string) $request->telegram_bot_token);
    $waToken       = trim((string) $request->wa_token);
    $waUrl         = trim((string) $request->wa_gateway_url);
    $waDevice      = trim((string) $request->wa_device_id);
    $waProvider    = in_array($request->wa_provider, ['kirimwa','fonnte','wablas','wa_cloud'], true)
                        ? $request->wa_provider : 'kirimwa';

    $mailHost      = trim((string) $request->mail_host);
    $mailPort      = $request->mail_port ? (int) $request->mail_port : null;
    $mailUser      = trim((string) $request->mail_username);
    $mailPass      = $request->mail_password; // password tidak di-trim
    $mailEnc       = $request->mail_encryption ?: null;
    $mailFrom      = trim((string) $request->mail_from_address);
    $mailFromName  = trim((string) $request->mail_from_name);

    // Server-side validation: toggle ON tapi config wajib kosong → blok
    $errors = [];

    if ($email && $mailHost === '') {
        $errors['mail_host'] = 'Email Notification aktif — SMTP Host wajib diisi.';
    }
    if ($email && $mailFrom === '') {
        $errors['mail_from_address'] = 'Email Notification aktif — alamat pengirim (From) wajib diisi.';
    }

    if (($tgIn || $tgDone) && $tgChannelIn === '') {
        $errors['telegram_channel_masuk'] = 'Notifikasi Telegram aktif — Chat ID / Channel wajib diisi.';
    }
    if (($tgIn || $tgDone) && $tgBotToken === '') {
        $errors['telegram_bot_token'] = 'Notifikasi Telegram aktif — Bot Token wajib diisi.';
    }

    if ($waDone && $waToken === '') {
        $errors['wa_token'] = 'Notifikasi WhatsApp aktif — Token gateway wajib diisi.';
    }

    if (!empty($errors)) {
        return back()->withErrors($errors)->withInput();
    }

    $notif = notifications_setting::findOrFail($id);
    $notif->email                     = $email;
    $notif->telegram_order_masuk      = $tgIn;
    $notif->telegram_order_selesai    = $tgDone;
    $notif->telegram_channel_masuk    = $tgChannelIn;
    $notif->telegram_channel_selesai  = $tgChannelDone;
    $notif->telegram_bot_token        = $tgBotToken ?: null;
    $notif->wa_order_selesai          = $waDone;
    $notif->wa_token                  = $waToken ?: null;
    $notif->wa_gateway_url            = $waUrl ?: null;
    $notif->wa_device_id              = $waDevice ?: null;
    $notif->wa_provider               = $waProvider;

    // Validasi tambahan WA Cloud: phone_number_id wajib (kita pakai field wa_device_id)
    if ($waDone && $waProvider === 'wa_cloud' && $waDevice === '') {
        return back()->withErrors([
            'wa_device_id' => 'WA Cloud API: isi Phone Number ID di field "Device ID / Phone Number ID".'
        ])->withInput();
    }

    // SMTP — simpan hanya kalau host diisi (biar nggak overwrite env dengan null)
    $notif->mail_host        = $mailHost ?: null;
    $notif->mail_port        = $mailPort;
    $notif->mail_username    = $mailUser ?: null;
    if (!empty($mailPass)) {
        // Hanya update password kalau user isi field baru
        $notif->mail_password = $mailPass;
    }
    $notif->mail_encryption  = $mailEnc;
    $notif->mail_from_address = $mailFrom ?: null;
    $notif->mail_from_name    = $mailFromName ?: null;

    $notif->save();

    Session::flash('success', 'Pengaturan notifikasi berhasil disimpan.');
    return back();
  }

}
