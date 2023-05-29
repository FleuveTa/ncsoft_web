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
        Schema::create('log_news', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('status_pass')->nullable();
            $table->string('status_future')->nullable();
            $table->string('new_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_news');
    }
};
