<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Nelayan;
use App\Models\Seafood;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class BookTest extends TestCase
{
    // use RefreshDatabase;


    /**
     * A basic feature test example.
     */
    //Fungsi ini adalah tes sederhana yang mengirimkan permintaan GET ke beranda (/) 
    //dan memeriksa apakah status responsnya adalah 200, yang menunjukkan bahwa halaman berhasil dimuat.
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    //tes akses ke halaman login untuk nelayan dengan rute login_nelayan
    //dan memastikan respons status adalah 200, artinya halaman tersebut dapat diakses.
    public function test_akses_halaman_login_nelayan(): void
    {
        $response = $this->get(route('login_nelayan'));
        $response->assertStatus(200);
    }


    public function test_nelayan_create()
    {
        $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
        $pasFoto = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);
//array
        $request =[ 
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
        $response->assertStatus(302);
//mengambil data nelayan terbaru yang baru saja ditambahkan ke database dan mengembalikannya.
        return Nelayan::latest()->first();
        // $this->assertDatabaseHas('nelayans', [
        //     'name' => 'John Doe',
        //     'email' => 'john@example.com',   //////////////////////////////////////////////////
        //     'no_telepon' => '081234567890',
            
        // ]);
    }

    public function test_login_admin(){
    //menjalankan seeder untuk mengisi database dengan data admin untuk memastikan akun admin tersedia sebelum tes dimulai.
         $this->artisan('db:seed --class=AdminSeeder');

        $request = [
            'email' => 'fajarrosyidi80@gmail.com',
            'password' => 'fajarrs2020',
        ];

        $response = $this->post(route('admin.login'), $request);
        $response->assertRedirect(route('admin.dashboard'))->assertSessionHas('success', 'admin login succesfully');
    }

    public function test_verifikasi_akun_nelayan(){
        $this->test_login_admin();
        $nelayan = $this->test_nelayan_create();
        $id = $nelayan->id;//mengambil id dari nelayan yang baru dibuat, yang akan digunakan dalam proses verifikasi.
        $response = $this->post(route('verifikasi.nelayan', ['id' => $id ]));
        $response->assertRedirect(route('admin.dashboard'))->assertSessionHas('success', 'Akun berhasil diverifikasi, link aktivasi telah dikirim ke email nelayan.');


        return Nelayan::latest()->first();
    }

    public function test_tambahkan_password_nelayan_halaman(){
        $nelayan = $this->test_verifikasi_akun_nelayan();
        $token = $nelayan->remember_token;
        $email = $nelayan->email;
        $response = $this->get('nelayan/registered/'.$email.'/'.$token);
        $response->assertStatus(200);
    }

    public function test_tambahkan_password_nelayan_post(){
        $nelayan = $this->test_verifikasi_akun_nelayan();
        $token = $nelayan->remember_token;

        $request = [
            'email' => $nelayan->email,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];

        $response = $this->post(route('nelayan.registereduser', ['token' => $token]), $request);
        $response->assertStatus(302);

        return Nelayan::latest()->first();
    }

    public function test_login_nelayan_post(){
        $nelayan = $this->test_tambahkan_password_nelayan_post();
        $email = $nelayan->email;
        $password = '12345678';

        $request = [
            'email' => $email,
            'password' => $password,
        ];
        $response = $this->post(route('nelayan.login'), $request);
        $response->assertRedirect(route('nelayan.dashboard'))->assertSessionHas('success', 'nelayan login succesfully');
    }

    public function test_akses_halaman_tambah_seafood(){
        $this->test_login_nelayan_post();
        $response = $this->get(route('sefood.index'));
        $response->assertStatus(200);
    }

    public function test_akses_halaman_tambah_seafood_post(){
        $this->test_login_nelayan_post();

        $pathToFotoAsli = base_path('tests/fixtures/download (2).jpeg');
        $pasFoto = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);

        $request = [
            'name' => fake()->name(),
            'type' => fake()->word(),
            'quantity' => 10, 
            'price' => 20000, 
            'photo' => $pasFoto,
        ];

        $response = $this->post(route('sefood.store'), $request);
        $response->assertRedirect(route('sefood.index'))->assertSessionHas('success', 'Data seafood berhasil ditambahkan.');

        return Seafood::latest()->first();
    }


    public function test_update_data_seafood_success()
    {
       $seafood = $this->test_akses_halaman_tambah_seafood_post();

        $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
        $pasFoto = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);

        $id = $seafood->kode_seafood;

        $request = [
            'name' => 'yono update',
            'type' => 'salmon',
            'quantity' => 30,                    
            'photo' => $pasFoto,
            'price' => 15000,
        ];

        $response = $this->post(route('edit.seafood', ['id' => $id]), $request);
        $response->assertStatus(302);
    }

    public function test_DeleteSeafoodSuccess()
    {

        $seafood = $this->test_akses_halaman_tambah_seafood_post();
        $id = $seafood->kode_seafood;
        $response = $this->post(route('nealayan.deleteseafood', ['kode_seafood' => $id]));
        $response->assertStatus(302);
    }    

}
