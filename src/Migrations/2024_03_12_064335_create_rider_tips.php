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
        if (Schema::hasTable('rider_tips'))
            return;

        Schema::create('rider_tips', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('access_token')->unique();
            $table->foreign('courier_id')->references('id')->on('riders')->cascadeOnDelete();
            $table->string('qrcode_id')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rider_tips');
    }
};
