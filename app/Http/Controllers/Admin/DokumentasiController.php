<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DokumentasiController extends Controller
{
  // Dokumentasi
  public function index()
  {
    return view('modul_admin.doc.index');
  }

  // Tentang Aplikasi Laundry
  public function tentang()
  {
    return view('modul_admin.doc.tentang');
  }

   // Instalasi & Penggunaan
  public function instalasi()
  {
    return view('modul_admin.doc.penggunaan');
  }

  // Versi & Pembaruan
  public function versi()
  {
    return view('modul_admin.doc.version');
  }

  // Notifikasi
  public function notifikasi()
  {
    return view('modul_admin.doc.notifikasi');
  }
}
