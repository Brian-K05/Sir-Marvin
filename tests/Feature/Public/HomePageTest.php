<?php

namespace Tests\Feature\Public;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('public.home');
    }

    public function test_home_page_displays_active_services(): void
    {
        Service::factory()->create(['is_active' => true, 'name' => 'Test Service']);
        Service::factory()->create(['is_active' => false, 'name' => 'Inactive Service']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Test Service');
        $response->assertDontSee('Inactive Service');
    }

    public function test_about_page_loads_successfully(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertViewIs('public.about');
    }

    public function test_contact_page_loads_successfully(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertViewIs('public.contact');
    }

    public function test_contact_form_submission_with_valid_data(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test message content',
        ]);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');
    }

    public function test_contact_form_validation_errors(): void
    {
        $response = $this->post('/contact', []);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    public function test_contact_form_email_validation(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'subject' => 'Test Subject',
            'message' => 'Test message',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}

