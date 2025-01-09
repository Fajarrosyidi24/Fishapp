<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengembalianBarang extends Model
{
    use HasFactory;
    protected $table = 'pengembalian_barangs';
    protected $fillable = [
        'jam_pengembalian',
        'denda',
        'status_pengembalian',
        'tb_pesanan_sewa_id',
    ];

    public function pesanan()
    {
        return $this->belongsTo(PesananBarangSewa::class, 'tb_pesanan_sewa_id', 'id');
    }
}
