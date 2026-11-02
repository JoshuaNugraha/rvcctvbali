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
        Schema::table('packages', function (Blueprint $table) {
            $table->renameColumn('descriptions', 'description_eng');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->text('description_ina')->nullable()->after('description_eng');
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->renameColumn('descriptions', 'description_eng');
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->text('description_ina')->nullable()->after('description_eng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('description_ina');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->renameColumn('description_eng', 'descriptions');
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn('description_ina');
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->renameColumn('description_eng', 'descriptions');
        });
    }
};
