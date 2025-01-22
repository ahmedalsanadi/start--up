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
            $table->decimal('budget', 15, 2); // Precision 15, Scale 2
            $table->foreignId('investor_id')->constrained('users')->onDelete('cascade'); // Investor who created the announcement
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending'); // Approval status by admin
            $table->text('rejection_reason')->nullable(); // Reason for rejection
            $table->boolean('is_closed')->default(false);
            // Status of the announcement , the investor can switch this into inactive when he got an idea
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
