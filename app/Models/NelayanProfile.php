<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\NelayanRegistrationRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NelayanProfile extends Model
{
    use HasFactory;

    protected $table = 'nelayan_detail_profiles';
    protected $fillable = [
        'nelayan_id',
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
        'nama_kapal',
        'jenis_kapal',
        'jumlah_abk',
        'foto',
    ];

    public function nelayan()
    {
        return $this->belongsTo(Nelayan::class);
    }

    public static function tambahProfil(NelayanRegistrationRequest $request, $nelayanId)
    {
        $validatedData = $request->validated();

        $foto = $validatedData['pas_foto'];
        $namaFileUnik = Str::uuid() . '_' . time() . '_' . $foto->getClientOriginalName();
        $fotoPath = $foto->storeAs('public/fotonelayan', $namaFileUnik);
        $fotoPath;

        return self::create([
            'nelayan_id' => $nelayanId,
            'tempat_lahir' => $validatedData['tempat_lahir'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'alamat_lengkap' => $validatedData['dusun'] . ', RT.' . $validatedData['rt'] . '/RW.'.$validatedData['rw']. ', '. $validatedData['desa'].', '. $validatedData['sub_district']. ', ' . $validatedData['district']. ', Jawa Timur, ' . $validatedData['kode_pos'],
            'provinsi' => 'Jawa Timur',
            'kabupaten' => $validatedData['district'],
            'kecamatan' => $validatedData['sub_district'],
            'desa' => $validatedData['desa'],
            'dusun' => $validatedData['dusun'],
            'rt' => $validatedData['rt'],
            'rw' => $validatedData['rw'],
            'code_pos' => $validatedData['kode_pos'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'no_telepon' => $validatedData['no_telepon'],
            'nama_kapal' => $validatedData['nama_kapal'],
            'jenis_kapal' => $validatedData['jenis_kapal'],
            'jumlah_abk' => $validatedData['jumlah_abk'],
            'foto' => $namaFileUnik,
        ]);
    }
}
