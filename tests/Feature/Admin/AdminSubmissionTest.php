<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Service;
use App\Models\Submission;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->admin = Admin::factory()->create();
    }

    public function test_admin_can_view_submissions_index(): void
    {
        Submission::factory()->count(5)->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/submissions');

        $response->assertStatus(200);
        $response->assertViewIs('admin.submissions.index');
    }

    public function test_admin_can_view_submission_details(): void
    {
        $submission = Submission::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/submissions/' . $submission->id);

        $response->assertStatus(200);
        $response->assertViewIs('admin.submissions.show');
        $response->assertViewHas('submission');
    }

    public function test_admin_can_update_submission_status(): void
    {
        $submission = Submission::factory()->create(['status' => 'pending_initial']);

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/admin/submissions/' . $submission->id . '/status', [
                'status' => 'in_progress',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
            'status' => 'in_progress',
        ]);
    }

    public function test_admin_can_approve_initial_payment(): void
    {
        $service = Service::factory()->create();
        $submission = Submission::factory()->create([
            'service_id' => $service->id,
            'status' => 'pending_initial',
            'initial_payment_status' => 'pending',
        ]);
        $payment = Payment::factory()->create([
            'submission_id' => $submission->id,
            'phase' => 'initial',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/admin/submissions/' . $submission->id . '/status', [
                'status' => 'initial_approved',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
            'initial_payment_status' => 'approved',
        ]);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'approved',
        ]);
    }

    public function test_admin_can_upload_corrected_file(): void
    {
        $submission = Submission::factory()->create();
        $file = UploadedFile::fake()->create('corrected.pdf', 1000);

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/admin/submissions/' . $submission->id . '/upload-corrected', [
                'corrected_file' => $file,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
            'status' => 'awaiting_final',
        ]);

        Storage::disk('public')->assertExists($submission->fresh()->corrected_file_path);
    }

    public function test_admin_cannot_update_status_with_invalid_value(): void
    {
        $submission = Submission::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/admin/submissions/' . $submission->id . '/status', [
                'status' => 'invalid_status',
            ]);

        $response->assertSessionHasErrors(['status']);
    }
}

