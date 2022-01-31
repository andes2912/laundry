<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Session;

class SettingController extends Controller
{
    // Setting
    public function index()
    {
      return view('customer.setting.index');
    }

    // Proses setting
    public function settingUpdateCustomer(Request $request, $id)
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
