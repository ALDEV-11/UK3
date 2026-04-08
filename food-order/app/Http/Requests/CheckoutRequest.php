<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'alamat_kirim' => ['required', 'string', 'max:500'],
            'metode_bayar' => ['required', 'in:transfer,cod,ewallet'],
            'catatan' => ['nullable', 'string', 'max:200'],
            'kode_voucher' => ['nullable', 'string', 'exists:voucher,kode_voucher'],
        ];
    }

    public function messages(): array
    {
        return [
            'alamat_kirim.required' => 'Alamat kirim wajib diisi.',
            'alamat_kirim.string' => 'Alamat kirim harus berupa teks.',
            'alamat_kirim.max' => 'Alamat kirim maksimal 500 karakter.',

            'metode_bayar.required' => 'Metode bayar wajib dipilih.',
            'metode_bayar.in' => 'Metode bayar tidak valid. Pilih transfer, COD, atau e-wallet.',

            'catatan.string' => 'Catatan harus berupa teks.',
            'catatan.max' => 'Catatan maksimal 200 karakter.',

            'kode_voucher.string' => 'Kode voucher harus berupa teks.',
            'kode_voucher.exists' => 'Kode voucher tidak ditemukan.',
        ];
    }
}
