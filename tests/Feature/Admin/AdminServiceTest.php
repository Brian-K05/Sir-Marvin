<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    public function test_admin_can_view_services_index(): void
    {
        Service::factory()->count(5)->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/services');

        $response->assertStatus(200);
        $response->assertViewIs('admin.services.index');
    }

    public function test_admin_can_create_service(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/services/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.services.create');
    }

    public function test_admin_can_store_new_service(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post('/admin/services', [
                'name' => 'New Service',
                'description' => 'Service description',
                'price' => 5000.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ]);

        $response->assertRedirect('/admin/services');
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('services', [
            'name' => 'New Service',
            'price' => 5000.00,
            'initial_payment_percentage' => 50,
            'is_active' => true,
        ]);
    }

    public function test_admin_can_edit_service(): void
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/services/' . $service->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.services.edit');
        $response->assertViewHas('service');
    }

    public function test_admin_can_update_service(): void
    {
        $service = Service::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($this->admin, 'admin')
            ->put('/admin/services/' . $service->id, [
                'name' => 'Updated Name',
                'description' => $service->description,
                'price' => $service->price,
                'initial_payment_percentage' => $service->initial_payment_percentage,
                'is_active' => $service->is_active,
            ]);

        $response->assertRedirect('/admin/services');
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_admin_can_delete_service(): void
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->delete('/admin/services/' . $service->id);

        $response->assertRedirect('/admin/services');

        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    }

    public function test_service_validation_requires_all_fields(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post('/admin/services', []);

        $response->assertSessionHasErrors([
            'name',
            'description',
            'price',
            'initial_payment_percentage',
        ]);
    }
}

