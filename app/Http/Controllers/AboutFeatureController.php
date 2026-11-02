<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutFeatureFormRequest;
use App\Models\AboutFeature;
use App\Models\AboutUs;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AboutFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): RedirectResponse|View
    {
        return redirect()->route('admin.about-us.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $featureRecord = new AboutFeature([
            'sequence' => (AboutFeature::max('sequence') ?? 0) + 1,
            'about_us_id' => AboutUs::value('id'),
        ]);
        $isEditMode = false;

        return view('admin.about_features.form', compact('featureRecord', 'isEditMode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutFeatureFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        if (empty($validatedData['about_us_id'])) {
            $validatedData['about_us_id'] = AboutUs::value('id');
        }

        AboutFeature::create($validatedData);

        return redirect()->route('admin.about-us.index')
            ->with('successMessage', 'About card feature created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AboutFeature $aboutFeature): RedirectResponse
    {
        return redirect()->route('admin.about-features.edit', $aboutFeature->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutFeature $aboutFeature): View
    {
        $featureRecord = $aboutFeature;
        $isEditMode = true;

        return view('admin.about_features.form', compact('featureRecord', 'isEditMode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AboutFeatureFormRequest $request, AboutFeature $aboutFeature): RedirectResponse
    {
        $validatedData = $request->validated();
        if (empty($validatedData['about_us_id'])) {
            $validatedData['about_us_id'] = AboutUs::value('id');
        }

        $aboutFeature->update($validatedData);

        return redirect()->route('admin.about-us.index')
            ->with('successMessage', 'About card feature updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutFeature $aboutFeature): RedirectResponse
    {
        $aboutFeature->delete();

        return redirect()->route('admin.about-us.index')
            ->with('successMessage', 'About card feature deleted successfully.');
    }
}
