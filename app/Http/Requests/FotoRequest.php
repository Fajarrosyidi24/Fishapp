<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FotoRequest extends FormRequest
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
            'pas_foto' => 'image|mimes:jpg,jpeg,png|max:10240',
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
            'pas_foto.image' => 'Pas foto harus berupa gambar.',
            'pas_foto.mimes' => 'Pas foto harus berformat JPG, JPEG, atau PNG.',
            'pas_foto.max' => 'Ukuran pas foto tidak boleh lebih dari 10MB.',
        ];
    }
}
