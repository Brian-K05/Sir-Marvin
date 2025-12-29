<?php

namespace Database\Factories;

use App\Models\Submission;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'client_name' => fake()->name(),
            'client_email' => fake()->safeEmail(),
            'document_path' => 'documents/' . fake()->uuid() . '.pdf',
            'deadline' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'status' => 'pending_initial',
            'initial_payment_status' => 'pending',
            'final_payment_status' => 'pending',
            'corrected_file_path' => null,
        ];
    }

    public function pendingInitial(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending_initial',
            'initial_payment_status' => 'pending',
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
            'initial_payment_status' => 'approved',
        ]);
    }

    public function awaitingFinal(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'awaiting_final',
            'initial_payment_status' => 'approved',
            'final_payment_status' => 'pending',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'initial_payment_status' => 'approved',
            'final_payment_status' => 'approved',
            'corrected_file_path' => 'corrected/' . fake()->uuid() . '.pdf',
        ]);
    }
}

