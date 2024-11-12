<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Nelayan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NelayanRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_displays_nelayan_registration_form_with_kecamatan_data()
    {
        $this->artisan('laravolt:indonesia:seed');
        $kabupaten = DB::table('indonesia_cities')->where('name', 'KABUPATEN BANYUWANGI')->first();
        $kecamatan = DB::table('indonesia_districts')->where('city_code', $kabupaten->code)->get();

        $response = $this->get(route('form_registrasi_nelayan'));
        $response->assertViewIs('nelayan.form_registration');
        $response->assertViewHas('kecamatan', function ($viewKecamatan) use ($kecamatan) {
            return $viewKecamatan->pluck('id')->diff($kecamatan->pluck('id'))->isEmpty();
        });
        $response->assertStatus(200);
    }

    public function test_create_data_nelayan_success()
    {
        $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
        $pasFoto = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);

        $request = [
            'name' => 'John Doe',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1990-01-01',
            'district' => 'Kabupaten ABC',
            'sub_district' => 'Kecamatan XYZ',
            'desa' => 'Desa PQR',
            'dusun' => 'Dusun S',
            'rt' => '01',
            'rw' => '02',
            'kode_pos' => '12345',
            'email' => 'john@example.com',
            'no_telepon' => '081234567890',
            'nama_kapal' => 'Kapal Indah',
            'jenis_kapal' => 'Jenis Kapal A',
            'jumlah_abk' => 5,
            'pas_foto' => $pasFoto,
        ];
        $response = $this->post(route('post_form_pendaftaran_nelayan'), $request);
        $response->assertRedirect()->assertSessionHas('status', 'Terima kasih! Permintaan Anda akan segera diproses oleh admin. Harap tunggu 2x 24 jam, Anda akan mendapatkan email notifikasi.');
    }

    public function test_create_data_nelayan_gagal()
    {
        $request = [
            'name' => 123243,
            'jenis_kelamin' => 1424324,
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1990-01-01',
            'district' => 'Kabupaten ABC',
            'sub_district' => 'Kecamatan XYZ',
            'desa' => 'Desa PQR',
            'dusun' => 'Dusun S',
            'rt' => '01',
            'rw' => '02',
            'kode_pos' => '12345',
            'email' => 'john@example.com',
            'no_telepon' => '081234567890',
            'nama_kapal' => 'Kapal Indah',
            'jenis_kapal' => 'Jenis Kapal A',
            'jumlah_abk' => 5,
            'pas_foto' => 'jerjfnej',
        ];
        $response = $this->post(route('post_form_pendaftaran_nelayan'), $request);
        $response->assertStatus(302);
    }
}
