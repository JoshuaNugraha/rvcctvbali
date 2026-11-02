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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->integer('sequence')->default(0);
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('channel_id')->nullable()->constrained('channels')->nullOnDelete();
            $table->json('brands')->nullable();
            $table->double('price', 15, 2)->default(0);
            $table->text('descriptions')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
