<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Http\Requests\FotoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\NelayanRegistrationRequest;
use GuzzleHttp\Psr7\Request;

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

        $profile->foto = $namaFileUnik;
        $profile->save();        
    }

    public static function updateprofileuser($request)
{
    // Mengambil data user
    $user2 = User::where('id', Auth::guard()->user()->id)->first();
    
    // Mencari UserProfile berdasarkan user_id
    $user = UserProfile::where('user_id', Auth::guard()->user()->id)->first();

    // Jika user profile belum ada, buat data baru
    if (!$user) {
        $user = new UserProfile(); // Membuat objek UserProfile baru
        $user->user_id = Auth::guard()->user()->id; // Set user_id
    }

    // Update data user
    $user2->name = $request->input('name');
    $user2->save();

    // Update atau set data UserProfile
    $user->tempat_lahir = $request->input('tempat_lahir');
    $user->tanggal_lahir = $request->input('tanggal_lahir');
    $user->alamat_lengkap = 'Dusun ' . $request->input('dusun') . ', RT/RW.' . $request->input('rt') . '/' . $request->input('rw') . ', Desa ' . $request->input('sub_district') . ', Kecamatan ' . $request->input('district') . ', Kabupaten ' . $request->input('district') . ', Jawa Timur';
    $user->provinsi = 'Jawa Timur';
    $user->kabupaten = $request->input('district');
    $user->kecamatan = $request->input('sub_district');
    $user->desa = $request->input('desa');
    $user->dusun = $request->input('dusun');
    $user->rt = $request->input('rt');
    $user->rw = $request->input('rw');
    $user->code_pos = $request->input('kode_pos');
    $user->jenis_kelamin = $request->input('jenis_kelamin');
    $user->no_telepon = $request->input('nomer_telepon');
    
    // Simpan data UserProfile
    $user->save();
}
}
