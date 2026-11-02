<?php

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest visiting the landing page is recorded in visitors table', function () {
    $this->assertDatabaseCount('visitors', 0);

    $response = $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.195'])
        ->get('/');

    $response->assertStatus(200);

    $this->assertDatabaseCount('visitors', 1);
    $visitor = Visitor::first();
    expect($visitor)->not->toBeNull()
        ->and($visitor->ip_address)->toBe('203.0.113.195')
        ->and($visitor->date)->not->toBeNull();
});

test('same ip visiting again within 5 hours is only counted once', function () {
    // First visit
    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.10'])
        ->get('/');

    $this->assertDatabaseCount('visitors', 1);

    // Second visit immediately
    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.10'])
        ->get('/');

    $this->assertDatabaseCount('visitors', 1);

    // Third visit after 4 hours (still < 5 hours)
    $this->travel(4)->hours();
    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.10'])
        ->get('/');

    $this->assertDatabaseCount('visitors', 1);
});

test('same ip visiting after 5 hours is recorded as a new visit', function () {
    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.20'])
        ->get('/');

    $this->assertDatabaseCount('visitors', 1);

    // Travel 5 hours and 1 minute
    $this->travel(5)->hours();
    $this->travel(1)->minutes();

    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.20'])
        ->get('/');

    $this->assertDatabaseCount('visitors', 2);
});

test('authenticated admin visiting the landing page is not counted', function () {
    $admin = User::factory()->create();

    $response = $this->actingAs($admin)
        ->withServerVariables(['REMOTE_ADDR' => '203.0.113.88'])
        ->get('/');

    $response->assertStatus(200);
    $this->assertDatabaseCount('visitors', 0);
});

test('admin dashboard renders visitor statistics for today, week, and month', function () {
    $admin = User::factory()->create();

    // Create a visitor today
    Visitor::create([
        'ip_address' => '198.51.100.1',
        'date' => now(),
        'location' => 'Bali, Indonesia',
    ]);

    // Create a visitor 2 days ago (this week)
    Visitor::create([
        'ip_address' => '198.51.100.2',
        'date' => now()->startOfWeek(),
        'location' => 'Jakarta, Indonesia',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Statistik Pengunjung Website');
    $response->assertSee('Per Hari (Hari Ini)');
    $response->assertSee('Per Minggu (Pekan Ini)');
    $response->assertSee('Per Bulan (Bulan Ini)');
});
