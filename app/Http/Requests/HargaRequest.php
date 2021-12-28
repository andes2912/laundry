<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HargaRequest extends FormRequest
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
          'user_id' => 'required',
          'jenis'   => 'required',
          'harga'   => 'required',
          'hari'    => 'required'
        ];
    }

    public function messages()
    {
      return [
        'user_id.required'  => 'Cabang tidak boleh kosong.',
        'jenis.required'    => 'Jenis pakaian tidak boleh kosong.',
        'harga.required'    => 'Harga tidak boleh kosong.',
        'hari.required'     => 'Jumlah hari tidak boleh kosong.'
      ];
    }
}
