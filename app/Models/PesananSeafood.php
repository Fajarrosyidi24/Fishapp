<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
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
        'etd',
    ];

    public static function kirim($id){
        $data = self::find($id); 

        if ($data) {
            $data->status = 'dikirim';
            $data->save();

            foreach ($data->keranjangs as $keranjang) {
                $keranjang->status = 'dikirim';
                $keranjang->save();
            }
            return $data;
        } else {
            return null;
        }
    }

    public static function terima($id){
        $data = self::find($id); 

        if ($data) {
            $data->status = 'selesai';
            $data->save();

            foreach ($data->keranjangs as $keranjang) {
                $keranjang->status = 'selesai';
                $keranjang->save();
            }
            return $data;
        } else {
            return null;
        }
    }

    public function keranjangs()
    {
        return $this->belongsToMany(Keranjang::class, 'item_seafood_checkouts', 'tb_pemesanan_id', 'keranjang_id');
    }

    public function item()
    {
        return $this->belongsToMany(Pembayaran::class, 'item_pembayarans', 'pesanan_id', 'pembayaran_id');
    }

    public function pengiriman()
    {
        return $this->hasOne(PengirimanSeafood::class, 'pesanan_id', 'id');
    }

    public static function createdata($datapesanan, $keranjangCount, $jumlahSubtotal)
    {
        $user = Auth::user()->id;
        $alamat = AlamatTujuanSeafood::where('user_id', $user)->first();
        $destination = "$alamat->provinsi, $alamat->kabupaten, $alamat->kecamatan, $alamat->desa, RT.$alamat->rt/RW.$alamat->rw, Kode Pos : $alamat->code_pos";
        $tabelpesanan = self::create([
            'subtotal_harga' => $jumlahSubtotal,
            'jumlah_item' => $keranjangCount,
            'ongkir'=> $datapesanan['cost'],
            'total_keseluruhan_harga'=> $jumlahSubtotal + $datapesanan['cost'],
            'metode_pembayaran'=> 'Transfer Bank',
            'status' => 'menunggu pembayaran',
            'snap_token' => Str::random(15),
            'opsi_pengiriman' => $datapesanan['courier'],
            'alamat_pengiriman' => $destination,
            'etd' => $datapesanan['etd'],
        ]);

        return $tabelpesanan;
    }

    public static function filterRequest($grouppesananRaw)
    {
        $items = explode(';', $grouppesananRaw);
        $groupedData = [];
        foreach ($items as $item) {
            $item = trim($item);
            if (!empty($item)) {
                $groupedData[] = $item;
            }
        }

        return $groupedData;
    }

    public static function formattedData($groupedData)
    {
        $formattedData = [];
        foreach ($groupedData as $data) {
            $parts = explode(' -> ', $data);
            preg_match('/\[(\d+)\]/', $parts[0], $matches);
            $nelayanId = $matches[1];

            $details = explode(' - ', $parts[1]);
            $service = trim(explode('Biaya: RP', $details[0])[0]);
            $courier = $details[1];
            $cost = str_replace(['Biaya: RP ', '.'], ['', ''], $details[4]);
            $formatcost = $details[4] = (float)$cost;
            $etd = $details[3];
            $keranjang = $details[5];

            $formattedData[] = [
                'nelayan_id' => $nelayanId,
                'service' => $service,
                'courier' => $courier,
                'cost' => $formatcost,
                'etd' => $etd,
                'keranjang' => $keranjang,
            ];
        }

        return $formattedData;
    }


    public static function finaldata($formattedData)
    {
        $finalData = [];

        foreach ($formattedData as $data) {
            $keranjangItems = [];
            $keranjangList = trim($data['keranjang'], '[]'); // Menghapus tanda kurung
            $keranjangParts = explode(', ', $keranjangList); // Pisahkan berdasarkan koma

            foreach ($keranjangParts as $item) {
                // Pisahkan nama dan kode keranjang
                list($nama, $code) = explode(' = ', $item);
                $weight = Keranjang::where('kode_keranjang', $code)->first();
                $keranjangItems[] = [
                    'nama' => $nama,
                    'kode_keranjang' => $code,
                    'weight' => $weight->jumlah,
                ];
            }

            // Tambahkan hasil format ke final data

            $nelayanID = $weight->seafood->nelayan->id;
            $origin = AlamatPengirimanSeafood::where('nelayan_id', $nelayanID)->first();
            $destination = AlamatTujuanSeafood::where('user_id', Auth::user()->id)->first();
            $finalData[] = [
                'nelayan_id' => $data['nelayan_id'],
                'service' => $data['service'],
                'courier' => $data['courier'],
                'cost' => $data['cost'],
                'etd' => $data['etd'],
                'origin' => $origin->dusun . ', RT/RW.' . $origin->rt . '/' . $origin->rw . ', Desa ' . $origin->desa . ', Kecamatan ' . $origin->kecamatan . ', Kabupaten ' . $origin->kabupaten . ', Kode Pos :' . $origin->code_pos,
                'destination' => $destination->dusun . ', RT/RW.' . $destination->rt . '/' . $destination->rw . ', Desa ' . $destination->desa . ', Kecamatan ' . $destination->kecamatan . ', Kabupaten ' . $destination->kabupaten . ', Kode Pos :' . $destination->code_pos,
                'keranjang' => $keranjangItems // Menyimpan array keranjang yang sudah dipisah
            ];
        }

        return $finalData;
    }
}
