<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilRequest extends FormRequest
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
          'name'      => 'required',
          'email'     => 'required',
          'no_telp'   => 'required',
          'alamat'    => 'required',
          'password'  => 'confirmed|min:8|nullable'
        ];
    }

    public function messages()
    {
      return [
        'name.required'       => 'Nama tidak boleh kosong.',
        'email.required'      => 'Email tidak boleh kosong.',
        'no_telp.required'    => 'No WhatsApp tidak boleh kosong.',
        'alamat.required'     => 'Alamat tidak boleh kosong.',
        'password.min'        => 'Password minimal berjumlah 8 karakter.',
        'password.confirmed'  => 'Password Konfirmasi tidak sama.'
      ];
    }
}
