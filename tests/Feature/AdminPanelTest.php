<?php

use App\Models\AboutFeature;
use App\Models\AboutUs;
use App\Models\Brand;
use App\Models\Channel;
use App\Models\Package;
use App\Models\PastProject;
use App\Models\Promotion;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\DemoDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('admin can log in successfully with credentials', function () {
    $adminUser = User::where('username', 'admin')->first();

    $response = $this->post('/login', [
        'login' => 'admin',
        'password' => 'admin123',
    ]);

    $response->assertRedirect('/admin/dashboard');
    $this->assertAuthenticatedAs($adminUser);
});

test('authenticated user can view dashboard and all admin resource tables', function () {
    $adminUser = User::where('username', 'admin')->first();

    $this->seed(DemoDataSeeder::class);

    $this->actingAs($adminUser);

    $this->get('/admin/dashboard')->assertStatus(200)->assertSee('dashboard-packages-table');
    $this->get('/admin/channels')->assertStatus(200)->assertSee('channels-table');
    $this->get('/admin/brands')->assertStatus(200)->assertSee('brands-table');
    $this->get('/admin/packages')->assertStatus(200)->assertSee('packages-table');
    $this->get('/admin/promotions')->assertStatus(200)->assertSee('promotions-table');
    $this->get('/admin/past-projects')->assertStatus(200)->assertSee('past-projects-table');
    $this->get('/admin/about-us')->assertStatus(200)->assertSee('about-us-table')->assertSee('about-features-table');
    $this->get('/admin/settings/address')->assertStatus(200)->assertSee('address-table');
    $this->get('/admin/settings/phone-number')->assertStatus(200)->assertSee('phones-table');
    $this->get('/admin/settings/social-media')->assertStatus(200)->assertSee('social-table');
});

