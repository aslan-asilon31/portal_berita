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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('news_code'); // Using 'news_code' as the column name
            $table->integer('type_news_id'); 
            $table->integer('cat_post_id'); 
            $table->string('name');
            $table->string('status');
            $table->string('file');
            $table->string('category');
            $table->timestamp('start_date');
            $table->timestamp('start_date');
            $table->string('video');
            $table->string('name2')->nullable(); // Make columns nullable if they are optional
            $table->string('name3')->nullable();
            $table->string('name4')->nullable();
            $table->string('name5')->nullable();
            $table->string('image')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->string('image5')->nullable();
            $table->string('event')->nullable();
            $table->string('location')->nullable();
            $table->text('desc')->nullable();
            $table->text('desc2')->nullable();
            $table->text('desc3')->nullable();
            $table->text('desc4')->nullable();
            $table->text('desc5')->nullable();
            $table->string('page')->nullable();
            $table->string('slug')->unique(); // Assuming 'slug' should be unique
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
