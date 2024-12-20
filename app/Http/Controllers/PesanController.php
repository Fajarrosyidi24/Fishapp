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

<<<<<<< HEAD
    public function pesananseafood(Request $request){
        if (request()->routeIs('pesananseafood') && !request()->has('reference')) {
            header("Location: " . route('pesananseafood', ['reference' => 1]));
            exit;
=======
    public function pesananseafood(Request $request)
    {
        // Redirect ke reference default jika tidak ada parameter reference
        if (request()->routeIs('pesananseafood') && !$request->has('reference')) {
            return redirect()->route('pesananseafood', ['reference' => 1]);
>>>>>>> 610b4a6be2f57dae9c58149e024e4694db0a5bb8
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
        }else{
            return redirect()->route('pesananseafood', ['reference' => 1]);
        }

        return view('pesananseafood', compact('reference', 'pesanan'));
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
        StatusPembayaran::updateStatus($idStatus);
        $itemPembayaran = ItemPembayaran::where('pembayaran_id', $pembayaran->id)->pluck('pesanan_id');
        $pesanan = PesananSeafood::whereIn('id', $itemPembayaran)->get();
        PesananSeafood::whereIn('id', $itemPembayaran)->update(['status' => 'sedang dikemas']);
        $itemKeranjang = ItemSeafoodCheckout::whereIn('tb_pemesanan_id', $pesanan->pluck('id'))->get();
        $idkeranjang = $itemKeranjang->pluck('keranjang_id');
        Keranjang::whereIn('kode_keranjang', $idkeranjang)->update(['status' => 'sedang dikemas']);
        return redirect()->route('pesananseafood')->with('status', 'pesanan anda sedang dikemas');
    }
}
