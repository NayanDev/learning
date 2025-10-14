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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('company')->nullable();
            $table->string('nama')->nullable();
            $table->string('divisi')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('status')->nullable();
            $table->string('jk')->nullable();
            $table->string('email')->nullable();
            $table->string('telp')->nullable();
            $table->timestamp('last_synced')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
