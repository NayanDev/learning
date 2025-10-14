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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('nik');
            $table->string('name');
            $table->string('divisi');
            $table->string('unit_kerja');
            $table->string('status');
            $table->string('jk');
            $table->string('email');
            $table->string('telp');
            $table->string('sign_ready')->nullable();
            $table->string('sign_present')->nullable();
            $table->string('time_ready')->nullable();
            $table->string('time_present')->nullable();
            $table->string('token')->nullable();
            $table->string('token_expired')->nullable();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
