<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'district' => 'nullable|string',
            'sub_district' => 'nullable|string',
            'desa' => 'nullable|string',
            'dusun' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kode_pos' => 'nullable|string|max:5|min:5',
            'email' => 'nullable|email|max:255',
            'nomer_telepon' => 'nullable|string|regex:/^[0-9]+$/|min:10|max:15',
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
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'tanggal_lahir.date' => 'Tanggal lahir harus dalam format yang valid.',
            'rt.max' => 'RT tidak boleh lebih dari 5 karakter.',
            'rw.max' => 'RW tidak boleh lebih dari 5 karakter.',
            'kode_pos.max' => 'Kode pos tidak boleh lebih atau kurang dari 5 karakter.',
            'kode_pos.min' => 'Kode pos tidak boleh lebih atau kurang dari 5 karakter.',
            'email.email' => 'Format email tidak valid.',
            'nomer_telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'nomer_telepon.min' => 'Nomor telepon harus minimal 10 digit.',
            'nomer_telepon.max' => 'Nomor telepon tidak boleh lebih dari 15 digit.',
        ];
    }
}
