<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class CabangController extends Controller
{
    /**
     * Daftar cabang.
     */
    public function index()
    {
        $cabangs = Cabang::withCount('karyawan')->orderBy('nama')->get();
        return view('modul_admin.cabang.index', compact('cabangs'));
    }

    /**
     * Form tambah cabang baru.
     */
    public function create()
    {
        return view('modul_admin.cabang.form', [
            'cabang' => new Cabang(),
            'mode'   => 'create',
        ]);
    }

    /**
     * Simpan cabang baru.
     */
    public function store(Request $request)
    {
        $data = $this->validateCabang($request);
        Cabang::create($data);

        Session::flash('success', 'Cabang baru berhasil ditambahkan.');
        return redirect()->route('cabang.index');
    }

    /**
     * Form edit cabang.
     */
    public function edit($id)
    {
        $cabang = Cabang::findOrFail($id);
        return view('modul_admin.cabang.form', [
            'cabang' => $cabang,
            'mode'   => 'edit',
        ]);
    }

    /**
     * Update cabang.
     */
    public function update(Request $request, $id)
    {
        $cabang = Cabang::findOrFail($id);
        $data = $this->validateCabang($request, $cabang->id);
        $cabang->update($data);

        Session::flash('success', 'Cabang berhasil diperbarui.');
        return redirect()->route('cabang.index');
    }

    /**
     * Hapus cabang. Tidak diizinkan jika masih ada karyawan terkait.
     */
    public function destroy($id)
    {
        $cabang = Cabang::withCount('karyawan')->findOrFail($id);

        if ($cabang->karyawan_count > 0) {
            Session::flash('error',
                'Cabang "'.$cabang->nama.'" tidak bisa dihapus karena masih ada '
                . $cabang->karyawan_count . ' karyawan terkait. Pindahkan dulu karyawannya.');
            return redirect()->route('cabang.index');
        }

        $cabang->delete();
        Session::flash('success', 'Cabang berhasil dihapus.');
        return redirect()->route('cabang.index');
    }

    /**
     * Validation rules — alamat unique per cabang, tapi exclude current row saat edit.
     */
    private function validateCabang(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'nama'    => ['required', 'string', 'max:100'],
            'alamat'  => [
                'required', 'string',
                Rule::unique('cabangs', 'alamat')->ignore($ignoreId),
            ],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'status'  => ['required', Rule::in(['Active', 'Not Active'])],
        ], [
            'nama.required'   => 'Nama cabang wajib diisi.',
            'alamat.required' => 'Alamat cabang wajib diisi.',
            'alamat.unique'   => 'Alamat cabang sudah terdaftar untuk cabang lain.',
            'status.required' => 'Status cabang wajib dipilih.',
        ]);
    }
}
