<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeafoodRequest extends FormRequest
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
            'name' => 'required|string|max:255', // Nama seafood harus diisi, berupa string, dan maksimal 255 karakter
            'type' => 'required|string', // Jenis seafood harus diisi dan berupa string
            'quantity' => 'required|numeric|min:1', // Jumlah harus diisi, berupa angka, dan minimal 1 kg
            'price' => 'required|numeric|min:1000', // Harga harus diisi, berupa angka, dan tidak boleh negatif
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
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
        'name.required' => 'Nama seafood harus diisi.',
        'name.string' => 'Nama seafood harus berupa teks.',
        'name.max' => 'Nama seafood maksimal 255 karakter.',

        'type.required' => 'Jenis seafood harus dipilih.',
        'type.string' => 'Jenis seafood harus berupa teks.',

        'quantity.required' => 'Jumlah seafood harus diisi.',
        'quantity.numeric' => 'Jumlah seafood harus berupa angka.',
        'quantity.min' => 'Jumlah seafood minimal 1 kg.',

        'price.required' => 'Harga seafood harus diisi.',
        'price.numeric' => 'Harga seafood harus berupa angka.',
        'price.min' => 'Harga seafood tidak boleh negatif. dan minimal Rp. 1000',

        'photo.image' => 'File yang diunggah harus berupa gambar.',
        'photo.mimes' => 'Gambar harus berformat: jpeg, png, jpg, gif.',
        'photo.max' => 'Ukuran gambar maksimal 10MB.',
        ];
    }
}
