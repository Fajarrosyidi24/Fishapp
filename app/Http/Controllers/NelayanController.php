<?php

namespace App\Http\Controllers;

use app\models\Seafood;
use App\Models\Nelayan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NelayanProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\PasswordRequest;
use App\Mail\sendResetLinkEmailNelayan;
use App\Http\Requests\NelayanRegistrationRequest;

class NelayanController extends Controller
{
    public function registration()
    {
        $kabupaten = DB::table('indonesia_cities')->where('name', 'KABUPATEN BANYUWANGI')->first();
        if (!$kabupaten) {
            abort(404, 'Kabupaten not found');
        }
        $kecamatan = DB::table('indonesia_districts')->where('city_code', $kabupaten->code)->get();
        if ($kecamatan->isEmpty()) {
            abort(404, 'Kecamatan not found');
        }
        return view('nelayan.form_registration', compact('kecamatan'));
    }

    public function villages(Request $request)
    {
        $districtCode = $request->input('district_code');
        $villages = DB::table('indonesia_villages')->where('district_code', $districtCode)->get();
        return response()->json($villages);
    }

    public function store(NelayanRegistrationRequest $request)
    {
        $nelayan = Nelayan::createNelayan($request);
        NelayanProfile::tambahProfil($request, $nelayan->id);
        return redirect()->back()->with('status', 'Terima kasih! Permintaan Anda akan segera diproses oleh admin. Harap tunggu 2x 24 jam, Anda akan mendapatkan email notifikasi.');
    }

    public function login()
    {
        if (Auth::guard('nelayan')->check()) {
            return redirect()->route('nelayan.dashboard');
        }
        return view('nelayan.login')->with('error', 'harap login terlebih dahulu');
    }

    public function loginpost(Request $request)
    {
        $check = $request->all();
        if (Auth::guard('nelayan')->attempt(['email' => $check['email'], 'password' =>  $check['password']])) {
            return redirect()->route('nelayan.dashboard')->with('success', 'nelayan login succesfully');
        } else {
            return back()->with('gagal', 'email atau password salah');
        }
    }

    public function dashboard()
    {
        return view('nelayan.dashboard');
    }

    public function regnel(Request $request, $token, $email)
    {
        $token = $email;

        $email = DB::table('nelayans')
            ->where('remember_token', $token)
            ->value('email');

        $nelayan = Nelayan::where([
            'email' => $email,
            'remember_token' => $token,
        ])->first();

        if (!$nelayan) {
            abort(404);
        }

        return view('nelayan.formregistered', [
            'request' => $request,
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function processregistrasi(PasswordRequest $request, $email)
    {
        $token = $email;
        $nelayan = Nelayan::where('remember_token', $token)->first();
        $email = $nelayan->email;
        $nelayan = Nelayan::createpassword($request, $email);
        return redirect()->route('login_nelayan')->with('success', 'silahkan login menggunakan email dan password yang baru saja di daftarkan');
    }

    public function NelayanLogout()
    {
        Auth::guard('nelayan')->logout();
        return redirect()->route('login_nelayan')->with('success', 'nelayan logout succesfully');
    }

    public function nelayanresetpassword()
    {
        return view('nelayan.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $email = Nelayan::emailnelayan($request);
        if (!$email) {
            return redirect()->back()->with('status', 'Email tidak terdaftar');
        } else {
            $token = Str::random(15);
            $Url = url("nelayan/forgot-password/{$token}");
            Nelayan::where('email', $email)->update(['remember_token' => $token]);
            Mail::to($email)->send(new sendResetLinkEmailNelayan($Url));
            return redirect()->route('nelayan.password.request')->with('status', 'Tautan pengaturan ulang kata sandi berhasil dikirim ke email Anda.');
        }
    }

    public function reseturl(Request $request, $email)
    {
        $token = $email;
        $email = Nelayan::where('remember_token', $token)->first();
        return view('nelayan.formresetpassword', [
            'request' => $request,
            'token' => $token,
            'email' => $email->email,
        ]);
    }

    public function processResetPassword(PasswordRequest $request, $email, $token)
    {
        $validatedData = $request->validated();
        $nelayan = Nelayan::where('email', $token)->first();
        if ($nelayan) {
            $nelayan->remember_token = null;
            $nelayan->password =  bcrypt($validatedData['password']);
            $nelayan->save();
            return redirect()->route('login_nelayan')->with('success', 'silahkan login menggunakan email dan password yang baru');
        } else {
            return redirect()->back()->with('error', 'Gagal');
        }
    }
}
