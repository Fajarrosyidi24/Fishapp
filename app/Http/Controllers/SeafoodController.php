<?php

namespace App\Http\Controllers;

use App\Models\Seafood;
use App\Models\Rekening;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\PesananSeafood;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SeafoodRequest;
use App\Models\AlamatPengirimanSeafood;
use App\Models\Nelayan;

class SeafoodController extends Controller
{
    public function index(Request $request)
{
    $query = $request->input('search');
    $nelayanId = Auth::guard('nelayan')->user()->id;
    $seafood = Seafood::where('nelayan_id', $nelayanId);
    if ($query) {
        $seafood->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('nama', 'LIKE', "%{$query}%")
                         ->orWhere('jenis_seafood', 'LIKE', "%{$query}%");
        });
    }
    $seafood = $seafood->get();
    return view('nelayan.seafood.index', compact('seafood'));
}

    public function create()
    {
        $bank = Rekening::where('nelayan_id', Auth::guard('nelayan')->user()->id)->first();
        $alamat = AlamatPengirimanSeafood::where('nelayan_id', Auth::guard('nelayan')->user()->id)->first();
        if (is_null($bank)) {
            return redirect()->route('nelayan.profile')->with('status', 'mohon lengkapi profile serta informasi akun bank yang anda miliki');
        }elseif(is_null($alamat)){
            return redirect()->route('nelayan.profile')->with('status', 'anda belum menambahkan alamat pengiriman');
        }
        return view('nelayan.seafood.create');
    }

    public function store(SeafoodRequest $request)
    {
        $fotoFile = $request->file('photo');
        if (!$fotoFile) {
            return redirect()->back()->with('status', 'File foto tidak ada. Pastikan Anda mengunggah file yang benar.');
        }
        Seafood::createFromRequest($request);
        return redirect()->route('sefood.index')->with('success', 'Data seafood berhasil ditambahkan.');
    }

    public function detail($id)
    {
        $seafood=Seafood::where("kode_seafood", $id)->first();
     return view('nelayan.seafood.detail-seafood', compact('seafood'));
    }

    public function edit($id)
    {
    $seafood=Seafood::where("kode_seafood", $id)->first();
     return view('nelayan.seafood.edit-seafood', compact('seafood'));
    }

    public function editseafood(SeafoodRequest $request, $id)
    {
        $fotoFile = $request->file('photo');
        Seafood::updateFromRequest($request, $id);
        return redirect()->route('sefood.index')->with('success', 'Data seafood berhasil diedit.');
    }

    public function deleteseafood($kode_seafood)
    {
        Seafood::deleteFromRequest($kode_seafood);
        return redirect()->route('sefood.index')->with('success', 'Seafood berhasil dihapus.');
    }

    public function seafoodguest()
    {
        $seafood = Seafood::where('status', 'siap dijual')->get();
        return view('produkseafood', compact('seafood'));
    }

    public function pesananseafoodnelayan()
    {
       return view('nelayan.pesanan.seafood');
    }


    public function seafooduser()
    {
        $seafood = Seafood::where('status', 'siap dijual')->get();
        return view('pembeli.produk.seafood', compact('seafood'));
    }

    public function detailpesananseafood()
    {
        return view('nelayan.pesanan.detailpesananseafood');
    }

    public function chatwa($id)
    {
        $user = Nelayan::where('id', $id)->first();
        $whatsappNumber = '62' . ltrim($user->detailProfile->no_telepon, '0');
        $whatsappUrl = "https://wa.me/{$whatsappNumber}";
        return redirect($whatsappUrl);
    }

    public function beli($kode_seafood)
    {
        $seafood = Seafood::where('kode_seafood', $kode_seafood)->first();
        $produklainnya = Seafood::where('status', 'siap dijual')->get();
        return view('pembeli.produk.formpembelianseafood', compact('seafood', 'produklainnya'));
    }

    public function addchart($productId, $jumlah, $subtotal){
        Keranjang::createkeranjangseafood($productId, $jumlah, $subtotal);
        return redirect()->back()->with('success', 'Barang Telah dimasukan Kedalam Keranjang');
    }
}
