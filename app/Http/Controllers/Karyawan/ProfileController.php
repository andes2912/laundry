<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Session;
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
      $foto = $request->file('foto');
      if ($foto) {
        $nama_foto = time()."_".$foto->getClientOriginalName();
        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'public/images/foto_profile';
        $foto->storeAs($tujuan_upload,$nama_foto);
      }

      if ($request->password) {
        $password = Hash::make($request->password);
      }
      $profile = User::findOrFail($id);
      $profile->name            = $request->name;
      $profile->email           = $request->email;
      $profile->alamat          = $request->alamat;
      $profile->nama_cabang     = $request->nama_cabang;
      $profile->alamat_cabang   = $request->alamat_cabang;
      $profile->foto            = $nama_foto ?? Auth::user()->foto;
      $profile->password        = $password ?? Auth::user()->password;
      $profile->save();

      Session::flash('success','Data profile berhasil diupdate !');
      return back();
    }

}
