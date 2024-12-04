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
use App\Models\ItemSeafoodCheckout;
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
        $admin = $request->input('adminFee');
        $totalshiping = $request->input('totalShipping');
        $subtotalproduk = $request->input('subtotalProduk');
        $total = $request->input('totalPayment');
        $user = User::where('id', Auth::user()->id)->first();

        $grouppesananRaw = $request->input('grouppesanan');
        $groupedData = PesananSeafood::filterRequest($grouppesananRaw);
        $formattedData = PesananSeafood::formattedData($groupedData);
        $finalData = PesananSeafood::finalData($formattedData);
        $pesanan = CreatePesanan::create($finalData);

        $pembayaran = Pembayaran::create($user, $total, $admin, $totalshiping, $subtotalproduk, $pesanan);

        $invoice = $this->paymentGateway->createInvoice($pembayaran);
        $reference = $invoice['reference'];
        return redirect(route('halamanpembayaranseafood', ['reference' => $reference]));
    }

    public function showPaymentPage(Request $request)
    {
        $reference = $request->query('reference');
        return view('payment.checkout', compact('reference'));
    }

    public function pesananview(Request $request){
        $reference = $request->query('reference');
        return view('pesananseafood', compact('reference'));
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


// $admin = $request->input('adminFee');
// $totalshiping = $request->input('totalShipping');
// $subtotalproduk = $request->input('subtotalProduk'); 
// $total = $request->input('totalPayment');
// $user = User::where('id', Auth::user()->id)->first();

// $grouppesananRaw = $request->input('grouppesanan');
// $groupedData = PesananSeafood::filterRequest($grouppesananRaw);
// $formattedData = PesananSeafood::formattedData($groupedData);
// $finalData = PesananSeafood::finalData($formattedData);
// $pesanan = CreatePesanan::create($finalData);

// $pembayaran = Pembayaran::create($user,$total,$admin,$totalshiping,$subtotalproduk,$pesanan);

// dd($pembayaran);

// $invoice = $this->paymentGateway->createInvoice($pembayaran);
// $reference = $invoice['reference'];
// return redirect(route('halamanpembayaranseafood', ['reference' => $reference]));