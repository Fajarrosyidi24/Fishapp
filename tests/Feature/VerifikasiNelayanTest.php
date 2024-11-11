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

class VerifikasiNelayanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_akses_halaman_login()
    {
        $response = $this->get(route('login_admin'));
        $response->assertStatus(200);
    }

    public function test_login_admin_post()
    {
        $this->artisan('db:seed --class=AdminSeeder');
        $request = [
            'email' => 'fajarrosyidi80@gmail.com',
            'password' => 'fajarrs2020',
        ];
        $response = $this->post(route('admin.login'), $request);
        $response->assertRedirect(route('admin.dashboard'))
            ->assertSessionHas('success', 'admin login succesfully');
    }

    public function test_login_admin_post_gagal_login()
    {
        $this->artisan('db:seed --class=AdminSeeder');
        $request = [
            'email' => 'fajarrosyidi8000@gmail.com', //email salah
            'password' => 'fajarrs2020', //password salah
        ];
        $response = $this->post(route('admin.login'), $request);
        $response->assertStatus(302);
    }

    public function test_create_data_nelayan_success()
    {
        $pathToFotoAsli = base_path('tests/fixtures/IMG_20240330_143101_396.jpg');
        $pasFoto = new UploadedFile($pathToFotoAsli, 'pas_foto.jpg', null, null, true);

        $request = [
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
            'email' => 'fajarrosyidi80@gmail.com',
            'no_telepon' => '081234567890',
            'nama_kapal' => 'Kapal Indah',
            'jenis_kapal' => 'Jenis Kapal A',
            'jumlah_abk' => 15,
            'pas_foto' => $pasFoto,
        ];
        $response = $this->post(route('post_form_pendaftaran_nelayan'), $request);
        $response->assertRedirect()->assertSessionHas('status', 'Terima kasih! Permintaan Anda akan segera diproses oleh admin. Harap tunggu 2x 24 jam, Anda akan mendapatkan email notifikasi.');
    }

    public function test_akses_halaman_verifikasi_nelayan()
    {
        VerifikasiNelayanTest::test_login_admin_post();
        VerifikasiNelayanTest::test_create_data_nelayan_success();
        $response = $this->get(route('viewdatapermintaannelayan'));
        $response->assertStatus(200);
    }

    public function test_akses_halaman_verifikasi_nelayan_gagal()
    {
        $response = $this->get(route('viewdatapermintaannelayan'));
        $response->assertStatus(302); //haruslah login terlebih dahulu
    }

    public function test_akses_halaman_detail_nelayan()
    {
        VerifikasiNelayanTest::test_akses_halaman_verifikasi_nelayan();
        $response = $this->get(route('detailpermintaanakunnelayan', ['id' => 3]));
        $response->assertStatus(200);
    }

    public function test_akses_halaman_detail_nelayan_gagal()
    {
        $response = $this->get(route('detailpermintaanakunnelayan', ['id' => 3])); //id tidak ditemukan
        $response->assertStatus(302); //haruslah login terlebih dahulu
    }

    public function test_verifikasi_nelayan()
    {
        VerifikasiNelayanTest::test_akses_halaman_verifikasi_nelayan();
        $nelayan = Nelayan::find(4);
        $response = $this->post(route('verifikasi.nelayan', ['id' => $nelayan->id]));
        $response->assertRedirect(route('admin.dashboard'))->assertSessionHas('success', 'Akun berhasil diverifikasi, link aktivasi telah dikirim ke email nelayan.');
    }

    public function test_verifikasi_nelayan_gagal()
    {
        VerifikasiNelayanTest::test_create_data_nelayan_success();
        $nelayan = Nelayan::find(5); 
        $response = $this->post(route('verifikasi.nelayan', ['id' => $nelayan->email])); //id salah
        $response->assertStatus(302);
    }

    public function test_verifikasi_nelayan_update_password_halaman()
    {
        VerifikasiNelayanTest::test_create_data_nelayan_success();
        $token = Str::random(15);
        $nelayan = Nelayan::find(6);
        $nelayan->remember_token =  $token;
        $nelayan->save();

        $response = $this->get(route('nelayan.regnel', ['email' => $nelayan->remember_token, 'token' => $nelayan->email]));
        $response->assertStatus(200);
    }

    public function test_verifikasi_nelayan_update_password_post()
    {
        VerifikasiNelayanTest::test_create_data_nelayan_success();
        $token = Str::random(15);
        $nelayan = Nelayan::find(7);
        $nelayan->remember_token =  $token;
        $nelayan->save();

        $request = [
            'email' => $nelayan->email,
            'password' => '12345678',
            'password_confirmation'=> '12345678',
        ];

        $response = $this->post(route('nelayan.registereduser', ['email' => $nelayan->email, 'token' => $nelayan->remember_token]), $request);
        $response->assertRedirect(route('login_nelayan'))->assertSessionHas('success', 'silahkan login menggunakan email dan password yang baru saja di daftarkan');
    }

    //function create data bukan test
    public function nelayan_create(){
        $nelayan = Nelayan::create([
            'name' => 'mohammad fajar rosyidi',
            'status' => 'terdaftar',
            'email' => 'fajarrosyidi80@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        return $nelayan;
    }

    public function test_login_nelayan(){
        VerifikasiNelayanTest::nelayan_create();
        $request = [
            'email' => 'fajarrosyidi80@gmail.com',
            'password' =>  '12345678',
        ];

        $response = $this->post(route('nelayan.login'), $request);
        $response->assertRedirect(route('nelayan.dashboard'))
            ->assertSessionHas('success', 'nelayan login succesfully');
    }

    public function test_login_nelayan_gagal(){
        VerifikasiNelayanTest::nelayan_create();
        $request = [
            'email' => 'fajarrosyidi@gmail.com', //email salah
            'password' =>  '12345678910', //password salah
        ];

        $response = $this->post(route('nelayan.login'), $request);
        $response->assertStatus(302);
    }
}
