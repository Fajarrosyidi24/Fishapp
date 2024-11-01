<?php

namespace App\Http\Controllers;

use App\Models\Nelayan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NelayanProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\NelayanRegistrationRequest;

class NelayanController extends Controller
{
    public function registration(){
        $kabupaten = DB::table('indonesia_cities')->where('name', 'KABUPATEN BANYUWANGI')->first();
        $kecamatan = DB::table('indonesia_districts')->where('city_code', $kabupaten->code)->get();     
        return view('nelayan.form_registration', compact('kecamatan'));
    }

    public function villages(Request $request){
        $districtCode = $request->input('district_code');
        $villages = DB::table('indonesia_villages')->where('district_code', $districtCode)->get();
        return response()->json($villages);
    }

    public function store(NelayanRegistrationRequest $request){
        $nelayan = Nelayan::createNelayan($request);
        NelayanProfile::tambahProfil($request, $nelayan->id);
        return redirect()->back()->with('status', 'Terima kasih! Permintaan Anda akan segera diproses oleh admin. Harap tunggu 2x 24 jam, Anda akan mendapatkan email notifikasi.');
    }

    public function login(){
        // if (Auth::guard('nelayan')->check()) {
        //     return redirect()->route('nelayan.dashboard');
        // }
        return view('nelayan.login');
    }

    // public function dashboard(){
    //     return view('nelayan.dashboard');
    // }
}
