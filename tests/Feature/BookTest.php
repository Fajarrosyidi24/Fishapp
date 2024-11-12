<?php

namespace Tests\Feature;

use App\Models\Nelayan;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class BookTest extends TestCase
{
    use RefreshDatabase;
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

    public function test_user_masuk_tanpa_login()
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
        ];
        $response = $this->post(route('sefood.store'), $request);
        $response->assertRedirect()->assertSessionHas('success', 'Data seafood berhasil ditambahkan.');

        $response = $this->get(route('create.seafood'));
        $response ->assertStatus(302);

    }

    // public function penjualanikan()  {
    //     $penjual= penjualanikan::factory()->create();
    //     $response = this
    // }
}