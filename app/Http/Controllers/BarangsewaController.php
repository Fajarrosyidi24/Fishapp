<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\BarangSewa;
use App\Http\Requests\BarangRequest;
use Illuminate\Support\Facades\Auth;

class BarangsewaController extends Controller
{
    public function barangsewaguest()
    {
        $barang = BarangSewa::where('status', 'siap dijual')->get();
        return view('produkbarangsewa', compact('barang'));
    }

    public function index()
    {
        $nelayanId = Auth::guard('nelayan')->user()->id;
        $barangsewa = BarangSewa::where('nelayan_id', $nelayanId)->get();
        return view('nelayan.barang.index', compact('barangsewa'));
    }

    public function create()
    {
        $bank = Rekening::where('nelayan_id', Auth::guard('nelayan')->user()->id)->first();
        if (is_null($bank)) {
            return redirect()->route('nelayan.profile')->with('status', 'harap melengkapi profile serta informasi akun bank yang anda miliki');
        }
        return view('nelayan.barang.create');
    }


    public function store(BarangRequest $request)
    {
        $fotoFile = $request->file('photo');
        if (!$fotoFile) {
            return redirect()->back()->with('status', 'File foto tidak ada. Pastikan Anda mengunggah file yang benar.');
        }

        BarangSewa::createFromRequest($request);
       return redirect()->route('barangsewa.index')->with('success', 'data barang berhasil ditambahkan');
    }

    public function pesananbarangsewanelayan(){
        return view('nelayan.pesanan.barangsewa');
    }

    public function detailpesananbarangsewa()
    {
        return view('nelayan.pesanan.detailpesananbarangsewa');
    }

    public function barangsewauser()
    {
        $barang = BarangSewa::where('status', 'siap dipesan')->get();
        return view('pembeli.produk.barangsewa', compact('barang'));
    }
}
