<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AddKaryawanRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\Cabang;
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
      $kry = User::with('cabang')->where('auth','Karyawan')->get();
      return view('modul_admin.pengguna.kry', compact('kry'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $cabangs = Cabang::where('status','Active')->orderBy('nama')->get();

      // Hard requirement: minimal 1 cabang aktif sebelum bisa tambah karyawan
      if ($cabangs->isEmpty()) {
        Session::flash('error',
          'Belum ada cabang aktif. Buat cabang terlebih dahulu sebelum menambahkan karyawan.');
        return redirect()->route('cabang.create');
      }

      return view('modul_admin.pengguna.addkry', compact('cabangs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddKaryawanRequest $request)
    {
        $cabang = Cabang::findOrFail($request->cabang_id);
        $phone_number = preg_replace('/^0/','62',$request->no_telp);

        $adduser = new User();
        $adduser->name          = $request->name;
        $adduser->email         = $request->email;
        $adduser->cabang_id     = $cabang->id;
        // Tetap diisi untuk backward-compat di view/laporan lama
        $adduser->nama_cabang   = $cabang->nama;
        $adduser->alamat_cabang = $cabang->alamat;
        $adduser->alamat        = $request->alamat;
        $adduser->no_telp       = $phone_number;
        $adduser->status        = 'Active';
        $adduser->auth          = 'Karyawan';
        $adduser->password      = Hash::make($request->password);
        $adduser->save();

        $adduser->assignRole($adduser->auth);

        Session::flash('success','Karyawan berhasil dibuat dan dipasangkan ke cabang '.$cabang->nama.'.');
        return redirect('karyawan');
    }

    // Update Status Karyawan
    public function updateKaryawan(Request $request)
    {
      $karyawan = User::find($request->id);
      $karyawan->update([
        'status'  => $karyawan->status == 'Active' ? 'Not Active' : 'Active'
      ]);

      Session::flash('success','Status Karyawan Berhasil Diupdate.');
    }
}