test('authenticated user can view create and edit forms and manage channels and brands', function () {
    $adminUser = User::where('username', 'admin')->first();
    $this->actingAs($adminUser);

    // Channel create & edit form
    $this->get('/admin/channels/create')->assertStatus(200)->assertSee('Channel Configuration Form');
    $this->post('/admin/channels', ['total_channels' => 12])->assertRedirect('/admin/channels');
    $createdChannel = Channel::where('total_channels', 12)->firstOrFail();

    $this->get("/admin/channels/{$createdChannel->id}/edit")->assertStatus(200)->assertSee('Channel Details');
    $this->put("/admin/channels/{$createdChannel->id}", ['total_channels' => 24])->assertRedirect('/admin/channels');
    $this->assertDatabaseHas('channels', ['id' => $createdChannel->id, 'total_channels' => 24]);

    // Brand create & edit form with Spatie MediaLibrary
    Storage::fake('public');
    $this->get('/admin/brands/create')->assertStatus(200)->assertSee('Brand Information Form');
    $this->post('/admin/brands', [
        'name' => 'Uniview',
        'picture' => UploadedFile::fake()->image('uniview.png', 200, 100),
    ])->assertRedirect('/admin/brands');
    $createdBrand = Brand::where('name', 'Uniview')->firstOrFail();
    expect($createdBrand->getFirstMedia('brand_logo'))->not->toBeNull();

    $this->get("/admin/brands/{$createdBrand->id}/edit")->assertStatus(200)->assertSee('Brand Details');
    $this->put("/admin/brands/{$createdBrand->id}", ['name' => 'Uniview Pro'])->assertRedirect('/admin/brands');
    $this->assertDatabaseHas('brands', ['id' => $createdBrand->id, 'name' => 'Uniview Pro']);

    // Package create & edit form
    $this->get('/admin/packages/create')->assertStatus(200)->assertSee('Package Information Form');
    $this->post('/admin/packages', [
        'name' => '4-Camera Villa Package',
        'sequence' => 1,
        'channel_id' => $createdChannel->id,
        'brands' => ['Uniview Pro'],
        'price' => 3600000,
        'cameras' => '4 Units (Outdoor / Indoor)',
        'recorder_unit' => '4-Channel DVR',
        'storage' => '500GB Surveillance Hard Drive',
        'power_connectors' => 'Adapter/PSU + BNC + DC Jacks',
        'cable' => 'Free 40 Meters (10M / Camera)',
        'service' => 'Free Installation & Online Setup',
        'description_eng' => '4 Outdoor/Indoor cameras + 500GB HDD',
        'description_ina' => '4 kamera Outdoor/Indoor + HDD 500GB',
    ])->assertRedirect('/admin/packages');
    $createdPackage = Package::where('name', '4-Camera Villa Package')->firstOrFail();

    $this->get("/admin/packages/{$createdPackage->id}/edit")->assertStatus(200)->assertSee('Package Details');
    $this->put("/admin/packages/{$createdPackage->id}", [
        'name' => '8-Camera Villa Package',
        'sequence' => 2,
        'channel_id' => $createdChannel->id,
        'brands' => ['Uniview Pro'],
        'price' => 6400000,
        'cameras' => '8 Units (Outdoor / Indoor)',
        'recorder_unit' => '8-Channel DVR',
        'storage' => '1TB Surveillance Hard Drive',
        'power_connectors' => 'Adapter/PSU + BNC + DC Jacks',
        'cable' => 'Free 80 Meters (10M / Camera)',
        'service' => 'Free Installation & Online Setup',
        'description_eng' => '8 Outdoor/Indoor cameras + 1TB HDD',
        'description_ina' => '8 kamera Outdoor/Indoor + HDD 1TB',
    ])->assertRedirect('/admin/packages');
    $this->assertDatabaseHas('packages', [
        'id' => $createdPackage->id,
        'name' => '8-Camera Villa Package',
        'price' => 6400000,
        'cameras' => '8 Units (Outdoor / Indoor)',
        'recorder_unit' => '8-Channel DVR',
        'storage' => '1TB Surveillance Hard Drive',
        'power_connectors' => 'Adapter/PSU + BNC + DC Jacks',
        'cable' => 'Free 80 Meters (10M / Camera)',
        'service' => 'Free Installation & Online Setup',
        'description_eng' => '8 Outdoor/Indoor cameras + 1TB HDD',
        'description_ina' => '8 kamera Outdoor/Indoor + HDD 1TB',
    ]);

    // Promotion create & edit form with Spatie MediaLibrary & TinyMCE
    $this->get('/admin/promotions/create')
        ->assertStatus(200)
        ->assertSee('Promotion Information Form')
        ->assertSee('tinymce-editor');
    $this->post('/admin/promotions', [
        'name' => 'Holiday Villa Promo',
        'sequence' => 1,
        'price' => 2450000,
        'picture' => UploadedFile::fake()->image('holiday-promo.jpg', 600, 400),
        'description_eng' => '<p>Special holiday <strong>CCTV installation</strong> offer</p>',
        'description_ina' => '<p>Promo spesial liburan <strong>instalasi CCTV</strong></p>',
    ])->assertRedirect('/admin/promotions');
    $createdPromotion = Promotion::where('name', 'Holiday Villa Promo')->firstOrFail();
    expect($createdPromotion->getFirstMedia('promotion_image'))->not->toBeNull();

    $this->get("/admin/promotions/{$createdPromotion->id}/edit")->assertStatus(200)->assertSee('Promotion Details');
    $this->put("/admin/promotions/{$createdPromotion->id}", [
        'name' => 'Year-End Villa Promo',
        'sequence' => 2,
        'price' => 2350000,
        'description_eng' => '<p>Updated year-end CCTV installation offer</p>',
        'description_ina' => '<p>Promo akhir tahun instalasi CCTV</p>',
    ])->assertRedirect('/admin/promotions');
    $this->assertDatabaseHas('promotions', [
        'id' => $createdPromotion->id,
        'name' => 'Year-End Villa Promo',
        'price' => 2350000,
        'description_eng' => '<p>Updated year-end CCTV installation offer</p>',
        'description_ina' => '<p>Promo akhir tahun instalasi CCTV</p>',
    ]);

    // Past Project create & edit form with Spatie MediaLibrary & TinyMCE
    $this->get('/admin/past-projects/create')
        ->assertStatus(200)
        ->assertSee('Past Project Information Form')
        ->assertSee('tinymce-editor');
    $this->post('/admin/past-projects', [
        'title' => 'Luxury Beach Club CCTV Setup',
        'sub_title' => 'Seminyak, Bali',
        'sequence' => 1,
        'picture' => UploadedFile::fake()->image('beach-club.jpg', 800, 500),
        'description_eng' => '<p>16-channel IP camera installation for beachfront club</p>',
        'description_ina' => '<p>Instalasi IP camera 16-channel untuk beach club</p>',
    ])->assertRedirect('/admin/past-projects');
    $createdProject = PastProject::where('title', 'Luxury Beach Club CCTV Setup')->firstOrFail();
    expect($createdProject->getFirstMedia('project_image'))->not->toBeNull();

    $this->get("/admin/past-projects/{$createdProject->id}/edit")->assertStatus(200)->assertSee('Past Project Details');
    $this->put("/admin/past-projects/{$createdProject->id}", [
        'title' => 'Luxury Beach Club & Resort CCTV Setup',
        'sub_title' => 'Seminyak & Canggu',
        'sequence' => 2,
        'description_eng' => '<p>Updated 24-channel IP camera installation</p>',
        'description_ina' => '<p>Update instalasi IP camera 24-channel</p>',
    ])->assertRedirect('/admin/past-projects');
    $this->assertDatabaseHas('past_projects', [
        'id' => $createdProject->id,
        'title' => 'Luxury Beach Club & Resort CCTV Setup',
        'description_eng' => '<p>Updated 24-channel IP camera installation</p>',
        'description_ina' => '<p>Update instalasi IP camera 24-channel</p>',
    ]);

    // About Us edit-only (no create or delete)
    $existingAbout = AboutUs::firstOrCreate(
        ['title' => 'RV CCTV Technology Bali'],
        [
            'sub_title' => 'Official Bali Showroom',
            'description_eng' => '<p>Official CCTV distributor in Bali.</p>',
            'description_ina' => '<p>Distributor resmi CCTV di Bali.</p>',
        ]
    );

    // Create & delete redirects back to index
    $this->get('/admin/about-us/create')->assertRedirect('/admin/about-us');
    $this->post('/admin/about-us', ['title' => 'New About Us'])->assertRedirect('/admin/about-us');
    $this->delete("/admin/about-us/{$existingAbout->id}")->assertRedirect('/admin/about-us');

    // Edit form works with Spatie MediaLibrary & TinyMCE
    $this->get("/admin/about-us/{$existingAbout->id}/edit")
        ->assertStatus(200)
        ->assertSee('About Us Details')
        ->assertSee('tinymce-editor');

    $this->put("/admin/about-us/{$existingAbout->id}", [
        'title' => 'RV CCTV Technology Bali Center',
        'sub_title_eng' => 'Official Denpasar Showroom & Experience Center',
        'sub_title_ina' => 'Showroom Resmi Denpasar & Pusat Pengalaman CCTV',
        'headline_eng' => 'Advanced Security Solutions in Bali',
        'headline_ina' => 'Solusi Keamanan CCTV Modern di Bali',
        'picture' => UploadedFile::fake()->image('showroom.jpg', 800, 500),
        'description_eng' => '<p>Updated official CCTV distributor in Bali.</p>',
        'description_ina' => '<p>Update distributor resmi CCTV di Bali.</p>',
    ])->assertRedirect('/admin/about-us');

    $existingAbout->refresh();
    expect($existingAbout->getFirstMedia('about_image'))->not->toBeNull();
    $this->assertDatabaseHas('about_us', [
        'id' => $existingAbout->id,
        'title' => 'RV CCTV Technology Bali Center',
        'sub_title_eng' => 'Official Denpasar Showroom & Experience Center',
        'sub_title_ina' => 'Showroom Resmi Denpasar & Pusat Pengalaman CCTV',
        'headline_eng' => 'Advanced Security Solutions in Bali',
        'headline_ina' => 'Solusi Keamanan CCTV Modern di Bali',
        'description_eng' => '<p>Updated official CCTV distributor in Bali.</p>',
        'description_ina' => '<p>Update distributor resmi CCTV di Bali.</p>',
    ]);

    // Front page displays the updated headline and subtitle in both languages
    $this->get('/?lang=id')
        ->assertStatus(200)
        ->assertSee('Solusi Keamanan CCTV Modern di Bali')
        ->assertSee('Showroom Resmi Denpasar & Pusat Pengalaman CCTV');
    $this->get('/?lang=en')
        ->assertStatus(200)
        ->assertSee('Advanced Security Solutions in Bali')
        ->assertSee('Official Denpasar Showroom & Experience Center');
});

