<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Http\Requests\NelayanRegistrationRequest;
use App\Http\Requests\PasswordRequest;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mockery\Generator\StringManipulation\Pass\Pass;

class Nelayan extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard ='nelayan';
     protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */  


     public static function createNelayan(NelayanRegistrationRequest $request)
     {
        $validatedData = $request->validated();

        return self::create([
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'status' => 'pending',
        ]);

     }

     public static function createpassword(PasswordRequest $request, $email)
     {
        $validatedData = $request->validated();
        $nelayan = Nelayan::where('email', $email)->first();
        if ($nelayan) {
            $nelayan->update([
                'password' => bcrypt($validatedData['password']),
                'remember_token' => null,
                'status' => 'terdaftar',
            ]);
    
            return $nelayan; // Kembalikan nelayan yang telah diperbarui
        }
    
        return null;
     }

     public function detailProfile()
    {
        return $this->hasOne(NelayanProfile::class);
    }

    public static function emailnelayan($request)
{
    $request->validate([
        'email' => 'required|email',
    ], [
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
    ]);

    $email = $request->input('email');
    $exists = self::where('email', $email)->exists();
    return $exists ? $email : false;
}
}
