<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Brand;
use App\Models\Channel;
use App\Models\Package;
use App\Models\PastProject;
use App\Models\Promotion;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $requestedLang = strtolower((string) $request->query('lang', ''));
        if (in_array($requestedLang, ['en', 'id'], true)) {
            $request->session()->put('visitorLang', $requestedLang);
        }

        $currentLang = $request->session()->get('visitorLang', 'en');

        $channelList = Channel::orderBy('total_channels')->get();
        $brandList = Brand::orderBy('name')->get();
        $packageList = Package::with(['channel'])->orderBy('sequence')->latest()->get();
        $promotionList = Promotion::with('media')->orderBy('sequence')->latest()->get();
        $pastProjectList = PastProject::with('media')->orderBy('sequence')->latest()->get();
        $aboutUsRecord = AboutUs::with(['media', 'features'])->latest()->first();
        $addressSetting = Setting::where('name', 'address')->first();
        $phoneSetting = Setting::where('name', 'phone_number')->first();
        $socialSetting = Setting::where('name', 'social_media')->first();

        return view('front.index', compact(
            'currentLang',
            'channelList',
            'brandList',
            'packageList',
            'promotionList',
            'pastProjectList',
            'aboutUsRecord',
            'addressSetting',
            'phoneSetting',
            'socialSetting'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        return $this->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('front.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id): View
    {
        return $this->index($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id): View
    {
        return $this->index($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        return redirect()->route('front.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        return redirect()->route('front.index');
    }
}
