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
        if (Schema::hasColumn('rider_tips', 'saved_card'))
            return;

        Schema::table('rider_tips', function (Blueprint $table) {
            $table->boolean('saved_card')->after('qrcode_id')->nullable(false)->default(false)->comment('Флаг привязки карты курьера');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('rider_tips', 'saved_card'))
            return;

        Schema::table('rider_tips', function (Blueprint $table) {
            $table->dropColumn('saved_card');
        });
    }
};
