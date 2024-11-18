<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\AlamatTujuanSeafood;
use Illuminate\Support\Facades\Auth;
use App\Models\AlamatPengirimanSeafood;
use App\Models\PesananSeafood;

class PesanController extends Controller
{

    public function store(Request $request)
{
    $grouppesananRaw = $request->input('grouppesanan');
    $groupedData = PesananSeafood::filterRequest($grouppesananRaw);
    $formattedData = PesananSeafood::formattedData($groupedData);
    $finalData = PesananSeafood::finalData($formattedData);
    dd($finalData);
}
}
