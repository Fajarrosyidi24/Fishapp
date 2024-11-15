<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Nelayan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewPasswordNelayanTest extends VerifikasiNelayanTest
{
    use RefreshDatabase;

    public function test_halaman_update_password_nelayan_berhasil()
    {
        $nelayan = $this->test_verifikasi_akun_nelayan_success();
        $token = $nelayan->remember_token;
        $email = $nelayan->email;
        $response = $this->get(route('nelayan.regnel', ['email' => $email, 'token' => $token]));
        $response->assertStatus(200);
    }

    public function test_halaman_update_password_nelayan_gagal()
    {
        $this->test_verifikasi_akun_nelayan_success();
        $token = 'ececnecnidekcndc';
        $email = 12345543;
        $response = $this->get(route('nelayan.regnel', ['email' => $email, 'token' => $token]));
        $response->assertStatus(404);
    }

    public function test_update_password_nelayan_post_berhasil()
    {
        $nelayan = $this->test_verifikasi_akun_nelayan_success();
        $token = $nelayan->remember_token;

        $request = [
            'email' => $nelayan->email,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];

        $response = $this->post(route('nelayan.registereduser', ['token' => $token]), $request);
        $response->assertRedirect(route('login_nelayan'))->assertSessionHas('success', 'silahkan login menggunakan email dan password yang baru saja di daftarkan');
        return Nelayan::latest()->first();
    }

    public function test_update_password_nelayan_post_gagal()
    {
        $nelayan = $this->test_verifikasi_akun_nelayan_success();
        $token = $nelayan->remember_token;

        $request = [
            'email' => $nelayan->email,
            'password' => '12345678de12ww',
            'password_confirmation' => '12345678'
        ];

        $response = $this->post(route('nelayan.registereduser', ['token' => $token]), $request);
        $response->assertRedirect()->assertSessionHasErrors('password');
    }
}
