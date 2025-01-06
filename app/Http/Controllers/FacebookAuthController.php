<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFacebook()
    {
        try {
            $facebook_user = Socialite::driver('facebook')->user();
            $user = User::where('email', $facebook_user->getEmail())->first();

            if ($user) {
                $user->update([
                    'provider_id' => $facebook_user->getId(),
                    'name_provider' => 'facebook',
                ]);

                Auth::login($user);
                return redirect()->intended('dashboard');

            } else {
                User::create([
                    'name' => $facebook_user->getName(),
                    'email' => $facebook_user->getEmail(),
                    'google_id' => $facebook_user->getId(),
                    'password' => Str::random(8),
                    'provider_id' => $facebook_user->getId(),
                    'name_provider' => 'facebook',
                ]);

                $new_user = User::where('email', $facebook_user->getEmail())->first();

                Auth::login($new_user);
                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $th->getMessage());
        }
    }
}