<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Http\Requests\FotoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\NelayanRegistrationRequest;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_lengkap',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'dusun',
        'rt',
        'rw',
        'code_pos',
        'jenis_kelamin',
        'no_telepon',
        'foto',
    ];


    public function uprofileser()
    {
        return $this->belongsTo(User::class);
    }

    public static function tambahpotoProfil(FotoRequest $request, $user){
        $validatedData = $request->validated();

        $foto = $validatedData['pas_foto'];
        $namaFileUnik = Str::uuid() . '_' . time() . '_' . $foto->getClientOriginalName();
        $fotoPath = $foto->storeAs('public/fotouser', $namaFileUnik);
        $fotoPath;

        return self::create([
            'user_id' => $user->id,
            'foto' => $namaFileUnik,
        ]);
    }

    public static function updatepotoProfil(FotoRequest $request, $user){
        $validatedData = $request->validated();
        $profile = UserProfile::where('user_id', $user->id)->first();

        if ($profile->foto) {
            Storage::delete('public/fotouser/' . $profile->foto);
        }

        $foto = $validatedData['pas_foto'];
        $namaFileUnik = Str::uuid() . '_' . time() . '_' . $foto->getClientOriginalName();
        $fotoPath = $foto->storeAs('public/fotouser', $namaFileUnik);
        $fotoPath;

        return self::update([
            'foto' => $namaFileUnik,
        ]);
    }
}
