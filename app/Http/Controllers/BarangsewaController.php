<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\BarangSewa;
use Illuminate\Http\Request;
use App\Http\Requests\BarangRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\AlamatPengirimanSeafood;
use App\Models\KeranjangBarangSewa;

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
        $alamat = AlamatPengirimanSeafood::where('nelayan_id', Auth::guard('nelayan')->user()->id)->first();
        if (is_null($bank)) {
            return redirect()->route('nelayan.profile')->with('status', 'harap melengkapi profile serta informasi akun bank yang anda miliki');
        }
        elseif(is_null($alamat)){
            return redirect()->route('nelayan.profile')->with('status', 'anda belum menambahkan alamat pengiriman');
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
        $barang = BarangSewa::where('status', 'siap dijual')->get();
        return view('pembeli.produk.barangsewa', compact('barang'));
    }

    public function history_barangsewa()
     {
        return view('nelayan.pesanan.barangsewa');
    }

    public function detail($id){
        $barang = BarangSewa::where("kode_barang", $id)->first();
        return view('nelayan.barang.detail-barang', compact('barang'));
    }

    public function edit($id){
        $barang = BarangSewa::where("kode_barang", $id)->first();
        return view('nelayan.barang.edit-barang', compact('barang'));
    }

    public function editbarang(BarangRequest $request, $id){
        $fotoFile = $request->file('photo');
        BarangSewa::updateFromRequest($request, $id);
        return redirect()->route('barangsewa.index')->with('success', 'Data Barang berhasil diedit.');
    }

    public function deletebarang($kode_barang){
        BarangSewa::deleteFromRequest($kode_barang);
        return redirect()->route('barangsewa.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function beli($kode_barang)
    {
        $barang = BarangSewa::where('kode_barang', $kode_barang)->first();
        $produklainnya = BarangSewa::where('status', 'siap dijual')->get();
        return view('pembeli.produk.formpenyeaanbarang', compact('barang', 'produklainnya'));
    }

    public function addchart($productId, $jumlah, $subtotal)
    {
        KeranjangBarangSewa::createkeranjangbarang($productId, $jumlah, $subtotal);
        return redirect()->back()->with('success', 'Barang Telah dimasukan Kedalam Keranjang');
    }
}
