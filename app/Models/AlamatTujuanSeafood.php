<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlamatTujuanSeafood extends Model
{
    use HasFactory;

    protected $table = 'alamat_tujuan_seafoods';

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
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function createdataalamat($request,$CityName, $provinceName,$idcity, $idProvince){
        $iduser = Auth::guard()->user()->id;

        self::create([
        'provid' => $idProvince,
        'cityid' => $idcity,
        'provinsi' => $provinceName,
        'kabupaten' => $CityName,
        'kecamatan'=> $request->input('kecamatan'),
        'desa' => $request->input('desa'),
        'dusun' =>  $request->input('dusun'),
        'rt' => $request->input('rt'),
        'rw' => $request->input('rw'),
        'code_pos' => $request->input('code_pos'),
        'user_id'=> $iduser,
        ]);
    }
}
