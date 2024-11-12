<?php

namespace App\Http\Controllers;

use App\Models\AlamatPengirimanSeafood;
use App\Models\Nelayan;
use App\Models\Rekening;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NelayanProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class ProfileNelayanController extends Controller
{
    public function index(){
        $kabupaten = DB::table('indonesia_cities')->where('name', 'KABUPATEN BANYUWANGI')->first();
        $kecamatan = DB::table('indonesia_districts')->where('city_code', $kabupaten->code)->get();
        $nelayan = Auth::guard('nelayan')->user();
        $bank = Rekening::where('nelayan_id', Auth::guard('nelayan')->user()->id)->get();
        $alamat = AlamatPengirimanSeafood::where('nelayan_id', Auth::guard('nelayan')->user()->id)->first();
        $api = AlamatTransaksiController::api();
        $shownProvinces = [];
        return view('nelayan.profile.edit', compact('nelayan','kecamatan', 'bank', 'alamat', 'api', 'shownProvinces'));
    }

    public function deletepotouser(Request $request)
    {
        if (Auth::guard('nelayan')->user()->detailprofile->foto) {
            Storage::delete('public/fotonelayan/' . Auth::guard('nelayan')->user()->detailprofile->foto);
        }
        $nelayan = Nelayan::where('id', Auth::guard('nelayan')->user()->id)->first();
        $foto = NelayanProfile::where('nelayan_id', $nelayan->id)->first();
        $foto->foto = null;
        $foto->save();
        return redirect()->route('nelayan.profile')->with('success', 'Foto profil berhasil dihapus');
    }

    public function uploadpotouser(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (Auth::guard('nelayan')->user()->detailprofile->foto) {
            Storage::delete('public/fotonelayan/' . Auth::guard('nelayan')->user()->detailprofile->foto);
        }

        $fotoFile = $request->file('foto');
        $namaFileUnik = Str::uuid() . '_' . time() . '_' . $fotoFile->getClientOriginalName();
        $fotoPath = $fotoFile->storeAs('public/fotonelayan', $namaFileUnik);
        $nelayan = Nelayan::where('id', Auth::guard('nelayan')->user()->id)->first();
        $foto = NelayanProfile::where('nelayan_id', $nelayan->id)->first();
        $foto->foto = $namaFileUnik;
        $foto->save();
        return Redirect::route('nelayan.profile')->with('success', 'profile-updated');
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'nomer_telepon' => 'nullable|string|regex:/^[0-9]{10,14}$/',
            'district' => 'nullable|string|max:255',
            'sub_district' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'dusun' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'code_pos' => 'nullable|string|max:10',
            'nama_kapal' => 'nullable|string|max:255',
            'jenis_kapal' => 'nullable|string|max:255',
            'jumlah_abk' => 'nullable|integer|min:1',
        ]);
        
        $userId = Auth::guard('nelayan')->user()->id;
        Nelayan::updateprofile($validatedData, $userId);
        return redirect()->route('nelayan.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatebank(Request $request, $id)
    {
        $id = decrypt($id);
        $request->validate([
            'jenis_rekening' => 'required|string',
            'nomor_rekening' => 'required|string',
            'name_akun_bank' => 'required|string',
        ], [
            'jenis_rekening.required' => 'kolom jenis rekening wajib diisi',
            'nomor_rekening.required' => 'kolom Nomor rekening wajib diisi',
            'name_akun_bank.required' => 'kolom atas nama akun bank wajib diisi',
        ]);

        $up = DB::table('rekenings')
            ->where('kode_rekening', $id)
            ->update([
                'jenis_rekening' => $request->input('jenis_rekening'),
                'nomor_rekening' => $request->input('nomor_rekening'),
                'nama_akun_rekening' => $request->input('name_akun_bank'),
                'updated_at' => now(),
            ]);

        if ($up) {
            return redirect()->back()->with('success', 'success');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan. Silakan coba lagi.');
        }
    }

    public function deletebank($id)
    {
        $id = decrypt($id);
        $deleted = DB::table('rekenings')->where('kode_rekening', $id)->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'success');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus. Silakan coba lagi.');
        }
    }


    public function createbank(Request $request)
    {
        $request->validate([
            'jenis_rekening' => 'required|string',
            'nomor_rekening' => 'required|string',
            'name_akun_bank' => 'required|string',
        ], [
            'jenis_rekening.required' => 'kolom jenis rekening wajib diisi',
            'nomor_rekening.required' => 'kolom Nomor rekening wajib diisi',
            'name_akun_bank.required' => 'kolom atas nama akun bank wajib diisi',
        ]);

        $maxKoderekening = Rekening::max('kode_rekening');
        $nextNumber = intval(substr($maxKoderekening, 1)) + 1;
        $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $newKoderekening = 'R' . $formattedNumber;

        Rekening::create([
            'kode_rekening' => $newKoderekening,
            'jenis_rekening' => $request->input('jenis_rekening'),
            'nomor_rekening' => $request->input('nomor_rekening'),
            'nama_akun_rekening' => $request->input('name_akun_bank'),
            'nelayan_id' => Auth::guard('nelayan')->user()->id,
        ]);
        return redirect()->back()->with('success', 'success');
    }
}
