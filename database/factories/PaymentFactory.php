<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'submission_id' => Submission::factory(),
            'phase' => fake()->randomElement(['initial', 'final']),
            'proof_path' => 'proofs/' . fake()->uuid() . '.jpg',
            'reference_number' => fake()->bothify('GCASH########'),
            'amount' => fake()->randomFloat(2, 500, 5000),
            'status' => 'pending',
            'admin_notes' => null,
            'verified_at' => null,
            'verified_by' => null,
        ];
    }

    public function initial(): static
    {
        return $this->state(fn (array $attributes) => [
            'phase' => 'initial',
        ]);
    }

    public function final(): static
    {
        return $this->state(fn (array $attributes) => [
            'phase' => 'final',
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'verified_at' => now(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'verified_at' => now(),
        ]);
    }
}

