<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemBarangSewa extends Model
{
    use HasFactory;

    protected $table = 'item_barang_sewas';

    protected $fillable = [
        'keranjang_sewa_id',
        'tb_pesanan_sewa_id'
    ];


    public function keranjang()
    {
        return $this->belongsTo(KeranjangBarangSewa::class, 'keranjang_sewa_id', 'kode_keranjang_sewa');
    }

    public function pesanan()
    {
        return $this->belongsTo(PesananBarangSewa::class, 'tb_pesanan_sewa_id', 'id');
    }
}
