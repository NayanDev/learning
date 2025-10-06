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
        Schema::create('training_needs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('approve_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['open', 'submit', 'approve'])->default('open');
            $table->foreignId('workshop_id')->constrained()->onDelete('cascade');
            $table->dateTime('created_date')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('instructor', ['internal', 'external']);
            $table->string('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_needs');
    }
};
