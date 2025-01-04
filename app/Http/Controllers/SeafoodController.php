<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nelayan;
use App\Models\Seafood;
use App\Models\Merchant;
use App\Models\Rekening;
use App\Models\Keranjang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ItemPembayaran;
use App\Models\PesananSeafood;
use App\Models\PengirimanSeafood;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SeafoodRequest;
use App\Models\AlamatPengirimanSeafood;
use App\Models\RatingSeafood;

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
        } elseif (is_null($alamat)) {
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
        $seafood = Seafood::where("kode_seafood", $id)->first();
        return view('nelayan.seafood.detail-seafood', compact('seafood'));
    }

    public function edit($id)
    {
        $seafood = Seafood::where("kode_seafood", $id)->first();
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
        foreach ($seafood as $item) {
            $item->jumlah_terjual = $item->keranjangs->filter(function ($keranjang) {
                // Filter pesanan yang memiliki status 'selesai'
                return $keranjang->pesanan->where('status', 'selesai')->count() > 0;
            })->count();
        }
        return view('produkseafood', compact('seafood'));
    }

    public function pesananseafoodnelayan()
    {
        $pesananSeafood = PesananSeafood::with('keranjangs.seafood')
            ->whereIn('status', ['menunggu pembayaran', 'sedang dikemas', 'dikirim'])
            ->get()
            ->filter(function ($pesanan) {
                return $pesanan->keranjangs
                    ->filter(function ($keranjang) {
                        return $keranjang->seafood->nelayan_id === Auth::guard('nelayan')->user()->id;
                    })
                    ->isNotEmpty();
            });
        return view('nelayan.pesanan.seafood', compact('pesananSeafood'));
    }


    public function seafooduser()
    {
        $seafood = Seafood::where('status', 'siap dijual')->get();
        foreach ($seafood as $item) {
            $item->jumlah_terjual = $item->keranjangs->filter(function ($keranjang) {
                // Filter pesanan yang memiliki status 'selesai'
                return $keranjang->pesanan->where('status', 'selesai')->count() > 0;
            })->count();
        }
        return view('pembeli.produk.seafood', compact('seafood'));
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
        // Ambil seafood berdasarkan kode, dengan relasi keranjangs dan pesanan
            $seafood = Seafood::where('kode_seafood', $kode_seafood)
            ->with(['keranjangs.pesanan'])
            ->first();

        // Hitung jumlah terjual untuk seafood yang dipilih
        $seafood->jumlah_terjual = $seafood->keranjangs->filter(function ($keranjang) {
            return $keranjang->pesanan->where('status', 'selesai')->count() > 0;
        })->count();

        $produklainnya = Seafood::where('status', 'siap dijual')->get();
        foreach ($produklainnya as $item) {
            $item->jumlah_terjual = $item->keranjangs->filter(function ($keranjang) {
                // Filter pesanan yang memiliki status 'selesai'
                return $keranjang->pesanan->where('status', 'selesai')->count() > 0;
            })->count();
        }
        return view('pembeli.produk.formpembelianseafood', compact('seafood', 'produklainnya'));
    }

    public function addchart($productId, $jumlah, $subtotal)
    {
        Keranjang::createkeranjangseafood($productId, $jumlah, $subtotal);
        return redirect()->back()->with('success', 'Barang Telah dimasukan Kedalam Keranjang');
    }

    public function history_seafood()
    {
        return view('nelayan.pesanan.seafood');
    }

    public function detailpembayaran($id, $pesanan_id)
    {
        $pesananSeafood = PesananSeafood::where('id', $pesanan_id)->first();

        // Ambil ID pembayaran terkait dengan pesanan tersebut
        $itempembayaran = ItemPembayaran::where('pesanan_id', $pesananSeafood->id)->first();
        $idpembayaran = $itempembayaran->pembayaran_id;

        // Query pesanan berdasarkan ID pembayaran dan user_id
        $pesanan = PesananSeafood::with('keranjangs')
            // Filter berdasarkan ID pembayaran pada relasi item
            ->whereHas('item', function ($query) use ($idpembayaran) {
                $query->where('pembayaran_id', $idpembayaran);
            })
            // Filter berdasarkan user_id pada relasi keranjang
            ->whereHas('keranjangs', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->get();

        $merchant = Merchant::where('pembayaran_id', $idpembayaran)->first();
        $reference = $merchant->reference;

        // Kirim data pesanan ke view
        return view('nelayan.pesanan.detailpembayaran', compact('pesanan', 'reference'));
    }

    public function storebuktipengiriman(Request $request, $id)
    {
        $fotoFile = $request->file('photo');
        $imageName = Str::uuid() . '_' . time() . '_' . $fotoFile->getClientOriginalName();
        $fotoPath = $fotoFile->storeAs('public/fotopenerimaanseafood', $imageName);
        $bukti = PengirimanSeafood::where('pesanan_id', $id)->first();
        PengirimanSeafood::store($imageName, $id);
        PesananSeafood::kirim($id);
        return back()->with('success', 'Foto berhasil diunggah!');
    }

    public function ratingpost(Request $request, $seafood){
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',  // Pastikan rating adalah angka antara 1 hingga 5
            'ulasan' => 'nullable|string|max:255', // Ulasan bersifat opsional dan maksimal 255 karakter
        ], [
            'rating.required' => 'Pilih rating yang sesuai.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.between' => 'Rating harus antara 1 dan 5.',
            'ulasan.max' => 'Ulasan tidak boleh lebih dari 255 karakter.',
        ]);

        $idpesanan = PesananSeafood::where('id', $seafood)->first();
        $keranjangs = $idpesanan->keranjangs;
        foreach ($keranjangs as $keranjang) {
           $rating = RatingSeafood::create([
            'seafood_id' => $keranjang->seafood->kode_seafood,
            'rating' => $validated['rating'],
            'review' =>  $validated['ulasan'],
           ]);
        }
        return redirect()->back()->with('success', 'Rating telah diperbarui!');
    }
}
