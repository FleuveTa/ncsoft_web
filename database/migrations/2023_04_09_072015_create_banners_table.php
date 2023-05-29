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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title_vn');
            $table->string('title_en');
            $table->string('description_vn');
            $table->string('description_en');
            $table->string('button_name_vn');
            $table->string('button_name_en');
            $table->string('image');
            $table->integer('user_id');
            $table->integer('order');
            $table->integer('status');
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
