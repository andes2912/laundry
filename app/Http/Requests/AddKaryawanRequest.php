<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddKaryawanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name'                  => 'required|max:50',
          'email'                 => 'required|email|unique:users,email|max:50',
          'cabang_id'             => 'required|exists:cabangs,id',
          'alamat'                => 'required|max:191',
          'no_telp'               => 'required',
          'password'              => 'required|string|min:8|confirmed',
          'password_confirmation' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
      return [
        'name.required'                 => 'Nama tidak boleh kosong.',
        'name.max'                      => 'Nama tidak boleh lebih dari 50 karakter.',
        'email.required'                => 'Email tidak boleh kosong.',
        'email.email'                   => 'Format email tidak valid.',
        'email.unique'                  => 'Email sudah digunakan.',
        'email.max'                     => 'Email tidak boleh lebih dari 50 karakter.',
        'cabang_id.required'            => 'Cabang wajib dipilih.',
        'cabang_id.exists'              => 'Cabang yang dipilih tidak valid. Refresh halaman.',
        'alamat.required'               => 'Alamat karyawan tidak boleh kosong.',
        'no_telp.required'              => 'Nomor telepon tidak boleh kosong.',
        'password.required'             => 'Password tidak boleh kosong.',
        'password.min'                  => 'Password minimal 8 karakter.',
        'password.confirmed'            => 'Konfirmasi password tidak sama.',
        'password_confirmation.required'=> 'Konfirmasi password wajib diisi.',
        'password_confirmation.min'     => 'Konfirmasi password minimal 8 karakter.',
      ];
    }
}
