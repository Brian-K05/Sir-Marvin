<?php

namespace Tests\Feature\Public;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_page_loads_successfully(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertViewIs('public.services');
    }

    public function test_services_page_displays_all_active_services(): void
    {
        $service1 = Service::factory()->create(['is_active' => true, 'name' => 'Service 1']);
        $service2 = Service::factory()->create(['is_active' => true, 'name' => 'Service 2']);
        $service3 = Service::factory()->create(['is_active' => false, 'name' => 'Inactive Service']);

        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('Service 1');
        $response->assertSee('Service 2');
        $response->assertDontSee('Inactive Service');
    }

    public function test_services_page_displays_service_pricing(): void
    {
        $service = Service::factory()->create([
            'is_active' => true,
            'name' => 'Test Service',
            'price' => 5000.00,
            'initial_payment_percentage' => 50,
        ]);

        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('₱5,000.00');
        $response->assertSee('₱2,500.00'); // Initial payment
    }
}

