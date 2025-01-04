<?php

namespace App\Http\Controllers;

use App\Models\AlamatPengirimanSeafood;
use App\Models\AlamatTujuanSeafood;
use App\Models\Keranjang;
use App\Models\Nelayan;
use App\Models\PesananSeafood;
use App\Models\Seafood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::where([
            'status' => 'dimasukan dalam keranjang',
            'user_id' => Auth::guard()->user()->id,
        ])->get();
        $total = $keranjang->sum('subtotal');
        $alamat = AlamatTujuanSeafood::where('user_id', Auth::guard()->user()->id)->get();

        if ($alamat->isEmpty()) {
            return redirect()->route('alamat.pengiriman.pembeli')->with('error', 'Anda belum mengisikan alamat pengiriman, harap isikan alamat terlebih dahulu sebelum melakukan checkout');
        }
        return view('pembeli.keranjang.index', compact('keranjang', 'total','alamat'));
    }

    public function deleteItems($kodeBarangString)
    {
        $kodeBarangArray = explode(',', $kodeBarangString);
        foreach ($kodeBarangArray as $kode) {
            Keranjang::where('kode_keranjang', $kode)->delete();
        }
        return redirect()->back()->with('success', 'Item keranjang berhasil dihapus!');
    }

    public function processCheckoutseafood(Request $request)
    {
        $total = $request->input('total');
        $alamat = AlamatTujuanSeafood::where('user_id', Auth::guard()->user()->id)->get();

        if ($alamat->isEmpty()) {
            return redirect()->route('alamat.pengiriman.pembeli')->with('error', 'Anda belum mengisikan alamat pengiriman, harap isikan alamat terlebih dahulu sebelum melakukan checkout');
        }

        $kodeSeafoodArray = explode(',', $request->input('selected_items'));
       
        $keranjangs3 = Keranjang::whereIn('kode_keranjang', $kodeSeafoodArray)->get();
        $kode_seafood = Seafood::filterkode($keranjangs3);
        $id_nelayan = Nelayan::filterkode($kode_seafood);
        $id_pengiriman = AlamatPengirimanSeafood::filterkode($id_nelayan);
        $destination = AlamatTujuanSeafood::where('user_id', Auth::guard()->user()->id)->first();
        $tujuan = $destination->cityid;

        $keranjangs1 = Keranjang::whereIn('kode_keranjang', $kodeSeafoodArray)->get()->toArray();
        $jumlahSeafood = Seafood::jumlah($keranjangs1);

        $alamat_pengiriman = AlamatPengirimanSeafood::alamat($jumlahSeafood);
        $cityids = AlamatPengirimanSeafood::cityids($alamat_pengiriman);
        $combinedData = Seafood::combinedData($jumlahSeafood, $cityids);

        $aggregatedData = Seafood::aggregatedData($combinedData, $destination);

        $shippingCosts = KeranjangController::api($aggregatedData);
        $groupedCosts = KeranjangController::groupedCosts($shippingCosts);

        foreach ($groupedCosts as &$groupedCost) {
            $seafoodIds = $groupedCost['seafood_id'];
            foreach ($seafoodIds as $seafoodId) {
                foreach ($keranjangs3 as $keranjang) {
                    if ($keranjang['seafood_id'] == $seafoodId) {
                        $groupedCost['keranjangs'][] = $keranjang;
                    }
                }
            }
        }

        return view('pembeli.keranjang.checkoutseafood', compact('groupedCosts', 'alamat', 'total', 'keranjangs3',));
    }

    public function groupedCosts($shippingCosts)
    {
        $groupedCosts = [];
        foreach ($shippingCosts as $cost) {
            $nelayanId = $cost['nelayan_id'];
            if (!isset($groupedCosts[$nelayanId])) {
                $groupedCosts[$nelayanId] = [
                    'nelayan_id' => $nelayanId,
                    'origin' => $cost['origin'],
                    'destination' => $cost['destination'],
                    'weight' => $cost['weight'],
                    'seafood_id' => $cost['seafood_id'],
                    'shipping_options' => []
                ];
            }

            $groupedCosts[$nelayanId]['shipping_options'][] = [
                'courier' => $cost['courier'],
                'service' => $cost['service'],
                'description' => $cost['description'],
                'cost' => $cost['cost'],
                'etd' => $cost['etd']
            ];
        }

        return $groupedCosts;
    }

    public function api($aggregatedData)
    {
        //key fishapp
        $apiKey = "5a55b0466de0ea96eb1597c801442a01";
        $shippingCosts = [];
        foreach ($aggregatedData as $data) {
            $weightPerItem = 1000; //kg ke gram
            $totalWeight = $data['jumlah'] * $weightPerItem;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query([
                    'origin' => $data['origin'],
                    'destination' => $data['destination'],
                    'weight' => $totalWeight,
                    'courier' => 'jne'
                ]),
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key: $apiKey"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $responseDecoded = json_decode($response, true);
                if (isset($responseDecoded['rajaongkir']['results'])) {
                    foreach ($responseDecoded['rajaongkir']['results'] as $result) {
                        foreach ($result['costs'] as $cost) {
                            $shippingCosts[] = [
                                'nelayan_id' => $data['nelayan_id'],
                                'origin' => $data['origin'],
                                'destination' => $data['destination'],
                                'weight' => $totalWeight,
                                'courier' => $result['name'],
                                'service' => $cost['service'],
                                'description' => $cost['description'],
                                'cost' => $cost['cost'][0]['value'],
                                'etd' => $cost['cost'][0]['etd'],
                                'seafood_id' => $data['seafood_id']
                            ];
                        }
                    }
                }
            }
        }

        return $shippingCosts;
    }
}
