<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Session;

class SettingsController extends Controller
{
    //Setting Karyawan
    public function setting()
    {
      return view('karyawan.settings.index');
    }

    // Proses setting
    public function proses_setting_karyawan(Request $request, $id)
    {
       $setting = User::findOrFail($id);
        if ($request->theme == NULL) {
          $setting->theme = '0';
        } else {
          $setting->theme = $request->theme;
        }
        $setting->save();

        Session::flash('success','Setting Berhasil Diupdate !');
        return back();
    }
}
