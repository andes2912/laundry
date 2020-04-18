<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
Use Alert;

class ProfileController extends Controller
{
    // Profile Karyawan Cabang
    public function karyawanProfile($id)
    {
        if (auth::check()) {
            if (auth::user()->auth == "Karyawan") {
                $user = User::find($id);
                return view('karyawan.profile.index', compact('user'));
            }
        }
    }

    // Profile Karyawan Cabang - Edit
    public function karyawanProfileEdit(Request $request, $id)
    {
        if (auth::check()) {
            if (auth::user()->auth == "Karyawan") {
                $edit = User::find($id);
                return view('karyawan.profile.edit', compact('edit'));
            }
        }
    }

    // Profile Karyawan Cabang - Save
    public function karyawanProfileSave(Request $request, $id)
    {
        if (auth::check()) {
            if (auth::user()->auth == "Karyawan") {
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
        }
    }

    // Reset Password Karyawan
    public function reset_password(Request $request)
    {
        if (auth::check()) {
            if (auth::user()->auth == "Karyawan") {
                $reset = User::find($request->id);
                $reset->update([
                    'password' => bcrypt('12345678'),
                ]);
                
                return $reset;
            }
        }
    }
}
