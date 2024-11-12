<?php

namespace Tests\Feature;

use App\Models\Nelayan;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class BookTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_akses_halaman_login_nelayan() : void {
        $response = $this->get(route('login_nelayan'));
        $response ->assertStatus(200);
    }

    public function nelayan_create(){
        $nelayan = Nelayan::create([
            'name' => 'yassar',
            'status' => 'terdaftar',
            'email' => 'kikioryassar.2003@gmail.com',
            'password' => bcrypt('gakngerti180703'),
        ]);

        return $nelayan;
    }

    public function test_login_nelayan(){
        BookTest::nelayan_create();
        $request = [
            'email' => 'kikioryassar.2003@gmail.com',
            'password' =>  'gakngerti180703',
        ];

        $response = $this->post(route('nelayan.login'), $request);
        $response->assertRedirect(route('nelayan.dashboard'))
            ->assertSessionHas('success', 'nelayan login succesfully');
    }

    // public function test_login_nelayan_gagal(){
    //     BookTest::nelayan_create();
    //     $request = [
    //         'email' => 'fajarrosyidi@gmail.com', //email salah
    //         'password' =>  '12345678910', //password salah
    //     ];

    //     $response = $this->post(route('nelayan.login'), $request);
    //     $response->assertStatus(302);
    // }

    public function test_create_data_seafood_success()
    {
        $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
        $pasFoto = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);

        $request = [

            'kode_seafood' => '4543',
            'nama' => 'yono',
            'jenis_seafood' => 'tuna',
            'jumlah' => 20,
            'foto' => $pasFoto,
            'nelayan_id' => 1,
            'status' => 'available'

            // 'name' => 'John Doe',
            // 'jenis_kelamin' => 'Laki-laki',
            // 'tempat_lahir' => 'Surabaya',
            // 'tanggal_lahir' => '1990-01-01',
            // 'district' => 'Kabupaten ABC',
            // 'sub_district' => 'Kecamatan XYZ',
            // 'desa' => 'Desa PQR',
            // 'dusun' => 'Dusun S',
            // 'rt' => '01',
            // 'rw' => '02',
            // 'kode_pos' => '12345',
            // 'email' => 'fajarrosyidi80@gmail.com',
            // 'no_telepon' => '081234567890',
            // 'nama_kapal' => 'Kapal Indah',
            // 'jenis_kapal' => 'Jenis Kapal A',
            // 'jumlah_abk' => 15,
            // 'pas_foto' => $pasFoto,
        ];
        $response = $this->post(route('sefood.store'), $request);
        $response->assertRedirect()->assertSessionHas('success', 'Data seafood berhasil ditambahkan.');
    }

}
