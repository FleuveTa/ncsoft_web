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
        Schema::create('log_recruitments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('status_pass');
            $table->string('status_future');
            $table->integer('recruitment_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_recruitments');
    }
};
