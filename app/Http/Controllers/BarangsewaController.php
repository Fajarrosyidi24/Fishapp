<?php

namespace App\Http\Controllers;

use App\Models\BarangSewa;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BarangRequest;

class BarangsewaController extends Controller
{
    public function barangsewaguest()
    {
        $barang = BarangSewa::all();
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
}
