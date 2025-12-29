<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Service;
use App\Models\Submission;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    public function test_admin_can_view_payments_index(): void
    {
        Payment::factory()->count(5)->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/payments');

        $response->assertStatus(200);
        $response->assertViewIs('admin.payments.index');
    }

    public function test_admin_can_view_payment_details(): void
    {
        $payment = Payment::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/payments/' . $payment->id);

        $response->assertStatus(200);
        $response->assertViewIs('admin.payments.show');
        $response->assertViewHas('payment');
    }

    public function test_admin_can_approve_initial_payment(): void
    {
        $service = Service::factory()->create();
        $submission = Submission::factory()->create([
            'service_id' => $service->id,
            'initial_payment_status' => 'pending',
        ]);
        $payment = Payment::factory()->create([
            'submission_id' => $submission->id,
            'phase' => 'initial',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/admin/payments/' . $payment->id . '/approve');

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'approved',
            'verified_by' => $this->admin->id,
        ]);

        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
            'initial_payment_status' => 'approved',
            'status' => 'initial_approved',
        ]);
    }

    public function test_admin_can_approve_final_payment(): void
    {
        $service = Service::factory()->create();
        $submission = Submission::factory()->create([
            'service_id' => $service->id,
            'final_payment_status' => 'pending',
        ]);
        $payment = Payment::factory()->create([
            'submission_id' => $submission->id,
            'phase' => 'final',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/admin/payments/' . $payment->id . '/approve');

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'approved',
        ]);

        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
            'final_payment_status' => 'approved',
            'status' => 'final_approved',
        ]);
    }

    public function test_admin_can_reject_payment(): void
    {
        $service = Service::factory()->create();
        $submission = Submission::factory()->create([
            'service_id' => $service->id,
            'initial_payment_status' => 'pending',
        ]);
        $payment = Payment::factory()->create([
            'submission_id' => $submission->id,
            'phase' => 'initial',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/admin/payments/' . $payment->id . '/reject', [
                'admin_notes' => 'Payment proof unclear',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'rejected',
            'admin_notes' => 'Payment proof unclear',
        ]);

        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
            'initial_payment_status' => 'rejected',
        ]);
    }

    public function test_admin_can_reject_payment_without_notes(): void
    {
        $payment = Payment::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/admin/payments/' . $payment->id . '/reject', []);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'rejected',
        ]);
    }
}

