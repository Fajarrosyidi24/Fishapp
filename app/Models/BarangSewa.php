<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
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

}
