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

    public function pesanan()
    {
        return $this->belongsTo(PesananSeafood::class, 'tb_pemesanan_id', 'id');
    }

    public static function createdata($pesananSeafood, $keranjangData)
    {
        foreach ($keranjangData as $data) {
            self::create([
                'keranjang_id'=> $data->kode_keranjang,
                'tb_pemesanan_id' => $pesananSeafood->id,
            ]);
        }
    }
}
