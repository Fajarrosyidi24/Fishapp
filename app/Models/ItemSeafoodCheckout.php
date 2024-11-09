<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemSeafoodCheckout extends Model
{
    use HasFactory;

    protected $table = 'item_seafood_checkouts';

    protected $fillable = [
        'keranjang_id',
        'tb_pemesanan_id'
    ];

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'keranjang_id', 'kode_keranjang');
    }
}
