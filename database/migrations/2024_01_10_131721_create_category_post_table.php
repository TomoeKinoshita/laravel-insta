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
        Schema::create('category_post', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();

            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('post_id')->reference('id')->on('posts')->onDelete('cascade');
                // if related post is deleted, all category_post (with the related post) is also deleted.
            $table->foreign('category_id')->reference('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_post');
    }
};
