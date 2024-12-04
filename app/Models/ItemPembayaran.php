<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemPembayaran extends Model
{
    use HasFactory;

    protected $table = 'item_pembayarans';

    protected $fillable = [
        'pembayaran_id',
        'pesanan_id'
    ];

    public function invoice()
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id', 'id');
    }

    public function pesanan()
    {
        return $this->belongsTo(PesananSeafood::class, 'pesanan_id', 'id');
    }

    public static function createitem($idpembayaran, $pesanan){
        foreach($pesanan as $data){
            self::create([
                'pembayaran_id' => $idpembayaran,
                'pesanan_id' => $data->id,
            ]);
        }
    }
}
