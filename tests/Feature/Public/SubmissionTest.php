<?php

namespace Tests\Feature\Public;

use App\Models\Service;
use App\Models\Submission;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_submission_create_page_loads_successfully(): void
    {
        $response = $this->get('/submissions/create');

        $response->assertStatus(200);
        $response->assertViewIs('public.submission.create');
    }

    public function test_submission_create_page_with_pre_selected_service(): void
    {
        $service = Service::factory()->create(['is_active' => true]);

        $response = $this->get('/submissions/create?service=' . $service->id);

        $response->assertStatus(200);
        $response->assertViewHas('service', $service);
    }

    public function test_submission_can_be_created_with_valid_data(): void
    {
        $service = Service::factory()->create([
            'price' => 5000.00,
            'initial_payment_percentage' => 50,
        ]);

        $document = UploadedFile::fake()->create('document.pdf', 1000);
        $proof = UploadedFile::fake()->create('proof.pdf', 100);

        $response = $this->post('/submissions', [
            'service_id' => $service->id,
            'client_name' => 'John Doe',
            'client_email' => 'john@example.com',
            'document' => $document,
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'initial_payment_proof' => $proof,
            'initial_payment_reference' => 'GCASH123456',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('submissions', [
            'client_name' => 'John Doe',
            'client_email' => 'john@example.com',
            'status' => 'pending_initial',
        ]);

        $this->assertDatabaseHas('payments', [
            'phase' => 'initial',
            'reference_number' => 'GCASH123456',
            'amount' => 2500.00,
            'status' => 'pending',
        ]);
    }

    public function test_submission_validation_requires_all_fields(): void
    {
        $response = $this->post('/submissions', []);

        $response->assertSessionHasErrors([
            'service_id',
            'client_name',
            'client_email',
            'document',
            'deadline',
            'initial_payment_proof',
            'initial_payment_reference',
        ]);
    }

    public function test_submission_validation_requires_valid_email(): void
    {
        $service = Service::factory()->create();

        $response = $this->post('/submissions', [
            'service_id' => $service->id,
            'client_name' => 'John Doe',
            'client_email' => 'invalid-email',
            'document' => UploadedFile::fake()->create('document.pdf'),
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'initial_payment_proof' => UploadedFile::fake()->create('proof.pdf', 100),
            'initial_payment_reference' => 'GCASH123',
        ]);

        $response->assertSessionHasErrors(['client_email']);
    }

    public function test_submission_validation_requires_future_deadline(): void
    {
        $service = Service::factory()->create();

        $response = $this->post('/submissions', [
            'service_id' => $service->id,
            'client_name' => 'John Doe',
            'client_email' => 'john@example.com',
            'document' => UploadedFile::fake()->create('document.pdf'),
            'deadline' => now()->subDays(1)->format('Y-m-d'),
            'initial_payment_proof' => UploadedFile::fake()->create('proof.pdf', 100),
            'initial_payment_reference' => 'GCASH123',
        ]);

        $response->assertSessionHasErrors(['deadline']);
    }

    public function test_submission_show_page_loads_successfully(): void
    {
        $service = Service::factory()->create();
        $submission = Submission::factory()->create(['service_id' => $service->id]);

        $response = $this->get('/submissions/' . $submission->id);

        $response->assertStatus(200);
        $response->assertViewIs('public.submission.show');
        $response->assertViewHas('submission');
    }

    public function test_final_payment_can_be_uploaded_when_status_is_awaiting_final(): void
    {
        $service = Service::factory()->create(['price' => 5000.00, 'initial_payment_percentage' => 50]);
        $submission = Submission::factory()->create([
            'service_id' => $service->id,
            'status' => 'awaiting_final',
        ]);

        $proof = UploadedFile::fake()->create('final_proof.pdf', 100);

        $response = $this->post('/submissions/' . $submission->id . '/final-payment', [
            'final_payment_proof' => $proof,
            'final_payment_reference' => 'GCASH789012',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('payments', [
            'submission_id' => $submission->id,
            'phase' => 'final',
            'reference_number' => 'GCASH789012',
            'status' => 'pending',
        ]);
    }

    public function test_final_payment_cannot_be_uploaded_when_status_is_not_awaiting_final(): void
    {
        $service = Service::factory()->create();
        $submission = Submission::factory()->create([
            'service_id' => $service->id,
            'status' => 'pending_initial',
        ]);

        $proof = UploadedFile::fake()->create('final_proof.pdf', 100);

        $response = $this->post('/submissions/' . $submission->id . '/final-payment', [
            'final_payment_proof' => $proof,
            'final_payment_reference' => 'GCASH789012',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_corrected_file_can_be_downloaded_when_completed_and_final_payment_approved(): void
    {
        Storage::disk('public')->put('corrected/test.pdf', 'test content');

        $service = Service::factory()->create();
        $submission = Submission::factory()->create([
            'service_id' => $service->id,
            'status' => 'completed',
            'final_payment_status' => 'approved',
            'corrected_file_path' => 'corrected/test.pdf',
        ]);

        $response = $this->get('/submissions/' . $submission->id . '/download');

        $response->assertDownload();
    }

    public function test_corrected_file_cannot_be_downloaded_when_not_completed(): void
    {
        $service = Service::factory()->create();
        $submission = Submission::factory()->create([
            'service_id' => $service->id,
            'status' => 'in_progress',
            'corrected_file_path' => null,
        ]);

        $response = $this->get('/submissions/' . $submission->id . '/download');

        $response->assertStatus(404);
    }

    public function test_corrected_file_cannot_be_downloaded_when_final_payment_not_approved(): void
    {
        Storage::disk('public')->put('corrected/test.pdf', 'test content');

        $service = Service::factory()->create();
        $submission = Submission::factory()->create([
            'service_id' => $service->id,
            'status' => 'completed',
            'final_payment_status' => 'pending',
            'corrected_file_path' => 'corrected/test.pdf',
        ]);

        $response = $this->get('/submissions/' . $submission->id . '/download');

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}

