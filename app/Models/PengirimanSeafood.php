<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengirimanSeafood extends Model
{
    use HasFactory;

    protected $table = 'pengiriman_seafoods';
    protected $fillable = [
        'pesanan_id',
        'upload_foto_bukti_pengiriman',
    ];

    public function pesanan()
    {
        return $this->belongsTo(PesananSeafood::class, 'pesanan_id', 'id');
    }

    public static function store($imageName, $id){
       return self::create([
            'pesanan_id' => $id,
            'upload_foto_bukti_pengiriman' => $imageName,
        ]);
    }

}
