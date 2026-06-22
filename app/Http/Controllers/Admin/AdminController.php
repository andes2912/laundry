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
use Illuminate\Support\Facades\Hash;

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
      $request->validate([
        'name'     => 'required|string|max:100',
        'email'    => 'required|email',
        'foto'     => 'nullable|image|max:2048',
        'password' => 'nullable|min:6|confirmed',
      ]);

      $profile = User::findOrFail(Auth::id());

      if ($foto = $request->file('foto')) {
        $nama_foto = time().'_'.$foto->getClientOriginalName();
        $foto->storeAs('public/images/foto_profile', $nama_foto);
        $profile->foto = $nama_foto;
      }

      if ($request->filled('password')) {
        $profile->password = Hash::make($request->password);
      }

      $profile->name    = $request->name;
      $profile->email   = $request->email;
      $profile->no_telp = $request->no_telp;
      $profile->alamat  = $request->alamat;
      $profile->save();

      Session::flash('success', 'Profile berhasil diupdate.');
      return back();
    }
}
