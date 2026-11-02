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
            $table->string('cameras')->nullable()->after('price');
            $table->string('recorder_unit')->nullable()->after('cameras');
            $table->string('storage')->nullable()->after('recorder_unit');
            $table->string('power_connectors')->nullable()->after('storage');
            $table->string('cable')->nullable()->after('power_connectors');
            $table->string('service')->nullable()->after('cable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'cameras',
                'recorder_unit',
                'storage',
                'power_connectors',
                'cable',
                'service',
            ]);
        });
    }
};
