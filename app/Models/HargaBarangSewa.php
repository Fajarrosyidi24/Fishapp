<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HargaBarangSewa extends Model
{
    use HasFactory;

    protected $table = 'harga_barang_sewas';
    protected $primaryKey = 'kode_harga';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_harga',
        'harga',
        'barang_id',
    ];

    public function barang(){
        return $this->belongsTo(BarangSewa::class, 'barang_id', 'kode_barang');
    }
}