test('authenticated user can edit address, single phone number, and social media settings', function () {
    $adminUser = User::where('username', 'admin')->first();
    $this->actingAs($adminUser);

    // 1. Edit Address
    $addressSetting = Setting::firstOrCreate(['name' => 'address']);
    $this->get('/admin/settings/address')
        ->assertStatus(200)
        ->assertSee('Edit Company Address')
        ->assertSee('address-table');

    $sampleEmbed = '<iframe src="https://www.google.com/maps/embed?pb=test-maps" width="600" height="450"></iframe>';
    $this->put("/admin/settings/address/{$addressSetting->id}", [
        'street' => 'Jl. Sunset Road No. 88X',
        'city' => 'Kuta',
        'province' => 'Bali',
        'postal_code' => '80361',
        'country' => 'Indonesia',
        'maps_embed' => $sampleEmbed,
    ])->assertRedirect('/admin/settings/address');

    $addressSetting->refresh();
    expect($addressSetting->content['street'])->toBe('Jl. Sunset Road No. 88X')
        ->and($addressSetting->content['city'])->toBe('Kuta')
        ->and($addressSetting->content['postal_code'])->toBe('80361')
        ->and($addressSetting->content['maps_embed'])->toBe($sampleEmbed);

    // 2. Edit Phone Number (Single phone number only)
    $phoneSetting = Setting::firstOrCreate(['name' => 'phone_number']);
    $this->get('/admin/settings/phone-number')
        ->assertStatus(200)
        ->assertSee('Edit Official Contact Phone Number')
        ->assertSee('phones-table');

    $this->put("/admin/settings/phone-number/{$phoneSetting->id}", [
        'phone_number' => '+62 899-1234-5678',
    ])->assertRedirect('/admin/settings/phone-number');

    $phoneSetting->refresh();
    expect($phoneSetting->content)->toEqual(['phone_number' => '+62 899-1234-5678']);

    // 3. Edit Social Media
    $socialSetting = Setting::firstOrCreate(['name' => 'social_media']);
    $this->get('/admin/settings/social-media')
        ->assertStatus(200)
        ->assertSee('Edit Social Media Profiles')
        ->assertSee('social-table');

    $this->put("/admin/settings/social-media/{$socialSetting->id}", [
        'instagram' => 'https://instagram.com/rvcctvbali_official',
        'facebook' => 'https://facebook.com/rvcctvbali_official',
        'youtube' => 'https://youtube.com/@rvcctvbali_official',
        'tiktok' => 'https://tiktok.com/@rvcctvbali_official',
    ])->assertRedirect('/admin/settings/social-media');

    $socialSetting->refresh();
    expect($socialSetting->content['instagram'])->toBe('https://instagram.com/rvcctvbali_official');

    // 4. Verify Front page uses the updated settings
    $frontResponse = $this->get('/');
    $frontResponse->assertStatus(200)
        ->assertSee('Jl. Sunset Road No. 88X')
        ->assertSee('+62 899-1234-5678')
        ->assertSee('https://instagram.com/rvcctvbali_official')
        ->assertSee('https://tiktok.com/@rvcctvbali_official')
        ->assertSee('test-maps')
        ->assertSee('data-wa-phone="6289912345678"', false);
});

