<?php

namespace Tests\Feature;

use App\Product;
use App\Productivity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_status_200_on_dashboard_api_endpoint()
    {
        $response = $this->getJson('/api/dashboard');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'metrics',
            'availableLines'
        ]);
    }

    public function test_filters_production_line_correctly_using_linha_id()
    {
        $tv = factory(Product::class)->create(['name' => 'TV']);
        $geladeira = factory(Product::class)->create(['name' => 'Geladeira']);

        factory(Productivity::class)->create([
            'product_id' => $tv->id,
            'produced_quantity' => 100,
            'defects_quantity' => 5,
            'production_date' => '2026-01-10',
        ]);

        factory(Productivity::class)->create([
            'product_id' => $geladeira->id,
            'produced_quantity' => 50,
            'defects_quantity' => 10,
            'production_date' => '2026-01-10',
        ]);

        $response = $this->getJson("/api/dashboard?linha_id={$tv->id}");

        $response->assertStatus(200);
        $data = $response->json('metrics');

        $this->assertCount(1, $data);
        $this->assertEquals($tv->id, $data[0]['product_id']);
        $this->assertEquals('TV', $data[0]['product_name']);
    }

    public function test_calculates_efficiency_correctly_based_on_formula()
    {
        $tv = factory(Product::class)->create(['name' => 'TV']);

        factory(Productivity::class)->create([
            'product_id' => $tv->id,
            'produced_quantity' => 200,
            'defects_quantity' => 10,
            'production_date' => '2026-01-15',
        ]);

        $response = $this->getJson('/api/dashboard');

        $response->assertStatus(200);
        $data = $response->json('metrics');

        $this->assertEquals(95.0, $data[0]['efficiency']);
    }
}
