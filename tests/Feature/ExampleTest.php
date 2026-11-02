<?php

use App\Models\Brand;
use App\Models\Channel;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the visitor home page returns a successful response and renders database packages', function () {
    $channelItem = Channel::query()->create(['total_channels' => 8]);
    Brand::query()->create(['name' => 'Hikvision']);

    Package::query()->create([
        'name' => '8-Camera Analog Package',
        'slug' => '8-camera-analog-package',
        'channel_id' => $channelItem->id,
        'brands' => ['Hikvision', 'Dahua'],
        'price' => 6400000,
        'cameras' => '8 Units (Outdoor / Indoor)',
        'recorder_unit' => '8-Channel DVR',
        'storage' => '500GB Surveillance Hard Drive',
        'power_connectors' => 'Adapter/PSU + BNC + DC Jacks',
        'cable' => 'Free 80 Meters (10M / Camera)',
        'service' => 'Free Installation & Online Setup',
        'description_eng' => 'Complete 8CH CCTV package.',
        'description_ina' => 'Paket lengkap CCTV 8CH.',
    ]);

    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('RV CCTV TECHNOLOGY')
        ->assertSee('TOP OFFERS')
        ->assertSee('English')
        ->assertSee('Indonesia')
        ->assertSee('8-Camera Analog Package')
        ->assertSee('Rp 6.400.000')
        ->assertSee('8 Units (Outdoor / Indoor)')
        ->assertSee('8-Channel DVR')
        ->assertSee('500GB Surveillance Hard Drive')
        ->assertSee('Adapter/PSU + BNC + DC Jacks')
        ->assertSee('Free 80 Meters (10M / Camera)')
        ->assertSee('Free Installation & Online Setup')
        ->assertSee('offer-card-image')
        ->assertSee('offer-full-img')
        ->assertSee('offer-wide-full-img');

    $indonesianResponse = $this->get('/?lang=id');
    $indonesianResponse->assertStatus(200)
        ->assertSee('Beranda')
        ->assertSee('Paket CCTV')
        ->assertSee('Konsultasi Gratis');
});

test('the login page returns a successful response', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});
