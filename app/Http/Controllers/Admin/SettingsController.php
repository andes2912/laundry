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
  public function notif(Request $request,$id)
  {
    $notif = notifications_setting::findorFail($id);
    $notif->telegram_order_masuk      = $request->telegram_order_masuk;
    $notif->telegram_order_selesai    = $request->telegram_order_selesai;
    $notif->email                     = $request->email;
    $notif->telegram_channel_masuk    = $request->telegram_channel_masuk;
    $notif->telegram_channel_selesai  = $request->telegram_channel_masuk;
    $notif->wa_order_selesai          = $request->wa_order_selesai;
    $notif->wa_token                  = $request->wa_token;
    $notif->save();

    Session::flash('success','Notifications Berhasil Diupdate !');
    return back();
  }

}
