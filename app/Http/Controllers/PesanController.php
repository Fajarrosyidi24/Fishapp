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

class PesanController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store(Request $request)
    {
        $total = $request->input('totalPayment');
        $user = User::where('id', Auth::user()->id)->first();

        $grouppesananRaw = $request->input('grouppesanan');
        $groupedData = PesananSeafood::filterRequest($grouppesananRaw);
        $formattedData = PesananSeafood::formattedData($groupedData);
        $finalData = PesananSeafood::finalData($formattedData);
        dd($finalData);
        // $pesanan = CreatePesanan::create($finalData);
        // $params = ApiDuitku::params($user, $total, $pesanan);

        // $pembayaran = Pembayaran::store($params);
        // $idpembayaran = $pembayaran->id;
        // ItemPembayaran::createitem($idpembayaran, $pesanan);

        // $invoice = $this->paymentGateway->createInvoice($params);
        // Merchant::store($invoice, $idpembayaran);
        // $reference = $invoice['reference'];
        // return redirect(route('halamanpembayaranseafood', ['reference' => $reference, 'idpembayaran' => $idpembayaran]));
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

    public function pesananview(Request $request){
        $reference = $request->query('reference');
        return view('pesananseafood', compact('reference'));
    }

    public function semua(){
        return view('profile.pesananuser.semuapesanan');
    }

    public function belumbayar(){
        return view('pembeli.pesananseafood.belumbayar');
    }

    public function sedangdikirim(){
        return view('pembeli.pesananseafood.sedangdikirim');
    }

    public function pesananseafood(Request $request){
        if (request()->routeIs('pesananseafood') && !request()->has('reference')) {
            header("Location: " . route('pesananseafood', ['reference' => 1]));
            exit;
        }
        $reference = $request->query('reference');
        return view('pesananseafood', compact('reference'));
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
}
