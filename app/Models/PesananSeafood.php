<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesananSeafood extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'subtotal_harga',
        'jumlah_item',
        'ongkir',
        'total_keseluruhan_harga',
        'metode_pembayaran',
        'status',
        'snap_token',
        'opsi_pengiriman',
        'alamat_pengiriman',
    ];

    public function keranjangs()
    {
        return $this->belongsToMany(Keranjang::class, 'item_seafood_checkouts', 'tb_pemesanan_id', 'keranjang_id');
    }

    public static function createpesanan($total){
        // self::create([
        //    'subtotal_harga'
        // ]);
    }

}
