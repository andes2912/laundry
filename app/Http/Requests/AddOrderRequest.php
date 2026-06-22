<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
          'customer_id'        => 'required',
          'status_payment'     => ['required', Rule::in(['Pending', 'Success'])],
          'jenis_pembayaran'   => ['required', Rule::in(['Tunai', 'Transfer', 'Belum Diketahui'])],
          'disc'               => 'nullable|numeric|min:0|max:100',

          // Multi-item array
          'items'              => 'required|array|min:1',
          'items.*.harga_id'   => 'required|exists:hargas,id',
          'items.*.kg'         => 'required|numeric|min:0.01',
        ];
    }

    public function messages()
    {
      return [
        'customer_id.required'        => 'Customer wajib dipilih.',
        'status_payment.required'     => 'Status pembayaran wajib dipilih.',
        'jenis_pembayaran.required'   => 'Jenis pembayaran wajib dipilih.',
        'jenis_pembayaran.in'         => 'Jenis pembayaran tidak valid.',
        'disc.numeric'                => 'Diskon harus angka.',
        'disc.max'                    => 'Diskon maksimum 100%.',
        'items.required'              => 'Minimal 1 item pakaian wajib diisi.',
        'items.min'                   => 'Minimal 1 item pakaian wajib diisi.',
        'items.*.harga_id.required'   => 'Jenis pakaian wajib dipilih di setiap baris.',
        'items.*.harga_id.exists'     => 'Jenis pakaian yang dipilih tidak valid.',
        'items.*.kg.required'         => 'Berat (kg) wajib diisi di setiap baris.',
        'items.*.kg.numeric'          => 'Berat harus berupa angka.',
        'items.*.kg.min'              => 'Berat minimum 0.01 kg.',
      ];
    }
}
