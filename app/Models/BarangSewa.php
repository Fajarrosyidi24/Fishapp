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
     * Create a new barangsewa record from request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\BarangSewa
     */
    public static function createFromRequest(Request $request)
    {
        $fotoFile = $request->file('photo');

        // Loop untuk menemukan kode seafood yang unik
        do {
            $maxKodeBarang = BarangSewa::max('kode_barang');
            $nextNumber = $maxKodeBarang ? intval(substr($maxKodeBarang, 2)) + 1 : 1;
            $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            $newKodeBarang = 'BR' . $formattedNumber;
        } while (BarangSewa::where('kode_barang', $newKodeBarang)->exists()); 

        // Proses penyimpanan foto
        $namaFileUnik = Str::uuid() . '_' . time() . '_' . $fotoFile->getClientOriginalName();
        $fotoPath = $fotoFile->storeAs('public/fotobarang', $namaFileUnik);

        // Loop untuk menemukan kode harga seafood yang unik
        do {
            $maxKodeharga = HargaBarangSewa::max('kode_harga');
            $nextNumber1 = $maxKodeharga ? intval(substr($maxKodeharga, 1)) + 1 : 1; // Mulai dari 1 jika tidak ada kode sebelumnya
            $formattedNumber1 = str_pad($nextNumber1, 3, '0', STR_PAD_LEFT);
            $newKodeharga = 'HB' . $formattedNumber1;
        } while (HargaBarangSewa::where('kode_harga', $newKodeharga)->exists()); // Periksa apakah kode sudah ada

        self::create([
            'kode_barang' => $newKodeBarang,
            'nama_barang' => $request->input('name'),
            'kondisi' => $request->input('type'),
            'jumlah' => $request->input('quantity'),
            'foto_barang' => $namaFileUnik,
            'nelayan_id' => Auth::guard('nelayan')->user()->id,
            'status' => 'menunggu di verifikasi admin',
        ]);

        HargaBarangSewa::create([
            'kode_harga' => $newKodeharga,
            'harga' => $request->input('price'),
            'barang_id' => $newKodeBarang,
        ]);
    }
}
