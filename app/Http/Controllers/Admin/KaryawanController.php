<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AddKaryawanRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Session;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $kry = User::where('auth','Karyawan')->get();
      return view('modul_admin.pengguna.kry', compact('kry'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('modul_admin.pengguna.addkry');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddKaryawanRequest $request)
    {
      $adduser = New User();
      $adduser->name          = $request->name;
      $adduser->email         = $request->email;
      $adduser->nama_cabang   = $request->nama_cabang;
      $adduser->alamat        = $request->alamat;
      $adduser->alamat_cabang = $request->alamat_cabang;
      $adduser->no_telp       = $request->no_telp;
      $adduser->status        = 'Active';
      $adduser->auth          = 'Karyawan';
      $adduser->password      = bcrypt('123456');
      $adduser->save();

      $adduser->assignRole($adduser->auth);

      Session::flash('success','Tambah Karyawan Berhasil');
      return redirect('karyawan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $edit = User::find($id);
      return view('modul_admin.pengguna.editkry', compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $adduser = User::find($id);
      $adduser->status = $request->status;
      $adduser->save();

      Session::flash('success','Update Karyawan Berhasil');
      return redirect('karyawan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $delete = User::find($id);
      if ($delete->status == 'Active') {
        Session::flash('error','Error, Status Karyawan masih aktif');
      } else {
        $delete->delete();
        Session::flash('success','Hapus Karyawan Berhasil');
      }
      return redirect('karyawan');
    }
}
