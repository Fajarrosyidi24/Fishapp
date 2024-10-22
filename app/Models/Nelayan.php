<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Http\Requests\NelayanRegistrationRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

     public function detailProfile()
    {
        return $this->hasOne(NelayanProfile::class);
    }
}
