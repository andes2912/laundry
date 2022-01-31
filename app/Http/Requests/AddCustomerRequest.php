<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCustomerRequest extends FormRequest
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
          'name'                  => 'required|unique:users|max:25',
          'email'                 => 'required|unique:users',
          'alamat'                => 'required',
          'no_telp'               => 'required|unique:users',
          'password'              => 'required|string|min:8|confirmed',
          'password_confirmation' => 'required|string|min:8'
        ];
    }

    public function messages()
    {
      return [
        'name.required'                 => 'Nama tidak boleh kosong.',
        'name.unique'                   => 'Nama sudah digunakan.',
        'name.max'                      => 'Nama tidak boleh lebih dari 50 karakter.',
        'email.required'                => 'Email tidak boleh kosong.',
        'email.unique'                  => 'Email sudah digunakan.',
        'email.max'                     => 'Email tidak boleh lebih dari 50 karakter.',
        'alamat.required'               => 'Alamat tidak boleh kosong.',
        'alamat.max'                    => 'Alamat tidak boleh lebih dari 50 karakter.',
        'no_telp.required'              => 'Nomor Telepon tidak boleh kosong.',
        'password.required'             => 'Password tidak boleh kosong.',
        'password.min'                  => 'Password harus lebih dari 8 karakter.',
        'password.confirmed'            => 'Password tidak sama, mohon ulangi kembali.',
        'password_confirmation.required'=> 'Password Konfirmasi tidak boleh kosong.',
        'password_confirmation.min'     => 'Password Konfirmasi harus lebih dari 8 karakter.'
      ];
    }
}
