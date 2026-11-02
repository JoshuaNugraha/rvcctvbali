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
        Schema::table('past_projects', function (Blueprint $table) {
            $table->renameColumn('description', 'description_eng');
        });

        Schema::table('past_projects', function (Blueprint $table) {
            $table->text('description_ina')->nullable()->after('description_eng');
        });

        Schema::table('about_us', function (Blueprint $table) {
            $table->renameColumn('descriptions', 'description_eng');
        });

        Schema::table('about_us', function (Blueprint $table) {
            $table->text('description_ina')->nullable()->after('description_eng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('past_projects', function (Blueprint $table) {
            $table->dropColumn('description_ina');
        });

        Schema::table('past_projects', function (Blueprint $table) {
            $table->renameColumn('description_eng', 'description');
        });

        Schema::table('about_us', function (Blueprint $table) {
            $table->dropColumn('description_ina');
        });

        Schema::table('about_us', function (Blueprint $table) {
            $table->renameColumn('description_eng', 'descriptions');
        });
    }
};
