<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'type' => 'required|string', 
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
        'name.required' => 'Nama Barang harus diisi.',
        'name.string' => 'Nama Barang harus berupa teks.',
        'name.max' => 'Nama Barang maksimal 255 karakter.',
        
        'type.required' => 'Kondisi Barang harus dipilih.',
        'type.string' => 'Kondisi Barang harus berupa teks.',
        
        'quantity.required' => 'Jumlah Barang harus diisi.',
        'quantity.numeric' => 'Jumlah Barang harus berupa angka.',
        'quantity.min' => 'Jumlah Barang minimal 1',
        
        'price.required' => 'Harga Barang harus diisi.',
        'price.numeric' => 'Harga Barang harus berupa angka.',
        'price.min' => 'Harga Barang tidak boleh negatif. dan minimal Rp. 1000',
        
        'photo.image' => 'File yang diunggah harus berupa gambar.',
        'photo.mimes' => 'Gambar harus berformat: jpeg, png, jpg, gif.',
        'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