test('authenticated user can perform full CRUD on about card features and see changes on front', function () {
    $adminUser = User::where('username', 'admin')->first();
    $this->actingAs($adminUser);

    $this->seed(DemoDataSeeder::class);

    // List & Create Form
    $this->get('/admin/about-us')
        ->assertStatus(200)
        ->assertSee('about-features-table');

    $this->get('/admin/about-features/create')
        ->assertStatus(200)
        ->assertSee('New About Feature Card Form');

    // Create
    $this->post('/admin/about-features', [
        'sequence' => 5,
        'title_eng' => 'AI Motion Detection',
        'title_ina' => 'Deteksi Gerak Pintar AI',
        'description_eng' => 'Advanced AI human and vehicle detection algorithms.',
        'description_ina' => 'Algoritma cerdas pendeteksi manusia dan kendaraan.',
    ])->assertRedirect('/admin/about-us');

    $createdFeature = AboutFeature::where('title_eng', 'AI Motion Detection')->firstOrFail();
    expect($createdFeature->title_ina)->toBe('Deteksi Gerak Pintar AI');

    // Edit Form & Update
    $this->get("/admin/about-features/{$createdFeature->id}/edit")
        ->assertStatus(200)
        ->assertSee('About Feature Card Details');

    $this->put("/admin/about-features/{$createdFeature->id}", [
        'sequence' => 1,
        'title_eng' => 'AI Smart Alert System',
        'title_ina' => 'Sistem Peringatan Pintar AI',
        'description_eng' => 'Instant push notifications directly to smartphone.',
        'description_ina' => 'Notifikasi instan langsung ke smartphone Anda.',
    ])->assertRedirect('/admin/about-us');

    $createdFeature->refresh();
    expect($createdFeature->title_eng)->toBe('AI Smart Alert System')
        ->and($createdFeature->title_ina)->toBe('Sistem Peringatan Pintar AI');

    // Front page reflects updated feature
    $this->get('/?lang=id')
        ->assertStatus(200)
        ->assertSee('Sistem Peringatan Pintar AI')
        ->assertSee('Notifikasi instan langsung ke smartphone Anda.');

    $this->get('/?lang=en')
        ->assertStatus(200)
        ->assertSee('AI Smart Alert System')
        ->assertSee('Instant push notifications directly to smartphone.');

    // Delete
    $this->delete("/admin/about-features/{$createdFeature->id}")
        ->assertRedirect('/admin/about-us');

    $this->assertDatabaseMissing('about_features', ['id' => $createdFeature->id]);
});
