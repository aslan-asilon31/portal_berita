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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->unique();
            $table->string('hexa')->nullable();
            $table->string('position')->nullable();
            $table->string('description')->nullable(); // Deskripsi tema (opsional)
            $table->string('path'); // Path atau direktori tema
            $table->boolean('is_active')->default(false); // Status aktif tema
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
