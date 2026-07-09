<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference_id')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('country');
            $table->string('employment_status');
            $table->decimal('monthly_income', 12, 2);
            $table->string('employer_name')->nullable();
            $table->decimal('loan_amount', 12, 2);
            $table->integer('loan_duration');
            $table->text('loan_purpose');
            $table->string('identity_status')->default('unverified');
            $table->string('loan_status')->default('pending');
            $table->string('current_step')->default('application_received');
            $table->json('ocr_results')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->index('email');
            $table->index('loan_status');
            $table->index('identity_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
