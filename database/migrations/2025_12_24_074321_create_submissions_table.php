<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('client_name');
            $table->string('client_email');
            $table->string('document_path');
            $table->date('deadline');
            $table->enum('status', [
                'pending_initial',
                'initial_approved',
                'in_progress',
                'awaiting_final',
                'final_approved',
                'completed',
                'cancelled'
            ])->default('pending_initial');
            $table->enum('initial_payment_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('final_payment_status', ['pending', 'approved', 'rejected'])->nullable();
            $table->string('corrected_file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
