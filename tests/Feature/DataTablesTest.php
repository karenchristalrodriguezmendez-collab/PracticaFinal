<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class DataTablesTest extends TestCase
{
    public function test_datatables_ajax_returns_json()
    {
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        $response = $this->actingAs($user)->getJson('/products/data?draw=1&start=0&length=10');

        $response->dump();
        $response->assertStatus(200);
    }
}
