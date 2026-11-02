<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            $table->string('headline_eng')->nullable()->after('sub_title');
            $table->string('headline_ina')->nullable()->after('headline_eng');
        });

        // Populate initial default headline for existing records
        DB::table('about_us')->update([
            'headline_eng' => 'Complete Security Solutions in Bali from Consultation to After-Sales Support.',
            'headline_ina' => 'Solusi Keamanan CCTV Terlengkap di Bali dari Konsultasi hingga Garansi Purnajual.',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            $table->dropColumn(['headline_eng', 'headline_ina']);
        });
    }
};
