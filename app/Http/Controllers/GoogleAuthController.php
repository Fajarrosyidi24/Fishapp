<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle() {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('email', $google_user->getEmail())->first();
    
            if ($user) {
                $user->update([
                    'provider_id' => $google_user->getId(),
                    'name_provider' => 'google',
                ]);
    
                Auth::login($user);
                return redirect()->intended('dashboard');

            } else {
                User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'password' => Str::random(8),
                    'provider_id' => $google_user->getId(),
                    'name_provider' => 'google',
                ]);

                $new_user = User::where('email', $google_user->getEmail())->first();
    
                Auth::login($new_user);
                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $th->getMessage());
        }
     }
}
