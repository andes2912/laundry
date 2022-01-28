<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Rupiah;
use DB;
use Session;
use Spatie\Permission\Models\Role;
use Carbon\carbon;

class AdminController extends Controller
{
    // Halaman admin
    public function adm()
    {
      $adm = User::where('auth','Admin')->get();
      return view('modul_admin.pengguna.admin', compact('adm'));
    }

    // Profile
    public function profile()
    {
      $profile = User::where('id',Auth::id())->first();
      return view('modul_admin.setting.profile', compact('profile'));
    }

    // Proses edit profile
    public function edit_profile(Request $request)
    {
      $profile = User::find($request->id_profile);
      $profile->update([
        'name'  => $request->name,
        'email'  => $request->email
      ]);

      Session::flash('success','Update Profile Berhasil');
      return $profile;
    }
}
