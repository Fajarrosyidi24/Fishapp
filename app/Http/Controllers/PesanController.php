<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\ApiDuitku;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\PesananSeafood;
use App\Models\AlamatTujuanSeafood;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\AlamatPengirimanSeafood;
use App\Interface\PaymentGatewayInterface;
use App\Models\CreatePesanan;
use App\Models\ItemPembayaran;
use App\Models\ItemSeafoodCheckout;
use App\Models\Merchant;
use App\Models\Pembayaran;
use App\Models\PenerimaanSeafood;
use App\Models\Seafood;
use App\Models\StatusPembayaran;
use App\Models\UserProfile;

class PesanController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store(Request $request)
    {
        $profile = UserProfile::where('user_id', Auth::user()->id)->first();
        if (is_null($profile)) {
            return redirect()->route('profile.edit')->with('status', 'harap lengkapi profile terlebih dahulu sebelum melakukan pemesanan');
        }

        $total = $request->input('totalPayment');
        $user = User::where('id', Auth::user()->id)->first();

        $grouppesananRaw = $request->input('grouppesanan');
        $groupedData = PesananSeafood::filterRequest($grouppesananRaw);
        $formattedData = PesananSeafood::formattedData($groupedData);
        $finalData = PesananSeafood::finalData($formattedData);
        $pesanan = CreatePesanan::create($finalData);
        $params = ApiDuitku::params($user, $total, $pesanan);

        $pembayaran = Pembayaran::store($params);
        $idpembayaran = $pembayaran->id;
        ItemPembayaran::createitem($idpembayaran, $pesanan);

        $invoice = $this->paymentGateway->createInvoice($params);
        Merchant::store($invoice, $idpembayaran);
        StatusPembayaran::store($idpembayaran);
        $reference = $invoice['reference'];
        return redirect(route('halamanpembayaranseafood', ['reference' => $reference, 'idpembayaran' => $idpembayaran]));
    }

    public function showPaymentPage(Request $request)
    {
        $reference = $request->query('reference');
        $idpembayaran = $request->query('idpembayaran');
        $pembayaran = Pembayaran::where('id', $idpembayaran)->first();
        return view('payment.checkout', compact('reference', 'pembayaran'));
    }

    public function returnUrl($merchantOrderId, $email)
    {
        $user = User::where('email', $email)->first();
        $pembayaran = Pembayaran::where('user_id', $user->id)->first();
        $merchant = Merchant::where('pembayaran_id', $pembayaran->id)->first();
        return redirect(route('halamanpembayaranseafood', ['reference' => $merchant->reference, 'idpembayaran' => $pembayaran->id]));
    }

    public function pesananseafood(Request $request)
    {
        // Redirect ke reference default jika tidak ada parameter reference
        if (request()->routeIs('pesananseafood') && !$request->has('reference')) {
            return redirect()->route('pesananseafood', ['reference' => 1]);
        }

        $reference = $request->query('reference');
        $pesanan = null;

        if ($reference == 1) {
            // Kondisi reference = 1
            $pesanan = PesananSeafood::with('keranjangs')
                ->get()
                ->filter(function ($pesanan) {
                    return $pesanan->keranjangs->contains('user_id', Auth::user()->id);
                });
        } elseif ($reference == 2) {
            // Kondisi reference = 2
            $pesanan = PesananSeafood::with('keranjangs')
                ->where('status', 'menunggu pembayaran')
                ->get()
                ->filter(function ($pesanan) {
                    return $pesanan->keranjangs->contains('user_id', Auth::user()->id);
                });
        } elseif ($reference == 3) {
            // Kondisi reference = 3
            $pesanan = PesananSeafood::with('keranjangs')
                ->where('status', 'sedang dikemas')
                ->get()
                ->filter(function ($pesanan) {
                    return $pesanan->keranjangs->contains('user_id', Auth::user()->id);
                });
        } elseif ($reference == 4) {
            // Kondisi reference = 2
            $pesanan = PesananSeafood::with('keranjangs')
                ->where('status', 'dikirim')
                ->get()
                ->filter(function ($pesanan) {
                    return $pesanan->keranjangs->contains('user_id', Auth::user()->id);
                });
        } elseif ($reference == 5) {
            // Kondisi reference = 2
            $pesanan = PesananSeafood::with('keranjangs')
                ->where('status', 'selesai')
                ->get()
                ->filter(function ($pesanan) {
                    return $pesanan->keranjangs->contains('user_id', Auth::user()->id);
                });
        } elseif ($reference == 6) {
            // Kondisi reference = 2
            $pesanan = PesananSeafood::with('keranjangs')
                ->where('status', 'selesai')
                ->get()
                ->filter(function ($pesanan) {
                    return $pesanan->keranjangs->contains('user_id', Auth::user()->id);
                });
        } else {
            return redirect()->route('pesananseafood', ['reference' => 1]);
        }

        return view('pesananseafood', compact('reference', 'pesanan'));
    }

    public function penyewaanalat(Request $request)
    {
        return view('penyewaanalat');
    }


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

    public function chatwa($id)
    {
        $whatsappNumber = '62' . ltrim($id, '0');
        $whatsappUrl = "https://wa.me/{$whatsappNumber}";
        return redirect($whatsappUrl);
    }

    public function updatePaymentStatus(Request $request)
    {
        $result = $request->input('result');
        $data = json_decode($result, true);
        $merchantOrderId = $data['merchantOrderId'] ?? null;
        $pembayaran = Pembayaran::where('merchant_order_id', $merchantOrderId)->first();
        $status = StatusPembayaran::where('pembayaran_id', $pembayaran->id)->first();
        $idStatus = $status->id;

        $itemPembayaran = ItemPembayaran::where('pembayaran_id', $pembayaran->id)->pluck('pesanan_id');
        $pesanan = PesananSeafood::whereIn('id', $itemPembayaran)->get();

        if ($pesanan->contains('status', 'menunggu pembayaran')) {
            StatusPembayaran::updateStatus($idStatus);
            PesananSeafood::whereIn('id', $itemPembayaran)->update(['status' => 'sedang dikemas']);
            $itemKeranjang = ItemSeafoodCheckout::whereIn('tb_pemesanan_id', $pesanan->pluck('id'))->get();
            $idkeranjang = $itemKeranjang->pluck('keranjang_id');
            Keranjang::whereIn('kode_keranjang', $idkeranjang)->update(['status' => 'sedang dikemas']);
            return redirect()->route('pesananseafood')->with('status', 'pesanan anda sedang dikemas');
        } else {
            return redirect()->route('pesananseafood');
        }
    }

    public function detailPesanan($id)
    {
        $pesanan = PesananSeafood::where('id', $id)->first();
        return view('pembeli.detailpesananseafood', compact('pesanan'));
    }


    public function storebuktipenerimaan(Request $request, $id)
    {
        $validated = $request->validate([
            'photo' => 'required|string',  // Validasi jika 'photo' berupa string Base64
        ]);
        $base64Image = $request->input('photo');
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
            $imageExtension = $matches[1];  // jpg, png, jpeg, gif
            $imageData = substr($base64Image, strpos($base64Image, ',') + 1);
            $imageData = base64_decode($imageData);
            if (!in_array($imageExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                return back()->withErrors(['photo' => 'Foto harus berupa: jpg, jpeg, png, gif.']);
            }
            if (strlen($imageData) > 10240 * 1024) {  // 10MB
                return back()->withErrors(['photo' => 'ukuran foto tidak boleh lebih 10MB.']);
            }

            $bukti = PenerimaanSeafood::where('pesanan_id', $id)->first();

            if ($bukti) {
                $oldImagePath = storage_path('app/public/fotopenerimaanseafood/' . $bukti->foto);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                $imageName = 'photo_' . time() . '.' . $imageExtension;
                $imagePath = storage_path('app/public/fotopenerimaanseafood/' . $imageName);
                file_put_contents($imagePath, $imageData);

                $bukti->upload_foto_bukti_penerimaan = $imageName;
                $bukti->save();
                PesananSeafood::terima($id);
                return back()->with('success', 'Foto berhasil diperbarui!');
            } else {
                $imageName = 'photo_' . time() . '.' . $imageExtension;
                $imagePath = storage_path('app/public/fotopenerimaanseafood/' . $imageName);
                file_put_contents($imagePath, $imageData);
                PenerimaanSeafood::store($imageName, $id);
                PesananSeafood::terima($id);
                return back()->with('success', 'Foto berhasil diunggah!');
            }
        } else {
            return back()->withErrors(['photo' => 'Invalid image data.']);
        }
    }
}
