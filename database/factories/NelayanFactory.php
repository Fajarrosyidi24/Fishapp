<?php

namespace Database\Factories;

use App\Models\Nelayan;
use Illuminate\Database\Eloquent\Factories\Factory;

class NelayanFactory extends Factory
{
    protected $model = Nelayan::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            
            // Tambahkan field lain yang diperlukan sesuai kolom di tabel Nelayan
        ];
    }
}
