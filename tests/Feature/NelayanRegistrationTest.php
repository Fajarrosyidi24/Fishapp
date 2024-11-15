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

    public function test_halaman_create_nelayan_success()
    {
        $this->artisan('laravolt:indonesia:seed');
        $response = $this->get(route('form_registrasi_nelayan'));
        $response->assertSee('code');
    }

    //gagal mengakses halaman create data nelayan
    public function test_halaman_create_nelayan_gagal_akses_data_laravolt()
    {
        $this->artisan('migrate:fresh');
        $response = $this->get(route('form_registrasi_nelayan'));
        $response->assertStatus(404);
    }

    public function validasirequestdatanelayan(): array
    {
        $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
        $pasFoto = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);

        return [
            'name' => fake()->name(),
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => fake()->word(),
            'tanggal_lahir' => fake()->date(),
            'district' => fake()->word(),
            'sub_district' => fake()->word(),
            'desa' => fake()->word(),
            'dusun' => fake()->word(),
            'rt' => '002',
            'rw' => '001',
            'kode_pos' => '68466',
            'email' => fake()->email(),
            'no_telepon' => '082542534754',
            'nama_kapal' => fake()->name(),
            'jenis_kapal' => fake()->word(),
            'jumlah_abk' => 200,
            'pas_foto' => $pasFoto,
        ];
    }

    public function test_nelayan_create_post_berhasil()
    {
        $request = $this->validasirequestdatanelayan();
        $response = $this->post(route('post_form_pendaftaran_nelayan'), $request);
        $response->assertRedirect()->assertSessionHas('status', 'Terima kasih! Permintaan Anda akan segera diproses oleh admin. Harap tunggu 2x 24 jam, Anda akan mendapatkan email notifikasi.');
        return Nelayan::latest()->first();
    }

    public function test_nelayan_create_post_gagal()
    {
        $request = $this->validasirequestdatanelayan();
        $request['email'] = null;
        $request['kode_pos'] = 123;
        $response = $this->post(route('post_form_pendaftaran_nelayan'), $request);
        $response->assertRedirect()->assertSessionHasErrors('email','kode_pos');
    }
}
