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
        if (Schema::hasColumn('rider_tips', 'access_code'))
            return;
        Schema::table('rider_tips', function (Blueprint $table) {
            $table->string('access_code')->nullable()->after('access_token')->default(null)->comment(' access code for OTP');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('rider_tips', 'access_code'))
            return;

        Schema::table('rider_tips', function (Blueprint $table) {
            $table->dropColumn('access_code');
        });
    }
};
