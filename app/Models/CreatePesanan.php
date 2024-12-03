<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreatePesanan extends Model
{
    public static function create($finalData)
    {
        $pesanan = [];
        foreach ($finalData as $datapesanan) {
            $keranjangCount = count($datapesanan['keranjang']);
            $kodeKeranjang = array_map(function ($item) {
                return $item['kode_keranjang'];
            }, $datapesanan['keranjang']);
            $keranjangData = Keranjang::whereIn('kode_keranjang', $kodeKeranjang)->get();
            $jumlahSubtotal = $keranjangData->sum('subtotal');
            $pesananSeafood = PesananSeafood::createdata($datapesanan, $keranjangCount, $jumlahSubtotal);
            ItemSeafoodCheckout::createdata($pesananSeafood, $keranjangData);
            $pesanan[] = $pesananSeafood;
        }

        return $pesanan;
    }
}
