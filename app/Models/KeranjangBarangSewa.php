<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeranjangBarangSewa extends Model
{
    use HasFactory;
    protected $table = 'keranjang_barang_sewas';
    protected $primaryKey = 'kode_keranjang_sewa';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_keranjang_sewa',
        'jumlah',
        'subtotal',
        'status',
        'barang_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function barang()
    {
        return $this->belongsTo(BarangSewa::class, 'barang_id', 'kode_barang');
    }

    public function pesanan()
    {
        return $this->belongsToMany(PesananBarangSewa::class, 'item_barang_sewas','keranjang_sewa_id', 'tb_pesanan_sewa_id');
    }

    public static function createkeranjangbarang($productId, $jumlah, $subtotal){
        $maxKodeKeranjang = self::max('kode_keranjang_sewa');
        $nextNumber = $maxKodeKeranjang ? intval(substr($maxKodeKeranjang, 3)) + 1 : 1;
        $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $newKodeKeranjang = 'KRB' . $formattedNumber;

        self::create([
            'kode_keranjang_sewa' => $newKodeKeranjang,
            'jumlah' => $jumlah,
            'subtotal' => $subtotal,
            'barang_id' => $productId,
            'user_id' => Auth::guard()->user()->id,
            'status' => 'dimasukan dalam keranjang',
        ]);
    }
}


