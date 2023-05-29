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
            $table->string('heading_vn');
            $table->string('heading_en');
            $table->string('slug');
            $table->string('title_vn');
            $table->string('title_en');
            $table->text('description_vn');
            $table->text('description_en');
            $table->string('image');
            $table->integer('user_id');
            $table->date('time_display');
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
