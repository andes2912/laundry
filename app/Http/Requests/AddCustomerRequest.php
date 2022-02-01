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
          'name'                  => 'required|max:25',
          'email'                 => 'required|unique:users',
          'alamat'                => 'required',
          'no_telp'               => 'required|unique:users',
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
        'no_telp.required'              => 'Nomor Telepon tidak boleh kosong.'
      ];
    }
}
