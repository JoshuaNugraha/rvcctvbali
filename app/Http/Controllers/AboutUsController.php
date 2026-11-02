<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsFormRequest;
use App\Models\AboutFeature;
use App\Models\AboutUs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $aboutUsList = AboutUs::with(['user', 'media', 'features'])->latest()->get();
        $aboutFeatures = AboutFeature::orderBy('sequence')->get();

        return view('admin.about_us.index', compact('aboutUsList', 'aboutFeatures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('admin.about-us.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutUsFormRequest $request): RedirectResponse
    {
        return redirect()->route('admin.about-us.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(AboutUs $aboutU): View
    {
        $aboutRecord = $aboutU->load(['user', 'media', 'features']);
        $isEditMode = true;

        return view('admin.about_us.form', compact('aboutRecord', 'isEditMode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutUs $aboutU): View
    {
        $aboutRecord = $aboutU->load(['media', 'features']);
        $isEditMode = true;

        return view('admin.about_us.form', compact('aboutRecord', 'isEditMode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AboutUsFormRequest $request, AboutUs $aboutU): RedirectResponse
    {
        $validatedData = $request->validated();

        $aboutU->update([
            'title' => $validatedData['title'],
            'sub_title_eng' => $validatedData['sub_title_eng'] ?? $validatedData['sub_title'] ?? null,
            'sub_title_ina' => $validatedData['sub_title_ina'] ?? null,
            'headline_eng' => $validatedData['headline_eng'] ?? $validatedData['heading_eng'] ?? null,
            'headline_ina' => $validatedData['headline_ina'] ?? $validatedData['heading_ina'] ?? null,
            'description_eng' => $validatedData['description_eng'] ?? null,
            'description_ina' => $validatedData['description_ina'] ?? null,
            'user_id' => Auth::id(),
        ]);

        if ($request->has('features') && is_array($request->input('features'))) {
            foreach ($request->input('features') as $featureId => $featureData) {
                if ($feat = AboutFeature::find($featureId)) {
                    $feat->update([
                        'title_eng' => $featureData['title_eng'] ?? $feat->title_eng,
                        'title_ina' => $featureData['title_ina'] ?? $feat->title_ina,
                        'description_eng' => $featureData['description_eng'] ?? $feat->description_eng,
                        'description_ina' => $featureData['description_ina'] ?? $feat->description_ina,
                        'sequence' => $featureData['sequence'] ?? $feat->sequence,
                    ]);
                }
            }
        }

        if ($request->hasFile('picture')) {
            $aboutU->addMediaFromRequest('picture')
                ->toMediaCollection('about_image');
        }

        return redirect()->route('admin.about-us.index')
            ->with('successMessage', 'About Us information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutUs $aboutU): RedirectResponse
    {
        return redirect()->route('admin.about-us.index');
    }
}
