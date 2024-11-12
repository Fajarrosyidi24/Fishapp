<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\AlamatTujuanSeafood;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\RequestException;

class AlamatTransaksiController extends Controller
{
    // Cadangan supaya tak begitu ngeleg
        //fajar
        // $apiKey = "bd5f8ee60cb6a4b2f86c099e750cd0d3";

        // yasar
        // $apiKey = "72daf9a602bcf1197665be4110645c22";

        // fish app 
        // $apiKey = "5a55b0466de0ea96eb1597c801442a01";

    public function alamatpembeli()
    {
        $alamat = AlamatTujuanSeafood::where('user_id', Auth::guard()->user()->id)->get();
        $api = AlamatTransaksiController::api();
        return view('alamat.pembeli.index', compact('alamat', 'api'));
    }

    public function api()
    {
        $client = new Client();
        try {
            $response = $client->get('https://api.rajaongkir.com/starter/city', [
                'headers' => [
                    'key' => '72daf9a602bcf1197665be4110645c22',
                ],
            ]);
        } catch (RequestException $e) {
            var_dump($e->getResponse()->getBody()->getContents());
        }

        $json = $response->getBody()->getContents();
        $array_result = json_decode($json, true);
        $city = [];

        for ($i = 0; $i < count($array_result["rajaongkir"]["results"]); $i++) {
            $city[] = $array_result["rajaongkir"]["results"][$i];
        }

        return $city;
    }

    public function api2()
    {
        $client = new Client();
        try {
            $response = $client->get('https://api.rajaongkir.com/starter/city', [
                'headers' => [
                    'key' => 'bd5f8ee60cb6a4b2f86c099e750cd0d3',
                ],
            ]);
        } catch (RequestException $e) {
            var_dump($e->getResponse()->getBody()->getContents());
        }

        $json = $response->getBody()->getContents();
        $array_result = json_decode($json, true);
        $city = [];

        for ($i = 0; $i < count($array_result["rajaongkir"]["results"]); $i++) {
            $city[] = $array_result["rajaongkir"]["results"][$i];
        }

        return $city;
    }

    public function createalamattujuan(Request $request)
    {
        $api = AlamatTransaksiController::api2();
        $idProvince = (string) $request->input('provinsi');
        $idcity = (string) $request->input('city');

        $filteredData = array_filter($api, function ($item) use ($idProvince) {
            return (string) $item['province_id'] === $idProvince;
        });

        $filteredData2 = array_filter($api, function ($item) use ($idcity) {
            return (string) $item['city_id'] === $idcity;
        });

        $provinceName = '';
        if (!empty($filteredData)) {
            $provinceName = reset($filteredData)['province'];
        }

        $CityName = '';
        if (!empty($filteredData2)) {
            $CityName = reset($filteredData2)['city_name'];
        }

        AlamatTujuanSeafood::createdataalamat($request,$CityName, $provinceName,$idcity, $idProvince);
        return redirect()->back()->with('success', 'alamat berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $alamat = AlamatTujuanSeafood::findOrFail($id);
        $alamat->delete();
        return redirect()->back()->with('success', 'Alamat berhasil dihapus.');
    }
}
