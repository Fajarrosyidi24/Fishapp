<?php

namespace App\Http\Controllers;

use App\Models\Seafood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SeafoodRequest;

class SeafoodController extends Controller
{
    public function index(Request $request)
{
    $query = $request->input('search');
    $nelayanId = Auth::guard('nelayan')->user()->id;

    // query untuk mengambil seafood
    $seafood = Seafood::where('nelayan_id', $nelayanId);

    // pencarian berdasarkan nama atau jenis_seafood jika ada input pencarian
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
        return view('nelayan.seafood.create');
    }

    public function store(SeafoodRequest $request)
    {
        $fotoFile = $request->file('photo');
        if (!$fotoFile) {
            return redirect()->back()->with('status', 'File foto tidak ada. Pastikan Anda mengunggah file yang benar.');
        }
        // Menyimpan seafood baru dan harga menggunakan request yang sudah divalidasi
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
        return redirect()->back()->with('success', 'Seafood berhasil dihapus.');
    }

    public function seafoodguest()
    {
        $seafood = Seafood::where('status', 'siap dijual')->get();
        return view('produkseafood', compact('seafood'));
    }
}
