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
//Fungsi ini adalah tes sederhana yang mengirimkan permintaan GET ke beranda (/) 
//dan memeriksa apakah status responsnya adalah 200, yang menunjukkan bahwa halaman berhasil dimuat.
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
//tes akses ke halaman login untuk nelayan dengan rute login_nelayan
//dan memastikan respons status adalah 200, artinya halaman tersebut dapat diakses.
    public function test_akses_halaman_login_nelayan() : void {
        $response = $this->get(route('login_nelayan'));
        $response ->assertStatus(200);
    }
//Fungsi ini membuat contoh data Nelayan menggunakan model Nelayan.
//Data yang dimasukkan meliputi name, status, email, dan password.
//Fungsi ini akan digunakan untuk membuat akun nelayan di beberapa tes.
    public function nelayan_create(){
        $nelayan = Nelayan::create([
            'name' => 'yassar',
            'status' => 'terdaftar',
            'email' => 'kikioryassar.2003@gmail.com',
            'password' => bcrypt('gakngerti180703'),
        ]);

        return $nelayan;
    }
//Fungsi ini pertama-tama memanggil nelayan_create() untuk membuat data nelayan yang terdaftar.
//Kemudian, fungsi ini melakukan POST request ke rute nelayan.login dengan data email dan password untuk mencoba login.
//Fungsi ini mengharapkan redirect ke halaman dashboard nelayan (nelayan.dashboard) dan menampilkan pesan sukses login di sesi.
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

    public function test_create_data_seafood_success()
    {
        $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg'); //menentukan path atau lokasi file gambar yang akan diunggah sebagai photo untuk data seafood
        $pasFoto = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);

        $request = [
            'name' => 'yono',
            'type' => 'tuna',
            'quantity' => 20,
            'photo' => $pasFoto,
            'price' => 10000,
        ];
        $response = $this->post(route('sefood.store'), $request);
        $response->assertStatus(302);
        //$response->assertRedirect()->assertSessionHas('success', 'Data seafood berhasil ditambahkan.');
    }

    // public function test_update_data_seafood_success()
    // {
    
    //     $nelayan = \App\Models\Nelayan::create([
    //         'name' => 'yassar',
    //         'email' => 'kikioryassar.2003@gmail.com',
    //         'status' => 'active',
    //     ]);
        
    //     $seafood = \App\Models\Seafood::create([
    //         'kode_seafood' => 'SFD001',
    //         'nama' => 'yono',
    //         'jenis_seafood' => 'tuna',
    //         'jumlah' => 20,
    //         'foto' => 'path/to/default/photo.jpg',
    //         'nelayan_id' => $nelayan->id,
    //     ]);
    
    //     $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
    //     $pasFoto = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);
    
    //     $updateRequest = [
    //         'nama' => 'yono update',
    //         'jenis_seafood' => 'salmon',
    //         'jumlah' => 30,                    
    //         'photo' => $pasFoto,
    //         'price' => 15000,
    //     ];

    //     $response = $this->post(route('edit.seafood', ['id' => $seafood->kode_seafood]), $updateRequest);
    //     $response->assertStatus(302);
    // }
    
    // public function testDeleteSeafoodSuccess()
    // {
    //     $nelayan = \App\Models\Nelayan::create([
    //         'name' => 'yassar',
    //         'email' => 'kikioryassar.2003@gmail.com',
    //         'password' => bcrypt('gakngerti180703'),
    //         'status' => 'active',
    //     ]);
    

    //     $response = $this->post(route('nelayan.login'), [
    //         'email' => 'kikioryassar.2003@gmail.com',
    //         'password' => 'gakngerti180703',
    //     ]);
    
    //     $response->assertRedirect(route('nelayan.dashboard'));
    
    //     $seafood = \App\Models\Seafood::create([
    //         'kode_seafood' => 'SF001',
    //         'nama' => 'Tuna',
    //         'jenis_seafood' => 'Tuna',
    //         'jumlah' => 10,
    //         'foto' => 'path_to_foto',
    //         'nelayan_id' => $nelayan->id,
    //         'status' => 'menunggu verifikasi'
    //     ]);
    
    //     $response = $this->delete(route('nelayan.deleteseafood', ['kode_seafood' => $seafood->kode_seafood]));
    // //memverifikasi bahwa data seafood dengan kode_seafood tidak lagi ada di database.
    //     $response->assertRedirect(route('sefood.index'));
    
    //     $this->assertDatabaseMissing('seafoods', ['kode_seafood' => $seafood->kode_seafood]);
    //     //memastikan bahwa data telah berhasil dihapus dari tabel seafoods.
    // }    
    
}
