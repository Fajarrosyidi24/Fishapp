<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Nelayan;
use App\Models\Seafood;
use Illuminate\Http\UploadedFile;

class SeafoodTest extends TestCase
{
    // use RefreshDatabase;
    
    /**
     * Test halaman utama.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test akses halaman login nelayan.
     */
    public function test_halaman_login_nelayan(): void {
        $response = $this->get(route('login_nelayan'));
        $response->assertStatus(200);
    }

    /**
     * Membuat akun nelayan jika belum ada.
     */
    public function create_akun_nelayan() {
        return Nelayan::firstOrCreate(
            ['email' => 'kikioryassar.2003@gmail.com'],
            [
                'name' => 'yassar',
                'status' => 'aktif',
                'password' => bcrypt('gakngerti180703') // enkripsi
            ]
        );
    }

    /**
     * Test login dengan akun nelayan.
     */
    public function test_login_nelayan() {
        $this->create_akun_nelayan();
    
        $request = [
            'email' => 'kikioryassar.2003@gmail.com',
            'password' => 'gakngerti180703'
        ];
        
        $response = $this->post(route('nelayan.login'), $request);
        $response->assertRedirect(route('nelayan.dashboard'))
                 ->assertSessionHas('success', 'nelayan login succesfully');
    }
    
    /**
     * Test akses halaman input seafood (dengan login).
     */
    public function test_halaman_input_success() {
        $this->test_login_nelayan();
        // Pastikan nelayan sudah login dan dapat mengakses halaman
        $response = $this->get(route('sefood.index'));
        // Cek apakah status 302 (redirect) atau status 200 (berhasil)
        $response->assertStatus(200);
    }
    
    // public function test_input_data_seafood() {
    //     $nelayan = $this->create_akun_nelayan();
    //     $this->actingAs($nelayan);
    
    //     // Login sebagai nelayan
    //     $this->post(route('nelayan.login'), [
    //         'email' => 'kikioryassar.2003@gmail.com',
    //         'password' => 'gakngerti180703'
    //     ]);
    
    //     // File foto yang diunggah
    //     $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
    //     $pasFoto = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);
    
    //     $request = [
    //         'name' => 'lemuru',
    //         'type' => 'fish',
    //         'quantity' => 500,
    //         'price' => 10000,
    //         'photo' => $pasFoto
    //     ];
    
    //     // Perbaiki pesan sukses yang diharapkan
    //     $response = $this->post(route('sefood.store'), $request);
    //     $response->assertRedirect(route('sefood.index'))
    //              ->assertSessionHas('success', 'Data seafood berhasil ditambahkan.');
    
    //     return Seafood::latest()->first();
    // }
    
    // public function test_edit_data_seafood() {
    //     $nelayan = $this->create_akun_nelayan();
    //     $this->actingAs($nelayan);
    
    //     // Login sebagai nelayan
    //     $this->post(route('nelayan.login'), [
    //         'email' => 'kikioryassar.2003@gmail.com',
    //         'password' => 'gakngerti180703'
    //     ]);
    
    //     $seafood = $this->test_input_data_seafood();
    //     $kode_seafood = $seafood->kode_seafood;
    
    //     $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
    //     $pasFotoS = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);
    
    //     $request = [
    //         'name' => 'Tuna',
    //         'type' => 'ikan',
    //         'quantity' => 100,
    //         'price' => 30000,
    //         'photo' => $pasFotoS,
    //     ];
    
    //     // Perbaiki pesan sukses yang diharapkan
    //     $response = $this->post(route('edit.seafood', ['id' => $kode_seafood]), $request);
    //     $response->assertRedirect(route('sefood.index'))
    //              ->assertSessionHas('success', 'Data seafood berhasil ditambahkan.');
    // }
    
    // public function test_delete_data_seafood() {
    //     $nelayan = $this->create_akun_nelayan();
    //     $this->actingAs($nelayan);
    
    //     // Login sebagai nelayan
    //     $this->post(route('nelayan.login'), [
    //         'email' => 'kikioryassar.2003@gmail.com',
    //         'password' => 'gakngerti180703'
    //     ]);
    
    //     $seafood = $this->test_input_data_seafood();
    //     $kode_seafood = $seafood->kode_seafood;
    
    //     // Perbaiki pesan sukses yang diharapkan
    //     $response = $this->post(route('nelayan.deleteseafood', ['kode_seafood' => $kode_seafood]));
    //     $response->assertRedirect(route('sefood.index'))
    //              ->assertSessionHas('success', 'Data seafood berhasil ditambahkan.');
    // }
    
}
