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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->text('user_id');
            $table->text('category_id');
            $table->text('tag_id');
            $table->text('thumbnail')->nullable();
            $table->text('date')->default('-');
            $table->text('title')->default('-');
            $table->text('slug')->default('-');
            $table->text('price')->default('-');
            $table->text('short_desc')->default('-');
            $table->text('description')->default('-');
            $table->enum('status_publish', ['Published', 'Privated', 'Draft']);
            $table->text('version')->default('1.0.0');
            $table->text('link_demo')->default('-');
            $table->text('link_github')->default('-');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
