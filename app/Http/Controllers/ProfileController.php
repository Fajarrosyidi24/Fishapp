<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Requests\FotoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\NelayanRegistrationRequest;
use App\Http\Requests\UserProfileRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $kabupaten = DB::table('indonesia_cities')->where('name', 'KABUPATEN BANYUWANGI')->first();
        $kecamatan = DB::table('indonesia_districts')->where('city_code', $kabupaten->code)->get();     
        return view('profile.edit', [
            'user' => $request->user(),
            'kecamatan' => $kecamatan,
            'kabupaten' => $kabupaten,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UserProfileRequest $request)
    {
        $updateprofile = UserProfile::updateprofileuser($request);
        if ($updateprofile) {
            return Redirect::route('profile.edit')->with('success', 'profile-updated');
        }else{
            return Redirect::route('profile.edit')->with('error', 'Gagal Harap Coba Lagi');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function updatefoto(FotoRequest $request){
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();

        if (!$profile) {
            UserProfile::tambahpotoProfil($request, $user);
            return redirect()->back()->with('success', 'foto profile berhasil diperbarui');
        }else{
            UserProfile::updatepotoProfil($request, $user);
            return redirect()->back()->with('success', 'foto profile berhasil diperbarui');   
        }
    }

}
