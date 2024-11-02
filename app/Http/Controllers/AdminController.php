<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Nelayan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendNelayanEmail;
use App\Mail\NelayanVerifyAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendResetLinkEmailAdmin;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\PasswordRequest;

class AdminController extends Controller
{
    public function login(){
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }

    public function store(Request $request){
        $check = $request->all();
        if (Auth::guard('admin')->attempt(['email' => $check['email'], 'password' =>  $check['password']])) {
            return redirect()->route('admin.dashboard')->with('success', 'admin login succesfully');
        } else {
            return back()->with('gagal', 'email atau password salah');
        }
    }


    public function dashboard(){
        $dataNelayan = Nelayan::all();
        return view('admin.dashboard', compact('dataNelayan'));
    }

    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login_admin')->with('success', 'admin logout succesfully');
    }
    public function viewdatanelayan(){
        return view('admin.viewdatanelayan');
    }
    public function checkpenjualan(){
        return view('admin.checkpenjualan');
    }
    public function dataseafood(){
        return view('admin.dataseafood');
    }

    public function detailpermintaan($id){
        $nelayan = Nelayan::where('id', $id)-> first();
        return view('admin.detailpermintaan', compact('nelayan'));
    }

    public function tolakakunnelayan(Request $request, $id){
        $nelayan = Nelayan::where('id', $id)-> first();
        $respon = $request->all();
        Mail::to($nelayan->email)->send(new SendNelayanEmail($respon));

        if ($nelayan->detailprofile->foto) {
            Storage::delete('public/fotonelayan/' . $nelayan->detailprofile->foto);
        }

        $nelayan->delete();
        return redirect()->route('admin.dashboard')->with('status', 'Pesan Penolakan Telah dikirimkan');
    }

    public function verifikasinelayan($id){
        $nelayan = Nelayan::where('id', $id)-> first();
        $email = $nelayan->email;
        $token = Str::random(15);
        $Url = url("nelayan/registered/{$email}/{$token}");
        $nelayan->status = 'pending, diverivikasi';
        $nelayan->remember_token =  $token;
        $nelayan->save();
        Mail::to($email)->send(new NelayanVerifyAccount($Url));
        return redirect()->route('admin.dashboard')->with('success', 'Akun berhasil diverifikasi, link aktivasi telah dikirim ke email nelayan.');
    }

    public function adminresetpassword(){
        return view('admin.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $email = Admin::emailadmin($request);
        if (!$email) {
            return redirect()->back()->with('status', 'Email tidak terdaftar');
        }else{
            $token = Str::random(15);
            $resetUrl = url("admin/forgot-password/{$token}");
            Admin::where('email', $email)->update(['remember_token' => $token]);
            Mail::to($email)->send(new sendResetLinkEmailAdmin($resetUrl));
            return redirect()->route('admin.password.request')->with('status', 'Tautan pengaturan ulang kata sandi berhasil dikirim ke email Anda.');
        }
    }

    public function reseturl(Request $request, $email)
    {
        $token =$email;
        $email = Admin::where('remember_token', $token)->first();
        return view('admin.formresetpassword', [
            'request' => $request,
            'token' => $token,
            'email' => $email->email,
        ]);
    }

    public function processResetPassword(PasswordRequest $request,$email,$token)
   {
    $validatedData = $request->validated();
    $admin = Admin::where('email', $token)->first();
    if($admin){
        $admin->remember_token = null;
        $admin->password =  bcrypt($validatedData['password']);
        $admin->save();
        return redirect()->route('login_admin')->with('success', 'silahkan login menggunakan email dan password yang baru');
    }else{
        return redirect()->back()->with('error', 'Gagal');
    }
}
}
