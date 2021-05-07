<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{PageSettings,User,LaundrySetting,DataBank};
use auth;
use Session;

class SettingsController extends Controller
{

  // Settings
  public function setting()
  {
    $setpage = PageSettings::first();
    $settarget = LaundrySetting::first();
    $databank = DataBank::where('user_id',Auth::id())->get();

    return view('modul_admin.setting.index', compact('setpage','settarget','databank'));
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

  // Check Setting Theme & Email
  public function set_theme_email(Request $request)
  {
    $id = auth::id();
    $user = User::all();

    $set_theme_email = User::findOrFail($id);
    if ($request->theme == NULL) {
      $set_theme_email->theme = '0';
    } else {
      $set_theme_email->theme = $request->theme;
    }

    if ($request->email_set == NULL) {
      $set_theme_email->email_set = '0';
    } else {
      $set_theme_email->email_set = $request->email_set;
    }

    $set_theme_email->save();

    if ($set_theme_email) {
      foreach ($user as $users) {
        $users->email_set = $set_theme_email->email_set;
      }

      $users->save();

      Session::flash('success','Setting Berhasil Disimpan !');
      return back();
    }
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

}
