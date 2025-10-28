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
        Schema::create('employee_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained(); // event_id nullable
            $table->foreignId('test_employee_id')->nullable()->constrained('training_new_employees'); 
            $table->enum('type', ['pre_test', 'post_test']); // type: pre_test atau post_test
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_tests');
    }
};
