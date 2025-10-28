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
        Schema::create('training_new_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_employee_id')->nullable()->constrained('training_new_employees');
            $table->enum('type', ['pre_test', 'post_test']);
            $table->string('name');
            $table->string('email');
            $table->string('position');
            $table->decimal('score', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_new_participants');
    }
};
