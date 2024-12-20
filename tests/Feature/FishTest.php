<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Nelayan;
use Illuminate\Http\UploadedFile;
use App\Models\NelayanProfile;
use App\Models\Seafood;

class FishTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_masuk_dashboard_tanpa_login(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_masuk_halaman_login_nelayan() : void {
        $response = $this->get(route('login_nelayan'));

        $response->assertStatus(200);
    }

    public function nelayan_create(){
        $nelayan = Nelayan::create([
            'name' => 'muhamad rois',
            'status' => 'terdaftar',
            'email' => 'roisutit@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        return $nelayan;
    }

    public function nelayan_create_profile()
    {
        $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
        $pasFoto = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);

        $nelayan = FishTest::nelayan_create();
        $id = $nelayan->id;
        $profile = NelayanProfile::create([
            'nelayan_id' => $id,
            'tempat_lahir' => 'banyuwangi',
            'tanggal_lahir' => fake()->date(),
            'alamat_lengkap' => 'rogojampi',
            'provinsi' => 'jawa timur',
            'kabupaten' => 'banyuwangi',
            'kecamatan' => 'rogojampi',
            'desa' => 'gitik',
            'dusun'=> 'sidorejo',
            'rt'=> '001',
            'rw' => '001',
            'code_pos' => '68466',
            'jenis_kelamin' => 'laki-laki',
            'no_telepon' => '081350835783',
            'nama_kapal' => 'uhuyyy',
            'jenis_kapal' => 'feri',
            'jumlah_abk' => 10,
            'foto'  => $pasFoto,
        ]);

        return $profile;
    }

    public function test_login_nelayan(){
        $this->nelayan_create_profile();
        $request = [
            'email' => 'roisutit@gmail.com',
            'password' => '12345678'
        ];
        $response = $this->post(route('nelayan.login'), $request);

        $response->assertRedirect(route('nelayan.dashboard'))->assertSessionHas('success', 'nelayan login succesfully');
    }

    public function test_akses_halaman_seafood(){
        $this->test_login_nelayan();
        $response = $this->get(route('sefood.index'));

        $response->assertStatus(200);
    }

    public function test_input_data_seafood() {
        $this->test_login_nelayan();

        $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
        $pasFotoS = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);

        $request=[
            'name' => 'Cupang',
            'type' => 'ikan',
            'quantity' => 10,
            'price' => 20000,
            'photo' => $pasFotoS
        ];
        $response = $this->post(route('sefood.store'), $request);

        $response->assertRedirect(route('sefood.index'))->assertSessionHas('success', 'Data seafood berhasil ditambahkan.');

        $response = $this->assertDatabaseHas('seafoods', [
            'nama'=> 'Cupang',
        ]);

        return Seafood::latest()->first();
    }

    public function test_edit_data_seafood()
    {
        $seafood = $this->test_input_data_seafood();
        $kode_seafood = $seafood->kode_seafood;

        $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
        $pasFotoS = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);

        $request = [
            'name' => 'Tuna',
            'type' => 'ikan',
            'quantity' => 100,
            'price' => 30000,
            'photo' => $pasFotoS,
        ];

        $response = $this->post(route('edit.seafood', ['id' => $kode_seafood]), $request);
        $response->assertRedirect(route('sefood.index'))->assertSessionHas('success', 'Data seafood berhasil diedit.');
    }

    public function test_hapus_data_seafood() {
        $seafood = $this->test_input_data_seafood();
        $kode_seafood = $seafood->kode_seafood;

        $response = $this->post(route('nealayan.deleteseafood', ['kode_seafood' => $kode_seafood]));
        $response->assertRedirect(route('sefood.index'))->assertSessionHas('success', 'Seafood berhasil dihapus.');
    }

}
