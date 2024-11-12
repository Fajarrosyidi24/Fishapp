<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PasswordRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Http\Requests\NelayanRegistrationRequest;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Nelayan extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = 'nelayan';
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */


    public static function createNelayan(NelayanRegistrationRequest $request)
    {
        $validatedData = $request->validated();

        return self::create([
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'status' => 'pending',
        ]);
    }

    public static function createpassword(PasswordRequest $request, $email)
    {
        $validatedData = $request->validated();
        $nelayan = Nelayan::where('email', $email)->first();
        if ($nelayan) {
            $nelayan->update([
                'password' => bcrypt($validatedData['password']),
                'remember_token' => null,
                'status' => 'terdaftar',
            ]);

            return $nelayan; // Kembalikan nelayan yang telah diperbarui
        }

        return null;
    }

    public function detailProfile()
    {
        return $this->hasOne(NelayanProfile::class);
    }

    public static function emailnelayan($request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
        ]);

        $email = $request->input('email');
        $exists = self::where('email', $email)->exists();
        return $exists ? $email : false;
    }

    public static function updateprofile(array $data, $userId)
    {
        $nelayan = Nelayan::find($userId);
        if ($nelayan) {
            $nelayan->name = $data['name'];
            $nelayan->detailprofile->tempat_lahir = $data['tempat_lahir'];
            $nelayan->detailprofile->tanggal_lahir = $data['tanggal_lahir'];
            $nelayan->detailprofile->jenis_kelamin = $data['jenis_kelamin'];
            $nelayan->detailprofile->no_telepon = $data['nomer_telepon'];
            $nelayan->detailprofile->kabupaten = $data['district'];
            $nelayan->detailprofile->kecamatan = $data['sub_district'];
            $nelayan->detailprofile->desa = $data['desa'];
            $nelayan->detailprofile->dusun = $data['dusun'];
            $nelayan->detailprofile->rt = $data['rt'];
            $nelayan->detailprofile->rw = $data['rw'];
            $nelayan->detailprofile->code_pos = $data['code_pos'];
            $nelayan->detailprofile->nama_kapal = $data['nama_kapal'];
            $nelayan->detailprofile->jenis_kapal = $data['jenis_kapal'];
            $nelayan->detailprofile->jumlah_abk = $data['jumlah_abk'];
    
            // Simpan perubahan
            $nelayan->save();
            $nelayan->detailprofile->save();
        }
        return $nelayan;
    }

    public static function filterkode($kode_seafood){
    $idnelayan = [];
    foreach ($kode_seafood as $kods) {
        $seafood = Seafood::where('kode_seafood', $kods)->first();
        if ($seafood) {
            $nelayan = Nelayan::find($seafood->nelayan_id);
            if ($nelayan) {
                $idnelayan[] = $nelayan->id;
            }
        }
    }

    return $idnelayan;
    }
}
