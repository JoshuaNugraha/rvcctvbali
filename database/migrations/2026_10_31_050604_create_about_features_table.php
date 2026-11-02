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
        Schema::create('about_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_us_id')->nullable()->constrained('about_us')->cascadeOnDelete();
            $table->unsignedInteger('sequence')->default(1);
            $table->string('title_eng');
            $table->string('title_ina');
            $table->text('description_eng');
            $table->text('description_ina');
            $table->timestamps();
        });

        $aboutUsId = DB::table('about_us')->value('id');

        // Seed 4 initial feature cards
        DB::table('about_features')->insert([
            [
                'about_us_id' => $aboutUsId,
                'sequence' => 1,
                'title_eng' => '2-Year Official Warranty',
                'title_ina' => 'Garansi Resmi 2 Tahun',
                'description_eng' => '100% original units from authorized Hikvision, Dahua, and Ezviz distributors with hassle-free warranty claims in Bali.',
                'description_ina' => '100% unit original dari distributor resmi Hikvision, Dahua, dan Ezviz dengan klaim garansi mudah di Bali.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'about_us_id' => $aboutUsId,
                'sequence' => 2,
                'title_eng' => 'Villa & Hotel Standard Installation',
                'title_ina' => 'Standar Instalasi Vila & Hotel',
                'description_eng' => "Concealed cable routing with neat protective conduits to preserve your building's architectural aesthetics.",
                'description_ina' => 'Jalur kabel tertutup dengan pipa pelindung rapi untuk menjaga estetika arsitektur bangunan Anda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'about_us_id' => $aboutUsId,
                'sequence' => 3,
                'title_eng' => 'Free Bali Area Survey',
                'title_ina' => 'Gratis Survei Area Bali',
                'description_eng' => 'Optimal lens placement recommendations to ensure every critical angle is covered with zero blind spots.',
                'description_ina' => 'Rekomendasi penempatan sudut kamera terbaik tanpa titik buta (zero blind spot).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'about_us_id' => $aboutUsId,
                'sequence' => 4,
                'title_eng' => 'App Setup & Maintenance Support',
                'title_ina' => 'Panduan Aplikasi & Dukungan Teknisi',
                'description_eng' => 'Guided mobile app configuration until fully active, backed by responsive on-site technician support.',
                'description_ina' => 'Konfigurasi aplikasi HP hingga aktif dan siap pakai, didukung teknisi lokal yang responsif.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_features');
    }
};
