<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{PageSettings,User};
use auth;
use Session;

class SettingsController extends Controller
{

  // Settings
  public function setting()
  {
    $setpage = PageSettings::first();

    return view('modul_admin.setting.index', compact('setpage'));
  }

  // Proses setting page
  public function proses_set_page(Request $request, $id)
  {
    if (auth::check()) {
      if (auth::user()->auth == 'Admin') {
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
      } else {
        abort(403);
      }
    }
  }

  // Check Setting Theme
  public function set_theme(Request $request)
  {
    $id = auth::id();
    $set_theme = User::findOrFail($id);
    if ($set_theme->theme == 1) {
    $set_theme->theme = 0;
    } else {
      $set_theme->theme = $request->theme;
    }
    $set_theme->save();

    if ($set_theme) {
      Session::flash('success','Setting Berhasil Disimpan !');
      return back();
    }
  }
}
