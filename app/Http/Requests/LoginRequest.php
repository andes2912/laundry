<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
          'email'     => 'required|email|exists:users,email',
          'password'  => 'required|exists:users,password'
        ];
    }

     public function messages()
    {
        return [
            'email.required'        => "Email tidak boleh kosong",
            "email.email"           => "Format email tidak diketahui",
            "email.exists"          => "Email tidak terdaftar pada sistem",
            "password.required"     => "Password tidak boleh kosong",
            "password.min"          => "Password minimal 7 karakter",
            "password.max"          => "Password maksimal 20 karakter",
            'password.exists'       => "Password yang kamu masukan salah."
        ];
    }
}