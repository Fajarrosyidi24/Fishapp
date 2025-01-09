<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangSewa extends Model
{
    use HasFactory;

    protected $table = 'barang_sewas';
    protected $primaryKey = 'kode_barang';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kondisi',
        'jumlah',
        'foto_barang',
        'nelayan_id',
        'status',
    ];

    public function nelayan()
    {
        return $this->belongsTo(Nelayan::class, 'nelayan_id');
    }

    public function harga()
    {
        return $this->hasOne(HargaBarangSewa::class, 'barang_id', 'kode_barang');
    }

    /**
     * Create a new seafood record from request data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\BarangSewa
     */
    public static function createFromRequest(Request $request)
    {
        // Proses penyimpanan foto
        if ($request->hasFile('photo')) {
            $fotoFile = $request->file('photo');
            $namaFileUnik = Str::uuid() . '_' . time() . '_' . $fotoFile->getClientOriginalName();
            $fotoPath = $fotoFile->storeAs('public/fotobarang/', $namaFileUnik);
        }

        // Membuat kode unik untuk barang
        $newKodeBarang = 'BR' . str_pad((BarangSewa::max('kode_barang') ? intval(substr(BarangSewa::max('kode_barang'), 2)) + 1 : 1), 3, '0', STR_PAD_LEFT);

        // Menyimpan data seafood
        $barangsewa = self::create([
            'kode_barang' => $newKodeBarang,
            'nama_barang' => $request->input('name'),
            'kondisi' => $request->input('type'),
            'jumlah' => $request->input('quantity'),
            'foto_barang' => $namaFileUnik ?? null,
            'nelayan_id' => Auth::guard('nelayan')->id(),
            'status' => 'menunggu di verifikasi admin',
        ]);

        // Membuat kode unik untuk harga barang
        $newKodeHarga = 'HB' . str_pad((HargaBarangSewa::max('kode_harga') ? intval(substr(HargaBarangSewa::max('kode_harga'), 2)) + 1 : 1), 3, '0', STR_PAD_LEFT);
        HargaBarangSewa::create([
            'kode_harga' => $newKodeHarga,
            'harga' => $request->input('price'),
            'barang_id' => $newKodeBarang,
        ]);

        return $barangsewa;
    }

    public static function updateFromRequest($request, $id){
        $barang = self::findOrFail($id);
        $fotoFile = $request->file('photo');

        if ($fotoFile) {
            $namaFileUnik = Str::uuid() . '_' . time() . '_' . $fotoFile->getClientOriginalName();
            $fotoPath = $fotoFile->storeAs('public/fotobarang', $namaFileUnik);
            Storage::delete('public/fotobarang/' . $barang->foto_barang);
            $barang->foto_barang = $namaFileUnik;
        }
        $barang->nama_barang = $request->input('name');
        $barang->kondisi = $request->input('type');
        $barang->jumlah = $request->input('quantity');
        $barang->save();

        $barang->harga->harga = $request->input('price');
        $barang->harga->save();
    }

    public static function deleteFromRequest($kode_barang)
    {
        $barang = self::findOrFail($kode_barang);
        if ($barang->foto_barang) {
            $fotoPath = 'public/fotobarang/' . $barang->foto_barang;
            if (Storage::exists($fotoPath)) {
                Storage::delete($fotoPath);
            }
        }
        $barang->delete();
    }

    public static function filterkode($keranjang)
    {
        $kodeBarang = [];
        foreach ($keranjang as $ke) {
            $barang = BarangSewa::where('kode_barang', $ke->barang_id)->first();
            if ($barang) {
                $kodeBarang[] = $barang->kode_barang;
            }
        }

        return $kodeBarang;
    }

    public static function jumlah($keranjangs1)
    {
        $jumlahBarang = [];
        foreach ($keranjangs1 as $keranjang) {
            $barang_id = $keranjang['barang_id'];
            $barang = BarangSewa::where('kode_barang', $barang_id)->first();
            if ($barang) {
                $nelayan_id = $barang->nelayan_id;
                if (isset($jumlahBarang[$barang_id])) {
                    $jumlahBarang[$barang_id]['jumlah'] += $keranjang['jumlah'];
                } else {
                    $jumlahBarang[$barang_id] = [
                        'nelayan_id' => $nelayan_id,
                        'jumlah' => $keranjang['jumlah'],
                        'harga/jam' => $barang->harga->harga,
                        'subtotal' => $barang->harga->harga * $keranjang['jumlah'],
                    ];
                }
            }
        }
        return $jumlahBarang;
    }

    public static function groupdata($jumlahBarang){
        $groupedBarang = [];
        foreach ($jumlahBarang as $kodeBarang => $data) {
            $nelayanId = $data['nelayan_id'];
            if (!isset($groupedBarang[$nelayanId])) {
                $groupedBarang[$nelayanId] = [
                    'nelayan_id' => $nelayanId,
                    'items' => [], // Menyimpan barang-barang dengan nelayan_id yang sama
                    'total_jumlah' => 0,
                    'total_subtotal' => 0,
                ];
            }

            $groupedBarang[$nelayanId]['items'][$kodeBarang] = $data;

            // Tambahkan jumlah dan subtotal ke total grup
            $groupedBarang[$nelayanId]['total_jumlah'] += $data['jumlah'];
            $groupedBarang[$nelayanId]['total_subtotal'] += $data['subtotal'];
        }

        return $groupedBarang;
    }

}
