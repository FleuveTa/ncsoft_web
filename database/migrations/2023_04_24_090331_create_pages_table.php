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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('heading_vn')->nullable();
            $table->string('heading_en')->nullable();
            $table->string('title_vn')->nullable();
            $table->string('title_en')->nullable();
            $table->string('description_vn')->nullable();
            $table->string('description_en')->nullable();
            $table->string('user_id')->nullable();
            $table->string('button_vn')->nullable();
            $table->string('button_en')->nullable();
            $table->string('image')->nullable();
            $table->integer('page_id');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
