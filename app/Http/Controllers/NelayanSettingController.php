<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NelayanSettingController extends Controller
{
    public function index()
    {
        return view('nelayan.pengaturan.index');
    }

    public function updatenamenelayan(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
        ], [
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Alamat email harus diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);


        $loggedInUser = Auth::guard('nelayan')->user();

        if ($request->input('email') === $loggedInUser->email) {
            // Email yang diberikan cocok dengan email pengguna yang diotentikasi

            DB::table('nelayans')
                ->where('email', $loggedInUser->email)
                ->update([
                    'name' => $request->input('nama'),
                ]);

            return redirect()->route('nelayan.pengaturan')->with('success', 'Nama Berhasil Diperbaharui');
        } else {
            return redirect()->route('nelayan.pengaturan')->with('status', 'Gagal');
        }
    }

    public function newpasswordnelayan(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ], [
            'current_password.required' => 'Kata sandi saat ini harus diisi.',
            'current_password.min' => 'Panjang kata sandi saat ini harus minimal :min karakter.',
            'new_password.required' => 'Kata sandi baru harus diisi.',
            'new_password.min' => 'Panjang kata sandi baru harus minimal :min karakter.',
            'confirm_password.required' => 'Konfirmasi kata sandi baru harus diisi.',
            'confirm_password.same' => 'Konfirmasi kata sandi baru harus sama dengan kata sandi baru.',
        ]);


        $user = Auth::guard('nelayan')->user();
        if (Hash::check($request->input('current_password'), $user->password)) {
            $newPassword = Hash::make($request->input('new_password'));

            DB::table('nelayans')
                ->where('email', $user->email)
                ->update(['password' => $newPassword]);
                Auth::guard('nelayan')->logout();
            return redirect()->route('login_nelayan')->with('success', 'Password Berhasil Diperbaharui login kembali');
        } else {
            return redirect()->route('nelayan.pengaturan')->with('error', 'Password saat ini salah');
        }
    }
}
