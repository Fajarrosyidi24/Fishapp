<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NelayanRegistrationRequest extends FormRequest
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
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'district' => 'required|string',
            'sub_district' => 'required|string',
            'desa' => 'required|string',
            'dusun' => 'required|string|max:255',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'kode_pos' => 'required|string|max:10',
            'email' => 'required|email|max:255',
            'no_telepon' => 'required|string|regex:/^[0-9]+$/|min:10|max:15',
            'nama_kapal' => 'required|string|max:255',
            'jenis_kapal' => 'required|string|max:255',
            'jumlah_abk' => 'required|integer|min:1',
            'pas_foto' => 'required|image|mimes:jpg,jpeg,png|max:10240',
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
            'name.required' => 'Nama lengkap wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir harus dalam format yang valid.',
            'district.required' => 'Kabupaten wajib dipilih.',
            'sub_district.required' => 'Kecamatan wajib dipilih.',
            'desa.required' => 'Desa wajib dipilih.',
            'dusun.required' => 'Dusun wajib diisi.',
            'rt.required' => 'RT wajib diisi.',
            'rt.max' => 'RT tidak boleh lebih dari 5 karakter.',
            'rw.required' => 'RW wajib diisi.',
            'rw.max' => 'RW tidak boleh lebih dari 5 karakter.',
            'kode_pos.required' => 'Kode pos wajib diisi.',
            'kode_pos.max' => 'Kode pos tidak boleh lebih dari 10 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'no_telepon.min' => 'Nomor telepon harus minimal 10 digit.',
            'no_telepon.max' => 'Nomor telepon tidak boleh lebih dari 15 digit.',
            'nama_kapal.required' => 'Nama kapal wajib diisi.',
            'jenis_kapal.required' => 'Jenis kapal wajib diisi.',
            'jumlah_abk.required' => 'Jumlah ABK wajib diisi.',
            'jumlah_abk.integer' => 'Jumlah ABK harus berupa angka.',
            'jumlah_abk.min' => 'Jumlah ABK tidak boleh kurang dari 0.',
            'pas_foto.required' => 'Pas foto wajib diunggah.',
            'pas_foto.image' => 'Pas foto harus berupa gambar.',
            'pas_foto.mimes' => 'Pas foto harus berformat JPG, JPEG, atau PNG.',
            'pas_foto.max' => 'Ukuran pas foto tidak boleh lebih dari 10MB.',
        ];
    }
}
