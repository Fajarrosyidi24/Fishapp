<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjangs';
    protected $primaryKey = 'kode_keranjang';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_keranjang',
        'jumlah',
        'subtotal',
        'status',
        'seafood_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function seafood()
    {
        return $this->belongsTo(Seafood::class, 'seafood_id', 'kode_seafood');
    }

    public function pesanan()
    {
        return $this->belongsToMany(PesananSeafood::class, 'item_seafood_checkouts','keranjang_id', 'tb_pemesanan_id');
    }

    public static function createkeranjangseafood($productId, $jumlah, $subtotal){
        $maxKodeKeranjang = Keranjang::max('kode_keranjang');
        $nextNumber = $maxKodeKeranjang ? intval(substr($maxKodeKeranjang, 2)) + 1 : 1;
        $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $newKodeKeranjang = 'KR' . $formattedNumber;

        self::create([
            'kode_keranjang' => $newKodeKeranjang,
            'jumlah' => $jumlah,
            'subtotal' => $subtotal,
            'seafood_id' => $productId,
            'user_id' => Auth::guard()->user()->id,
            'status' => 'dimasukan dalam keranjang',
        ]);
    }
}
