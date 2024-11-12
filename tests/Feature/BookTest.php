<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Nelayan;
use App\Models\Seafood;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_nelayan_insert_data_seafood()
    // {
    //     // Membuat instance Nelayan
    //     $nelayan = Nelayan::factory()->create();

    //     // Mengirim permintaan POST dengan autentikasi pengguna nelayan
    //     $response = $this->actingAs($nelayan)->post(route('create.seafood'), [
    //         'nama' => "tuna",
    //         'jenis_seafood' => "ikan",
    //         'jumlah' => "2",
    //     ]);

    //     // Memastikan data berhasil masuk ke database
    //     $this->assertDatabaseHas('seafoods', [
    //         'nama' => 'tuna',
    //     ]);

    //     // Memastikan redirect ke route 'seafood'
    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('seafood'));
    // }

    public function test_create_seafoods()
    {
        // Buat data yang akan dimasukkan
        $data = [
            'kode_seafood' => '' . now()->timestamp, // Membuat kode_seafood unik
            'nama' => 'tuna',
            'jenis_seafood' => 'ikan',
            'foto' => '',
            'jumlah' => 4,
            'nelayan_id' => '001',
        ];

        // Masukkan data ke dalam database
        $seafood = Seafood::create($data);

        // Periksa apakah datanya sudah ada di database
        $this->assertDatabaseHas('seafoods', [
            'kode_seafood' => $data['kode_seafood'],
            'nama' => 'tuna',
            'jenis_seafood' => 'ikan',
            'foto' => '',
            'jumlah' => 4,
            'nelayan_id' => '001',
    
        ]);

        // Hapus data setelah pengujian selesai
        // $seafood->delete();
    }

    // public function test_update_seafoods()
    // {
    //     // Buat data seafood awal untuk diupdate
    //     $seafood = Seafood::create([
    //         'kode_seafood' => '' . now()->timestamp, // Membuat kode_seafood unik
    //         'nama' => 'tuna',
    //         'jenis_seafood' => 'ikan',
    //         'foto' => '',
    //         'jumlah' => 4,
    //         'nelayan_id' => '001',
    //     ]);

    //     // Update data jumlah
    //     $seafood->update(['jumlah' => 10]);

    //     // Periksa apakah data sudah terupdate di database
    //     $this->assertDatabaseHas('seafoods', [
    //         'kode_seafood' => $seafood->kode_seafood,
    //         'nama' => 'tuna',
    //         'jenis_seafood' => 'ikan',
    //         'jumlah' => 10,
    //         'nelayan_id' => '001',
    //     ]);

    //     // Hapus data setelah pengujian selesai
    //     $seafood->delete();
    // }

    
}
