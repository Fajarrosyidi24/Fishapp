<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_masuk_tanpa_login()
    {
        $response = $this->get(route('create.seafood'));
        $response ->assertStatus(302);
    }

    // public function penjualanikan()  {
    //     $penjual= penjualanikan::factory()->create();
    //     $response = this
    // }
}
