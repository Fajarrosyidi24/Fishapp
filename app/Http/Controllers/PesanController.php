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