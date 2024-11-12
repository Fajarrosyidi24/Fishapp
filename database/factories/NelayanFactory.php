<?php

namespace Database\Factories;

use App\Models\Nelayan;
use App\Models\NelayanProfile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nelayan>
 */
class NelayanFactory extends Factory
{
    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nelayan = Nelayan::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(15),
        ]);

        $profile = NelayanProfile::create([
        
        ]);

        return [
        $nelayan,
        $profile,
        ];
    }
}
