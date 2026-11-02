<?php

use App\Http\Controllers\AboutFeatureController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AddressSettingController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PastProjectController;
use App\Http\Controllers\PhoneNumberSettingController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SocialMediaSettingController;
use App\Models\Brand;
use App\Models\Channel;
use App\Models\Package;
use App\Models\PastProject;
use App\Models\Promotion;
use App\Models\Visitor;
use Illuminate\Support\Facades\Route;

// Visitor landing page
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::resource('front', FrontController::class);

// Authentication routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.post');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
Route::resource('login-session', LoginController::class);

// Admin group
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard (no separate controller required per user request)
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', function () {
        $totalChannels = Channel::count();
        $totalBrands = Brand::count();
        $totalPackages = Package::count();
        $totalPromotions = Promotion::count();
        $totalProjects = PastProject::count();
        $recentPackages = Package::with(['channel', 'user'])->latest()->take(5)->get();

        $visitorsToday = Visitor::where('date', '>=', now()->startOfDay())->count();
        $visitorsThisWeek = Visitor::where('date', '>=', now()->startOfWeek())->count();
        $visitorsThisMonth = Visitor::where('date', '>=', now()->startOfMonth())->count();
        $totalVisitors = Visitor::count();

        return view('admin.dashboard', compact(
            'totalChannels',
            'totalBrands',
            'totalPackages',
            'totalPromotions',
            'totalProjects',
            'recentPackages',
            'visitorsToday',
            'visitorsThisWeek',
            'visitorsThisMonth',
            'totalVisitors'
        ));
    })->name('dashboard');

    // Products (sub menus)
    Route::resource('channels', ChannelController::class);
    Route::resource('brands', BrandController::class);

    // Main menus
    Route::resource('packages', PackageController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('past-projects', PastProjectController::class);
    Route::resource('about-us', AboutUsController::class);
    Route::resource('about-features', AboutFeatureController::class);

    // Settings (childs)
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', fn () => redirect()->route('admin.settings.address.index'))->name('index');
        Route::resource('address', AddressSettingController::class)->names('address');
        Route::resource('phone-number', PhoneNumberSettingController::class)->names('phone-number');
        Route::resource('social-media', SocialMediaSettingController::class)->names('social-media');
    });
});
