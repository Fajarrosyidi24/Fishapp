<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifikasiNelayanTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_admin_akses_halaman(){
        $response = $this->get(route('login_admin'));
        $response->assertStatus(200);
    }

    public function test_login_admin_post(){
        $this->artisan('db:seed --class=AdminSeeder');
        $request = [
            'email' => 'fajarrosyidi80@gmail.com',
            'password' => 'fajarrs2020',
        ];
        $response = $this->post(route('admin.login'), $request);
        $response->assertRedirect(route('admin.dashboard'))
        ->assertSessionHas('success', 'admin login succesfully');
    }

    public function test_akses_halaman_verifikasi_nelayan(){
        VerifikasiNelayanTest::test_login_admin_post();
        $response = $this->get(route('viewdatapermintaannelayan'));
        $response->assertStatus(200);
    }
}
