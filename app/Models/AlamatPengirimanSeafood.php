<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlamatPengirimanSeafood extends Model
{
    use HasFactory;

    protected $table = 'alamat_pengiriman_seafoods';

    protected $fillable = [
        'provid',
        'cityid',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'dusun',
        'rt',
        'rw',
        'code_pos',
        'nelayan_id'
    ];

    public function nelayan()
    {
        return $this->belongsTo(Nelayan::class, 'nelayan_id');
    }

    public static function filterkode($id_nelayan){
        $cityidnelayan = [];
        foreach ($id_nelayan as $idcity) {
            $nelayanalamat = AlamatPengirimanSeafood::where('nelayan_id', $idcity)->first();
            if ($nelayanalamat) {
                $cityidnelayan[] = $nelayanalamat->cityid;
            }
        }

        return $cityidnelayan;
    }

    public static function alamat($jumlahSeafood){
        $alamatPengiriman = [];
        foreach ($jumlahSeafood as $seafood_id => $data) {
            $nelayan_id = $data['nelayan_id'];
            $alamat = AlamatPengirimanSeafood::where('nelayan_id', $nelayan_id)->first();
            if ($alamat) {
                if (isset($alamatPengiriman[$nelayan_id])) {
                    continue;
                } else {
                    $alamatPengiriman[$nelayan_id] = $alamat->toArray();
                }
            }
        }

        return $alamatPengiriman;
    }

    public static function cityids($alamat_pengiriman){
        $cityids = [];
    foreach ($alamat_pengiriman as $data) {
        $cityids[] = [
            'nelayan_id' => $data['nelayan_id'],
            'cityid' => $data['cityid']
        ];
    }

    return $cityids;
    }
}
