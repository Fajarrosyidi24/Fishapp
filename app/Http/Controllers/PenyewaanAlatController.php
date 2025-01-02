<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\BarangSewa;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PenyewaanAlatController extends Controller
{
    public function penyewaanview(Request $request){
        $reference = $request->query('reference');
        return view('penyewaanalat', compact('reference'));
    }

    public function penyewaanalat(Request $request){
        if (request()->routeIs('penyewaanalat') && !request()->has('reference')) {
            header("Location: " . route('penyewaanalat', ['reference' => 1]));
            exit;
        }
        $reference = $request->query('reference');
        return view('penyewaanalat', compact('reference'));
    }
}