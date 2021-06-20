<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ErrorHandlingTest extends TestCase
{

    public function test_page_non_int()
    {
        $response = $this->get('/characters?page=abcdef');

        $response->assertStatus(400);
    }

    public function test_page_too_small()
    {
        $response = $this->get('/characters?page=-5');

        $response->assertStatus(400);
    }

    public function test_page_too_big()
    {
        $response = $this->get('/characters?page=10000');

        $response->assertStatus(200);
    }

    public function test_page_valid()
    {
        $response = $this->get('/characters?page=3');

        $response->assertStatus(200);
    }

    public function test_status_invalid()
    {
        $response = $this->get('/characters?status=abc');

        $response->assertStatus(400);
    }

    public function test_gender_invalid()
    {
        $response = $this->get('/characters?gender=abc');

        $response->assertStatus(400);
    }

    public function test_search_valid()
    {
        $response = $this->get('/characters?name=rick&species=human&status=alive&gender=male');

        $response->assertStatus(200);
    }

    public function test_rate_limiting()
    {
        Http::fake([
            'rickandmortyapi.com/*' => Http::response(['error' => 'Rate limit exceeded.'], 429),
        ]);

        $response = $this->get('/characters');

        $response->assertStatus(429);
    }

}
