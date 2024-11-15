<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Nelayan;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Mail\NelayanVerifyAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\Feature\NelayanRegistrationTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifikasiNelayanTest extends NelayanRegistrationTest
{
    public function test_login_admin_success()
    {
        $this->artisan('db:seed --class=AdminSeeder');
        $request = [
            'email' => 'fajarrosyidi80@gmail.com',
            'password' => 'fajarrs2020',
        ];

        $response = $this->post(route('admin.login'), $request);
        $response->assertRedirect(route('admin.dashboard'))->assertSessionHas('success', 'admin login succesfully');
    }

    public function test_login_admin_gagal()
    {
        $this->artisan('db:seed --class=AdminSeeder');
        $request = [
            'email' => 'fajarrosdi80@gmail.com', //email salah
            'password' => 12345678, //password salah
        ];
        $response = $this->post(route('admin.login'), $request);
        $response->assertRedirect()->assertSessionHas('gagal', 'email atau password salah');
    }

    public function test_halaman_detail_nelayan_success(){
        $this->test_login_admin_success();
        $nelayan = NelayanRegistrationTest::test_nelayan_create_post_berhasil();
        $id = $nelayan->id;
        $response = $this->get(route('detailpermintaanakunnelayan', ['id' => $id]));
        $response->assertStatus(200);
    }

    public function test_halaman_detail_nelayan_gagal(){
        //belum login
        $nelayan = NelayanRegistrationTest::test_nelayan_create_post_berhasil();
        $id = $nelayan->id;
        $response = $this->get(route('detailpermintaanakunnelayan', ['id' => $id]));
        $response->assertRedirect()->assertSessionHas('error', 'mohon login terlebih dahulu');
    }

    public function test_halaman_detail_nelayan_gagal_2(){
        $this->test_login_admin_success();
        $nelayan = NelayanRegistrationTest::test_nelayan_create_post_berhasil();
        $id = $nelayan->email;
        $response = $this->get(route('detailpermintaanakunnelayan', ['id' => $id]));
        $response->assertStatus(404);
    }

    public function test_verifikasi_akun_nelayan_success(){
        $this->test_login_admin_success();
        $nelayan = NelayanRegistrationTest::test_nelayan_create_post_berhasil();
        $id = $nelayan->id;
        $response = $this->post(route('verifikasi.nelayan', ['id' => $id]));
        $response->assertRedirect(route('admin.dashboard'))->assertSessionHas('success', 'Akun berhasil diverifikasi, link aktivasi telah dikirim ke email nelayan.');

        return Nelayan::latest()->first();
    }

    public function test_verifikasi_akun_nelayan_gagal(){
        //belum log in
        $nelayan = NelayanRegistrationTest::test_nelayan_create_post_berhasil();
        $id = $nelayan->id;
        $response = $this->post(route('verifikasi.nelayan', ['id' => $id]));
        $response->assertRedirect()->assertSessionHas('error', 'mohon login terlebih dahulu');
    }

    public function test_verifikasi_akun_nelayan_gagal_2(){
        $this->test_login_admin_success();
        $nelayan = NelayanRegistrationTest::test_nelayan_create_post_berhasil();
        $id = 10000; //tidak menenmukan id nelayan
        $response = $this->post(route('verifikasi.nelayan', ['id' => $id]));
        $response->assertStatus(404);
    }

    public function test_tolak_akun_nelayan(){
        $this->test_login_admin_success();
        $nelayan = NelayanRegistrationTest::test_nelayan_create_post_berhasil();
        $id = $nelayan->id;
        $response = $this->post(route('tolakakunnelayan', ['id' => $id]));
        $response->assertRedirect()->assertSessionHas('status', 'Pesan Penolakan Telah dikirimkan');
    }

    public function test_tolak_akun_nelayan_gagal(){
        $this->test_login_admin_success();
        $id = 1213; //tidak menemukan id
        $response = $this->post(route('tolakakunnelayan', ['id' => $id]));
        $response->assertStatus(404);
    }

    public function test_tolak_akun_nelayan_gagal_2(){
        //belum login
        $nelayan = NelayanRegistrationTest::test_nelayan_create_post_berhasil();
        $id = $nelayan->id;
        $response = $this->post(route('tolakakunnelayan', ['id' => $id]));  
        $response->assertRedirect()->assertSessionHas('error', 'mohon login terlebih dahulu');
    }
}
