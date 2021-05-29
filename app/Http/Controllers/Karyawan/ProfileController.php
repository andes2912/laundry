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

    // Profile Karyawan Cabang - Edit
    public function karyawanProfileEdit(Request $request, $id)
    {
      $edit = User::find($id);
      return view('karyawan.profile.edit', compact('edit'));
    }

    // Profile Karyawan Cabang - Save
    public function karyawanProfileSave(Request $request, $id)
    {
      $edit = User::FindorFail($id);
      $edit->id = $request->id;
      $edit->name = $request->name;
      $edit->email = $request->email;
      $edit->alamat = $request->alamat;
      $edit->no_telp = $request->no_telp;
      $edit->nama_cabang = $request->nama_cabang;
      $edit->alamat_cabang = $request->alamat_cabang;
      $edit->save();


      alert()->success('Update Data Berhasil');
      $id = $edit->id;
      return redirect('profile-karyawan/' .$id.'');
    }

    // Change Password Karyawan
    public function change_password(Request $request, $id)
    {
      $request->validate([
        'password'  => 'required|confirmed',
      ]);

      $change_password = User::findOrFail($id);
      $change_password->password = bcrypt($request->password);
      $change_password->save();

      Session::flash('success','Password Berhasil Diubah !');
      return \redirect()->back();
    }
}
