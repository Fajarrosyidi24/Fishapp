<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Nelayan;
use App\Models\Seafood;
use App\Models\BarangSewa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendNelayanEmail;
use App\Mail\SeafoodVerification;
use App\Mail\NelayanVerifyAccount;
use Illuminate\Support\Facades\DB;
use App\Mail\BarangSewaVerification;
use App\Mail\SendSeafoodDeleteEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendResetLinkEmailAdmin;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

class AdminController extends Controller
{
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }

    public function store(Request $request)
    {
        $check = $request->all();
        if (Auth::guard('admin')->attempt(['email' => $check['email'], 'password' =>  $check['password']])) {
            return redirect()->route('admin.dashboard')->with('success', 'admin login succesfully');
        } else {
            return back()->with('gagal', 'email atau password salah');
        }
    }

    public function dashboard()
    {
        $dataNelayan2 = Nelayan::all();
        return view('admin.dashboard', compact('dataNelayan2'));
    }

    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login_admin')->with('success', 'admin logout succesfully');
    }

    public function viewdatanelayan()
    {
        $dataNelayan = Nelayan::where('status', 'terdaftar')->get();
        // dd($dataNelayan);
        return view('admin.viewdatanelayan', compact('dataNelayan'));
    }

    public function permintaannelayanakun()
    {
        $dataNelayan = Nelayan::where('status', 'pending')->get();
        return view('admin.permintaanakunnelayanpendaftaran', compact('dataNelayan'));
    }

    public function checkpenjualan()
    {
        $seafood = Seafood::where('status', 'menunggu di verifikasi admin')->get();
        return view('admin.checkpenjualan', compact('seafood'));
    }
    
    public function dataseafood()
    {
        $seafood = Seafood::where('status', 'siap dijual')->get();
        return view('admin.dataseafood', compact('seafood'));
    }

    public function detailpermintaan($id)
    {
        $nelayan = Nelayan::where('id', $id)->first();
        if(!$nelayan){
            abort(404, 'Nelayan not found');
        }
        return view('admin.detailpermintaan', compact('nelayan'));
    }

    public function tolakakunnelayan(Request $request, $id)
    {
        $nelayan = Nelayan::where('id', $id)->first();
        if (!$nelayan) {
            abort(404, 'Nelayan not found');
        }
        $respon = $request->all();
        Mail::to($nelayan->email)->send(new SendNelayanEmail($respon));

        if ($nelayan->detailprofile->foto) {
            Storage::delete('public/fotonelayan/' . $nelayan->detailprofile->foto);
        }

        $nelayan->delete();
        return redirect()->route('admin.dashboard')->with('status', 'Pesan Penolakan Telah dikirimkan');
    }

    public function verifikasinelayan($id)
    {
        $nelayan = Nelayan::where('id', $id)->first();
        if(!$nelayan){
            abort(404, 'Nelayan not found');
        }
        $email = $nelayan->email;
        $token = Str::random(15);
        $Url = url("nelayan/registered/{$email}/{$token}");
        $nelayan->status = 'pending, diverivikasi';
        $nelayan->remember_token =  $token;
        $nelayan->save();
        Mail::to($email)->send(new NelayanVerifyAccount($Url));
        return redirect()->route('admin.dashboard')->with('success', 'Akun berhasil diverifikasi, link aktivasi telah dikirim ke email nelayan.');
    }

    public function adminresetpassword()
    {
        return view('admin.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $email = Admin::emailadmin($request);
        if (!$email) {
            return redirect()->back()->with('status', 'Email tidak terdaftar');
        } else {
            $token = Str::random(15);
            $resetUrl = url("admin/forgot-password/{$token}");
            Admin::where('email', $email)->update(['remember_token' => $token]);
            Mail::to($email)->send(new sendResetLinkEmailAdmin($resetUrl));
            return redirect()->route('admin.password.request')->with('status', 'Tautan pengaturan ulang kata sandi berhasil dikirim ke email Anda.');
        }
    }

    public function reseturl(Request $request, $email)
    {
        $token = $email;
        $email = Admin::where('remember_token', $token)->first();
        return view('admin.formresetpassword', [
            'request' => $request,
            'token' => $token,
            'email' => $email->email,
        ]);
    }

    public function processResetPassword(PasswordRequest $request, $email, $token)
    {
        $validatedData = $request->validated();
        $admin = Admin::where('email', $token)->first();
        if ($admin) {
            $admin->remember_token = null;
            $admin->password =  bcrypt($validatedData['password']);
            $admin->save();
            return redirect()->route('login_admin')->with('success', 'silahkan login menggunakan email dan password yang baru');
        } else {
            return redirect()->back()->with('error', 'Gagal');
        }
    }

    public function verifikasiseafood($id)
    {
        $seafood = Seafood::where('kode_seafood', $id)->first();
        $email = $seafood->nelayan->email;
        $Url = 'Selamat Seafood yan anda ajukan denngan nama ' . $seafood->nama . ' Telah memenuhi persyaratan dan berhasil diverifikasi untuk dijual';
        Mail::to($email)->send(new SeafoodVerification($Url));
        $seafood->status = 'siap dijual';
        $seafood->save();
        return redirect()->back()->with('success', 'seafood telah diverifikasi');
    }

    public function verifikasibarang($id)
    {
        $barang = BarangSewa::where('kode_barang', $id)->first();
        $email = $barang->nelayan->email;
        $Url = 'Selamat Barang yan anda ajukan dengan nama ' . $barang->nama_barang . ' Telah memenuhi persyaratan dan berhasil diverifikasi untuk dijual';
        Mail::to($email)->send(new BarangSewaVerification($Url));
        $barang->status = 'siap dijual';
        $barang->save();
        return redirect()->back()->with('success', 'seafood telah diverifikasi');
    }

    public function detailpermintaanseafood($id)
    {
        $seafood = Seafood::where('kode_seafood', $id)->first();
        return view('admin.detailseafood', compact('seafood'));
    }

    public function tolakseafood(Request $request, $id)
    {
        $seafood = Seafood::where('kode_seafood', $id)->first();
        $respon = $request->all();
        $email = $seafood->nelayan->email;
        Mail::to($email)->send(new SendSeafoodDeleteEmail($respon));
        $seafood->delete();
        return redirect()->back()->with('success', 'Pesan Penolakan Telah dikirimkan');
    }

    public function tolakbarang(Request $request, $id)
    {
        $barang = BarangSewa::where('kode_barang', $id)->first();
        $respon = $request->all();
        $email = $barang->nelayan->email;
        Mail::to($email)->send(new SendSeafoodDeleteEmail($respon));
        $barang->delete();
        return redirect()->back()->with('success', 'Pesan Penolakan Telah dikirimkan');
    }

    public function permintaanbarangsewa(){
        $barang = BarangSewa::where('status', 'menunggu di verifikasi admin')->get();
        return view('admin.data-permintaan-barangsewa', compact('barang'));
    }

    public function detailpermintaanbarang($id){
        $barang = BarangSewa::where('kode_barang', $id)->first();
        return view('admin.detailpermintaanbarang', compact('barang'));
    }

    public function viewPembeli(){
        $data = User::all();
        return view('admin.viewdatapembeli', compact('data'));
    }
    //njajal
}
