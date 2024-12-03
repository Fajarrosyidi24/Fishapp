<?php

namespace Tests\Feature;

use Tests\TestCase; // Gunakan TestCase dari Laravel
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $this->assertTrue(true);
    }
}
