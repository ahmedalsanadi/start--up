<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->text('description'); // Details about the business idea
            $table->string('location'); // Location of the business
            $table->date('start_date'); // Start date of the project
            $table->date('end_date'); // End date of the project
            $table->decimal('budget', 30, 2); // Precision 30, Scale 2
            $table->foreignId('investor_id')->constrained('users')->onDelete('cascade'); // Investor who created the announcement
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending'); // Approval status by admin
            $table->text('rejection_reason')->nullable(); // Reason for rejection
            $table->boolean('is_closed')->default(false); // when announcement is completed it becomes closed
            $table->date('closed_at')->nullable();
            $table->enum('status', ['in-progress', 'completed', 'deleted_by_investor'])->default('in-progress'); // Corrected default value
            $table->timestamps();
            $table->softDeletes(); // Add deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the soft deletes column (deleted_at)
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Remove deleted_at column
        });

        // Drop the entire table
        Schema::dropIfExists('announcements');
    }
};
