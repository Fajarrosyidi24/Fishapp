<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesananBarangSewa extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'subtotal_harga',
        'jumlah_item',
        'total_keseluruhan_harga',
        'status',
        'jumlah_sewa',
        'jumlah_waktu',
        'jam_sewa',
        'jam_pengembalian'
    ];

    public function keranjangs()
    {
        return $this->belongsToMany(KeranjangBarangSewa::class, 'item_barang_sewas', 'keranjang_sewa_id', 'tb_pesanan_sewa_id');
    }

    public static function store($groupdata, $waktu) {
        $pesananIds = [];
        foreach ($groupdata as $gr) {
            $pesanan = self::create([
                'jumlah_item' => count($gr['items']),
                'total_keseluruhan_harga' => $gr['total_subtotal'],
                'status' => 'dipesan',
                'jumlah_sewa' => $gr['total_jumlah'],
                'jumlah_waktu' => $waktu,
            ]);

            $pesananIds[$gr['nelayan_id']] = $pesanan->id;
        }

        return $pesananIds;
    }
}
