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
        Schema::create('training_details', function (Blueprint $table) {
            $table->id();
            // Foreign Keys
            $table->foreignId('department_id')
                ->constrained('departments')
                ->onDelete('cascade');

            $table->foreignId('training_analyst_id')
                ->constrained('training_analysis')
                ->onDelete('cascade');

            $table->foreignId('training_needs_id')
                ->constrained('training_needs')
                ->onDelete('cascade');

            $table->foreignId('training_unplan_id')
                ->constrained('training_unplanes')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_details');
    }
};
