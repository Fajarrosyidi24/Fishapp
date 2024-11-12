<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlamatOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'provinsi' => 'required', 
            'city' => 'required', 
            'kecamatan' => 'required|string|max:255',  // Kecamatan wajib diisi dan berupa string
            'desa' => 'required|string|max:255',  // Desa wajib diisi dan berupa string
            'dusun' => 'required|string|max:255',  // Dusun wajib diisi dan berupa string
            'rt' => 'required|regex:/^\d+$/',  // RT harus berupa angka
            'rw' => 'required|regex:/^\d+$/',  // RW harus berupa angka
            'code_pos' => 'required|regex:/^\d{5}$/',  // Kode pos harus berupa 5 digit angka
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'provinsi.required' => 'Provinsi wajib dipilih.',
            'city.required' => 'Kabupaten wajib dipilih.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kecamatan.string' => 'Kecamatan harus berupa teks.',
            'kecamatan.max' => 'Kecamatan tidak boleh lebih dari 255 karakter.',
            'desa.required' => 'Desa wajib diisi.',
            'desa.string' => 'Desa harus berupa teks.',
            'desa.max' => 'Desa tidak boleh lebih dari 255 karakter.',
            'dusun.required' => 'Dusun wajib diisi.',
            'dusun.string' => 'Dusun harus berupa teks.',
            'dusun.max' => 'Dusun tidak boleh lebih dari 255 karakter.',
            'rt.required' => 'RT wajib diisi.',
            'rt.regex' => 'RT harus berupa angka.',
            'rw.required' => 'RW wajib diisi.',
            'rw.regex' => 'RW harus berupa angka.',
            'code_pos.required' => 'Kode pos wajib diisi.',
            'code_pos.regex' => 'Kode pos harus berupa 5 digit angka.',
        ];
    }
}
