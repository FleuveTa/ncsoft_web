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
        Schema::create('recruitments', function (Blueprint $table) {
            $table->id();
            $table->string('heading_vn');
            $table->string('heading_en');
            $table->string('slug');
            $table->text('description_vn');
            $table->text('description_en');
            $table->integer('number_of_people');
            $table->string('salary', 50);
            $table->integer('user_id');
            $table->date('timeout');
            $table->date('time_display');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitments');
    }
};
