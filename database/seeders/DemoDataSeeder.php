<?php

namespace Database\Seeders;

use App\Models\AboutFeature;
use App\Models\AboutUs;
use App\Models\Brand;
use App\Models\Channel;
use App\Models\Package;
use App\Models\PastProject;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::first();
        $adminId = $adminUser?->id;

        // Channels
        $channelsData = [
            ['total_channels' => 4, 'user_id' => $adminId],
            ['total_channels' => 8, 'user_id' => $adminId],
            ['total_channels' => 16, 'user_id' => $adminId],
            ['total_channels' => 32, 'user_id' => $adminId],
        ];

        foreach ($channelsData as $channel) {
            Channel::firstOrCreate(
                ['total_channels' => $channel['total_channels']],
                $channel
            );
        }

        // Brands
        $brandsData = [
            ['name' => 'Hikvision', 'picture' => 'brands/hikvision.png', 'user_id' => $adminId],
            ['name' => 'Dahua', 'picture' => 'brands/dahua.png', 'user_id' => $adminId],
            ['name' => 'HiLook', 'picture' => 'brands/hilook.png', 'user_id' => $adminId],
            ['name' => 'EZVIZ', 'picture' => 'brands/ezviz.png', 'user_id' => $adminId],
            ['name' => 'Imou', 'picture' => 'brands/imou.png', 'user_id' => $adminId],
        ];

        foreach ($brandsData as $brand) {
            Brand::firstOrCreate(
                ['name' => $brand['name']],
                $brand
            );
        }

        $channelFour = Channel::where('total_channels', 4)->first();
        $channelEight = Channel::where('total_channels', 8)->first();

        // Packages
        $packagesData = [
            [
                'sequence' => 1,
                'name' => 'Hikvision 4-Camera Home Security Package',
                'slug' => 'hikvision-4-camera-home-security-package',
                'channel_id' => $channelFour?->id,
                'brands' => ['Hikvision'],
                'price' => 3850000,
                'cameras' => '4 Units (Outdoor / Indoor)',
                'recorder_unit' => '4-Channel DVR',
                'storage' => '500GB Surveillance Hard Drive',
                'power_connectors' => 'Adapter/PSU + BNC + DC Jacks',
                'cable' => 'Free 40 Meters (10M / Camera)',
                'service' => 'Free Installation & Online Setup',
                'description_eng' => 'Includes 4x 2MP Full HD Indoor/Outdoor Cameras, 4-Channel DVR, 1TB Surveillance HDD, and free standard installation across Bali.',
                'description_ina' => 'Termasuk 4x Kamera Indoor/Outdoor 2MP Full HD, DVR 4-Channel, HDD Surveillance 1TB, dan gratis instalasi standar di seluruh Bali.',
                'user_id' => $adminId,
            ],
            [
                'sequence' => 2,
                'name' => 'Dahua 8-Camera Villa ColorVu Package',
                'slug' => 'dahua-8-camera-villa-colorvu-package',
                'channel_id' => $channelEight?->id,
                'brands' => ['Dahua'],
                'price' => 7450000,
                'cameras' => '8 Units (Outdoor / Indoor)',
                'recorder_unit' => '8-Channel DVR',
                'storage' => '1TB Surveillance Hard Drive',
                'power_connectors' => 'Adapter/PSU + BNC + DC Jacks',
                'cable' => 'Free 80 Meters (10M / Camera)',
                'service' => 'Free Installation & Online Setup',
                'description_eng' => 'Includes 8x 5MP Full Color Night Vision Cameras, 8-Channel NVR, 2TB Western Digital Purple HDD, PoE Switch, and mobile remote monitoring setup.',
                'description_ina' => 'Termasuk 8x Kamera 5MP Full Color Night Vision, NVR 8-Channel, HDD Western Digital Purple 2TB, PoE Switch, dan setup pemantauan jarak jauh di HP.',
                'user_id' => $adminId,
            ],
            [
                'sequence' => 3,
                'name' => 'HiLook 4-Camera Economical Package',
                'slug' => 'hilook-4-camera-economical-package',
                'channel_id' => $channelFour?->id,
                'brands' => ['HiLook'],
                'price' => 2950000,
                'cameras' => '4 Units (Outdoor / Indoor)',
                'recorder_unit' => '4-Channel DVR',
                'storage' => '500GB Surveillance Hard Drive',
                'power_connectors' => 'Adapter/PSU + BNC + DC Jacks',
                'cable' => 'Free 40 Meters (10M / Camera)',
                'service' => 'Free Installation & Online Setup',
                'description_eng' => 'Cost-effective 1080P HD security setup designed for small shops and residential houses in Denpasar & Badung.',
                'description_ina' => 'Paket keamanan 1080P HD hemat biaya untuk toko kecil dan rumah tinggal di Denpasar & Badung.',
                'user_id' => $adminId,
            ],
        ];

        foreach ($packagesData as $pkg) {
            Package::updateOrCreate(
                ['slug' => $pkg['slug']],
                $pkg
            );
        }

        // Promotions
        $promotionsData = [
            [
                'sequence' => 1,
                'name' => 'Bali Villa Security Year-End Special Discount',
                'slug' => 'bali-villa-security-year-end-special-discount',
                'description_eng' => 'Get 15% discount on all 8-channel and 16-channel IP Camera systems including free site survey across Badung and Gianyar.',
                'description_ina' => 'Dapatkan diskon 15% untuk semua sistem IP Camera 8-channel dan 16-channel termasuk survei lokasi gratis di Badung dan Gianyar.',
                'price' => 6500000,
                'user_id' => $adminId,
            ],
            [
                'sequence' => 2,
                'name' => 'Smart Wireless CCTV Starter Kit Promo',
                'slug' => 'smart-wireless-cctv-starter-kit-promo',
                'description_eng' => 'EZVIZ 2-camera wireless Wi-Fi setup with two-way audio, human detection alert, and cloud backup trial.',
                'description_ina' => 'Paket 2 kamera wireless Wi-Fi EZVIZ dengan audio dua arah, deteksi manusia, dan uji coba cloud backup.',
                'price' => 1750000,
                'user_id' => $adminId,
            ],
        ];

        foreach ($promotionsData as $promo) {
            Promotion::firstOrCreate(
                ['slug' => $promo['slug']],
                $promo
            );
        }

        // Past Projects
        $projectsData = [
            [
                'sequence' => 1,
                'title' => 'The Palms Luxury Villa Complex',
                'sub_title' => 'Canggu, Bali',
                'slug' => 'the-palms-luxury-villa-complex',
                'description_eng' => 'Deployed 24-channel high-definition IP camera network covering perimeter fences, lobby, and pool areas with remote access on iOS & Android.',
                'description_ina' => 'Pemasangan jaringan IP Camera 24-channel definisi tinggi yang mencakup pagar keliling, lobi, dan area kolam renang dengan akses jarak jauh di iOS & Android.',
                'user_id' => $adminId,
            ],
            [
                'sequence' => 2,
                'title' => 'Boutique Eco Resort & Spa',
                'sub_title' => 'Ubud, Gianyar',
                'slug' => 'boutique-eco-resort-and-spa',
                'description_eng' => 'Installed discreet Dahua ColorVu night-vision cameras with fiber optic backbones preserving the natural aesthetic.',
                'description_ina' => 'Instalasi kamera malam Dahua ColorVu dengan jalur kabel fiber optik yang rapi untuk menjaga estetika alami resor.',
                'user_id' => $adminId,
            ],
            [
                'sequence' => 3,
                'title' => 'Denpasar Central Warehouse Logistics',
                'sub_title' => 'Denpasar Selatan',
                'slug' => 'denpasar-central-warehouse-logistics',
                'description_eng' => 'Implemented 32-camera optical zoom and license plate recognition (ANPR) system for cargo inbound/outbound management.',
                'description_ina' => 'Implementasi sistem 32 kamera optical zoom dan pengenalan plat nomor (ANPR) untuk manajemen keluar-masuk kargo.',
                'user_id' => $adminId,
            ],
        ];

        foreach ($projectsData as $project) {
            PastProject::updateOrCreate(
                ['slug' => $project['slug']],
                $project
            );
        }

        // About Us
        $aboutUs = AboutUs::updateOrCreate(
            ['title' => 'RV CCTV Bali Security Solutions'],
            [
                'sub_title_eng' => 'Serving on-site consultations and surveys across Denpasar, Badung, Gianyar, Tabanan, and surrounding areas in Bali.',
                'sub_title_ina' => 'Melayani survei dan konsultasi di tempat se-Bali (Denpasar, Badung, Gianyar, Tabanan).',
                'headline_eng' => 'Complete Security Solutions in Bali from Consultation to After-Sales Support.',
                'headline_ina' => 'Solusi Keamanan CCTV Terlengkap di Bali dari Konsultasi hingga Garansi Purnajual.',
                'description_eng' => 'RV CCTV Bali is dedicated to delivering state-of-the-art surveillance systems for villas, residences, hospitality resorts, and commercial enterprises across the Island of the Gods. We supply official warranty equipment from Hikvision, Dahua, and EZVIZ with 24/7 dedicated local technician support.',
                'description_ina' => 'RV CCTV Bali berkomitmen menghadirkan sistem keamanan CCTV terbaik untuk vila, rumah tinggal, resor perhotelan, dan tempat usaha di seluruh Bali. Kami menyediakan perangkat bergaransi resmi Hikvision, Dahua, dan EZVIZ dengan dukungan teknisi lokal berpengalaman.',
                'user_id' => $adminId,
            ]
        );

        // 4 About Features
        $aboutFeaturesData = [
            [
                'sequence' => 1,
                'title_eng' => '2-Year Official Warranty',
                'title_ina' => 'Garansi Resmi 2 Tahun',
                'description_eng' => '100% original units from authorized Hikvision, Dahua, and Ezviz distributors with hassle-free warranty claims in Bali.',
                'description_ina' => '100% unit original dari distributor resmi Hikvision, Dahua, dan Ezviz dengan klaim garansi mudah di Bali.',
            ],
            [
                'sequence' => 2,
                'title_eng' => 'Villa & Hotel Standard Installation',
                'title_ina' => 'Standar Instalasi Vila & Hotel',
                'description_eng' => "Concealed cable routing with neat protective conduits to preserve your building's architectural aesthetics.",
                'description_ina' => 'Jalur kabel tertutup dengan pipa pelindung rapi untuk menjaga estetika arsitektur bangunan Anda.',
            ],
            [
                'sequence' => 3,
                'title_eng' => 'Free Bali Area Survey',
                'title_ina' => 'Gratis Survei Area Bali',
                'description_eng' => 'Optimal lens placement recommendations to ensure every critical angle is covered with zero blind spots.',
                'description_ina' => 'Rekomendasi penempatan sudut kamera terbaik tanpa titik buta (zero blind spot).',
            ],
            [
                'sequence' => 4,
                'title_eng' => 'App Setup & Maintenance Support',
                'title_ina' => 'Panduan Aplikasi & Dukungan Teknisi',
                'description_eng' => 'Guided mobile app configuration until fully active, backed by responsive on-site technician support.',
                'description_ina' => 'Konfigurasi aplikasi HP hingga aktif dan siap pakai, didukung teknisi lokal yang responsif.',
            ],
        ];

        foreach ($aboutFeaturesData as $featureItem) {
            AboutFeature::updateOrCreate(
                [
                    'about_us_id' => $aboutUs->id,
                    'sequence' => $featureItem['sequence'],
                ],
                $featureItem
            );
        }
    }
}
