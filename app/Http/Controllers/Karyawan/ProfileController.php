<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    // Profile Karyawan Cabang
    public function karyawanProfile($id)
    {
      $user = User::find($id);
      return view('karyawan.profile.index', compact('user'));
    }

    // Profile Karyawan Cabang - Save
    public function karyawanProfileSave(Request $request, $id)
    {
      $request->validate([
        'name'  => 'required|string|max:100',
        'email' => 'required|email',
        'foto'  => 'nullable|image|max:2048',
        'password' => 'nullable|min:6|confirmed',
      ]);

      $profile = User::findOrFail($id);

      $foto = $request->file('foto');
      if ($foto) {
        $nama_foto = time().'_'.$foto->getClientOriginalName();
        $foto->storeAs('public/images/foto_profile', $nama_foto);
        $profile->foto = $nama_foto;
      }

      if ($request->filled('password')) {
        $profile->password = Hash::make($request->password);
      }

      $profile->name          = $request->name;
      $profile->email         = $request->email;
      $profile->no_telp       = $request->no_telp;
      $profile->alamat        = $request->alamat;
      $profile->nama_cabang   = $request->nama_cabang;
      $profile->alamat_cabang = $request->alamat_cabang;
      $profile->save();

      Session::flash('success', 'Data profile berhasil diupdate.');
      return back();
    }

}
