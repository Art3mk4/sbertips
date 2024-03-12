<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTest extends TestCase
{

    /**
     * @return void
     */
    public function test_sbertips_route(): void
    {
        $response = $this->get('/sbertips');
        $response->assertStatus(200);
    }
}
