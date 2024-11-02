<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rekening extends Model
{
    use HasFactory;

    protected $table = 'rekenings';
    protected $primaryKey = 'kode_rekening';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_rekening',
        'nomor_rekening',
        'jenis_rekening',
        'nama_akun_rekening',
        'nelayan_id',
    ];

    public function nelayan()
    {
        return $this->belongsTo(Nelayan::class, 'nelayan_id', 'id');
    }
}
