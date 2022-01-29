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
          'nama'                => 'required|unique:customers|max:25',
          'email_customer'      => 'required|unique:customers',
          'alamat'              => 'required',
          'kelamin'             => 'required',
          'no_telp'             => 'required|unique:customers',
        ];
    }

    public function messages()
    {
      return [
        'nama.required'           => 'Nama tidak boleh kosong.',
        'nama.unique'             => 'Nama sudah digunakan.',
        'nama.max'                => 'Nama tidak boleh lebih dari 50 karakter.',
        'email_customer.required' => 'Email tidak boleh kosong.',
        'email_customer.unique'   => 'Email sudah digunakan.',
        'email_customer.max'      => 'Email tidak boleh lebih dari 50 karakter.',
        'alamat.required'         => 'Alamat tidak boleh kosong.',
        'alamat.max'              => 'Alamat tidak boleh lebih dari 50 karakter.',
        'no_telp.required'        => 'Nomor Telepon tidak boleh kosong.',
        'kelamin.required'        => 'Jenis Kelamin tidak boleh kosong.'
      ];
    }
}
