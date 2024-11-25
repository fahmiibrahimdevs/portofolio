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
        Schema::create('article_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->text('category_id');
            $table->text('sub_category_name');
            $table->text('description')->default('-');
            $table->text('image')->default('-');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_sub_categories');
    }
};
