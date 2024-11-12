<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BelajarTest extends TestCase
{
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
            'name' => 'mohammad fajar rosyidi',
            'status' => 'terdaftar',
            'email' => 'fajarrosyidi80@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        return $nelayan;
    }

    public function test_login_nelayan(): void{
        BookTest::nelayan_create();
        $request = [
            'email' => 'fajarrosyidi80@gmail.com',
            'password' => '12345678'
        ];
        $response = $this->post(route('nelayan.login'), $request);

        $response->assertRedirect()->assertSesionHas('success', 'nelayan login succesfully');
    }
}
