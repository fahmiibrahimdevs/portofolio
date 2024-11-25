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
        Schema::create('article_posts', function (Blueprint $table) {
            $table->id();
            $table->text('user_id');
            $table->text('sub_category_id');
            $table->text('date')->default(date('Y-m-d'));
            $table->text('title');
            $table->text('slug');
            $table->text('description');
            $table->text('fill_content');
            $table->enum('status_publish', ['Published', 'Privated', 'Draft']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_posts');
    }
};
