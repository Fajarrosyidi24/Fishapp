<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seafood extends Model
{
    use HasFactory;

    protected $table = 'seafoods';
    protected $primaryKey = 'kode_seafood';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_seafood',
        'nama',
        'jenis_seafood',
        'jumlah',
        'foto',
        'nelayan_id',
        'status',
    ];

    public function nelayan()
    {
        return $this->belongsTo(Nelayan::class, 'nelayan_id');
    }

    public function harga()
    {
        return $this->hasOne(HargaSeafood::class, 'seafood_id', 'kode_seafood');
    }

    /**
     * Create a new seafood record from request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Seafood
     */
    public static function createFromRequest(Request $request)
    {
        $fotoFile = $request->file('photo');

        // Loop untuk menemukan kode seafood yang unik
        do {
            $maxKodeSeafood = Seafood::max('kode_seafood');
            $nextNumber = $maxKodeSeafood ? intval(substr($maxKodeSeafood, 2)) + 1 : 1; // Mulai dari 1 jika tidak ada kode sebelumnya
            $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            $newKodeSeafood = 'SF' . $formattedNumber;
        } while (Seafood::where('kode_seafood', $newKodeSeafood)->exists()); // Periksa apakah kode sudah ada

        // Proses penyimpanan foto
        $namaFileUnik = Str::uuid() . '_' . time() . '_' . $fotoFile->getClientOriginalName();
        $fotoPath = $fotoFile->storeAs('public/fotoseafood', $namaFileUnik);

        // Loop untuk menemukan kode harga seafood yang unik
        do {
            $maxKodeharga = HargaSeafood::max('kode_harga');
            $nextNumber1 = $maxKodeharga ? intval(substr($maxKodeharga, 1)) + 1 : 1; // Mulai dari 1 jika tidak ada kode sebelumnya
            $formattedNumber1 = str_pad($nextNumber1, 3, '0', STR_PAD_LEFT);
            $newKodeharga = 'H' . $formattedNumber1;
        } while (HargaSeafood::where('kode_harga', $newKodeharga)->exists()); // Periksa apakah kode sudah ada

        // Menyimpan data seafood
        self::create([
            'kode_seafood' => $newKodeSeafood,
            'nama' => $request->input('name'),
            'jenis_seafood' => $request->input('type'),
            'jumlah' => $request->input('quantity'),
            'foto' => $namaFileUnik,
            'nelayan_id' => Auth::guard('nelayan')->user()->id,
            'status' => 'menunggu di verifikasi admin',
        ]);

        HargaSeafood::create([
            'kode_harga' => $newKodeharga,
            'harga' => $request->input('price'),
            'seafood_id' => $newKodeSeafood,
        ]);
    }

    public static function updateFromRequest(Request $request, $id)
    {
        $seafood = self::findOrFail($id);
        $fotoFile = $request->file('photo');

        if ($fotoFile) {
            $namaFileUnik = Str::uuid() . '_' . time() . '_' . $fotoFile->getClientOriginalName();
            $fotoPath = $fotoFile->storeAs('public/fotoseafood', $namaFileUnik);
            Storage::delete('public/fotoseafood/' . $seafood->foto);
            $seafood->foto = $namaFileUnik;
        }
        $seafood->nama = $request->input('name');
        $seafood->jenis_seafood = $request->input('type');
        $seafood->jumlah = $request->input('quantity');
        $seafood->save();

        $seafood->harga->harga = $request->input('price');
        $seafood->harga->save();
    }

    public static function deleteFromRequest($kode_seafood)
    {
        $seafood = self::findOrFail($kode_seafood);
        if ($seafood->foto) {
            $fotoPath = 'public/fotoseafood/' . $seafood->foto;
            if (Storage::exists($fotoPath)) {
                Storage::delete($fotoPath);
            }
        }
        $seafood->delete();
    }
}
