<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
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

        // Act: Membuat permintaan ke route registrasi nelayan
        $response = $this->get(route('form_registrasi_nelayan'));
        $response->assertStatus(200);
        $response->assertViewIs('nelayan.form_registration');
        $response->assertViewHas('kecamatan', function ($viewKecamatan) use ($kecamatan) {
            return $viewKecamatan->pluck('id')->diff($kecamatan->pluck('id'))->isEmpty();
        });
        $response->assertStatus(200);
    }

}
