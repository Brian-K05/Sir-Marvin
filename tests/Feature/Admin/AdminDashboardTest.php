<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Service;
use App\Models\Submission;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_dashboard_displays_correct_statistics(): void
    {
        $service = Service::factory()->create();
        
        $submissions = Submission::factory()->count(5)->create([
            'service_id' => $service->id,
            'status' => 'pending_initial'
        ]);
        Submission::factory()->count(3)->create([
            'service_id' => $service->id,
            'status' => 'in_progress'
        ]);
        Submission::factory()->count(2)->create([
            'service_id' => $service->id,
            'status' => 'awaiting_final'
        ]);
        // Create payments with existing submissions to avoid creating extra submissions
        foreach ($submissions->take(4) as $submission) {
            Payment::factory()->create([
                'submission_id' => $submission->id,
                'status' => 'pending'
            ]);
        }
        Service::factory()->count(4)->create(); // 4 additional services (1 already created above = 5 total)

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/dashboard');

        $response->assertStatus(200);
        $stats = $response->viewData('stats');
        $this->assertEquals(10, $stats['total_submissions']);
        $this->assertEquals(5, $stats['pending_initial']);
        $this->assertEquals(3, $stats['in_progress']);
        $this->assertEquals(2, $stats['awaiting_final']);
        $this->assertEquals(4, $stats['pending_payments']);
        $this->assertEquals(5, $stats['total_services']);
    }

    public function test_dashboard_displays_recent_submissions(): void
    {
        Submission::factory()->count(15)->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('recent_submissions', function ($submissions) {
            return $submissions->count() === 10;
        });
    }

    public function test_dashboard_displays_pending_payments(): void
    {
        Payment::factory()->count(12)->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('pending_payments', function ($payments) {
            return $payments->count() === 10;
        });
    }
}

