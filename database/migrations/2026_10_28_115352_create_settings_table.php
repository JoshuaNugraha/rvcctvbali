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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->json('content')->nullable();
            $table->timestamps();
        });

        // Seed default child settings: address, phone number, social media
        DB::table('settings')->insert([
            [
                'name' => 'address',
                'content' => json_encode([
                    'street' => 'Jl. By Pass Ngurah Rai No. 128',
                    'city' => 'Denpasar Selatan',
                    'province' => 'Bali',
                    'postal_code' => '80222',
                    'country' => 'Indonesia',
                    'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3943.872887701061!2d115.20237399999998!3d-8.7036194!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2410150ed09ef%3A0x6d66419d5b314f56!2sRV%20CCTV%20TECHNOLOGY!5e0!3m2!1sid!2sid!4v1793423332997!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'phone_number',
                'content' => json_encode([
                    'phone_number' => '+62 878-5513-0070',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'social_media',
                'content' => json_encode([
                    'instagram' => 'https://instagram.com/rvcctvbali',
                    'facebook' => 'https://facebook.com/rvcctvbali',
                    'youtube' => 'https://youtube.com/@rvcctvbali',
                    'tiktok' => 'https://tiktok.com/@rvcctvbali',
                ]),
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
        Schema::dropIfExists('settings');
    }
};
