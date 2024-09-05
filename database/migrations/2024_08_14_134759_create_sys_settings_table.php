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
        Schema::create('sys_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Column for name
            $table->string('image')->nullable(); // Column for image (nullable if not always required)
            $table->string('category'); // Column for category
            $table->text('desc')->nullable(); // Column for description (nullable if not always required)
            $table->text('desc1')->nullable(); // Column for additional description 1 (nullable if not always required)
            $table->text('desc2')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_settings');
    }
};
