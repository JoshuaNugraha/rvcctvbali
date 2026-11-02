<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialMediaSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settingRecord = Setting::firstOrCreate(
            ['name' => 'social_media'],
            [
                'content' => [
                    'instagram' => 'https://instagram.com/rvcctvbali',
                    'facebook' => 'https://facebook.com/rvcctvbali',
                    'youtube' => 'https://youtube.com/@rvcctvbali',
                    'tiktok' => 'https://tiktok.com/@rvcctvbali',
                ],
            ]
        );

        return view('admin.settings.social_media', compact('settingRecord'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return $this->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->update($request, 'social_media');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        return $this->index();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return $this->index();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'instagram' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'tiktok' => ['nullable', 'url', 'max:255'],
        ]);

        Setting::updateOrCreate(
            ['name' => 'social_media'],
            ['content' => $validatedData]
        );

        return redirect()->route('admin.settings.social-media.index')
            ->with('successMessage', 'Social media links updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Setting::where('name', 'social_media')->delete();

        return redirect()->route('admin.settings.social-media.index')
            ->with('successMessage', 'Social media setting reset.');
    }
}
