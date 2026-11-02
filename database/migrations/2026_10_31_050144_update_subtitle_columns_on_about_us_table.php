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
            $table->renameColumn('sub_title', 'sub_title_eng');
        });

        Schema::table('about_us', function (Blueprint $table) {
            $table->string('sub_title_ina')->nullable()->after('sub_title_eng');
        });

        // Set initial Indonesian subtitle for existing records if null
        DB::table('about_us')->whereNull('sub_title_ina')->update([
            'sub_title_ina' => 'Melayani survei dan konsultasi di tempat se-Bali (Denpasar, Badung, Gianyar, Tabanan).',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            $table->dropColumn('sub_title_ina');
        });

        Schema::table('about_us', function (Blueprint $table) {
            $table->renameColumn('sub_title_eng', 'sub_title');
        });
    }
};
