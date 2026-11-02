<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandsFormRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $brandList = Brand::with(['user', 'media'])->latest()->get();

        return view('admin.brands.index', compact('brandList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $brandRecord = new Brand;
        $isEditMode = false;

        return view('admin.brands.form', compact('brandRecord', 'isEditMode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandsFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $brandRecord = new Brand;
        $brandRecord->name = $validatedData['name'];
        $brandRecord->user_id = Auth::id();
        $brandRecord->save();

        if ($request->hasFile('picture')) {
            $mediaItem = $brandRecord->addMediaFromRequest('picture')
                ->toMediaCollection('brand_logo');
            $brandRecord->update(['picture' => $mediaItem->getUrl()]);
        }

        return redirect()->route('admin.brands.index')
            ->with('successMessage', 'New brand added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand): View
    {
        $brandRecord = $brand->load(['user', 'media']);
        $isEditMode = true;

        return view('admin.brands.form', compact('brandRecord', 'isEditMode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand): View
    {
        $brandRecord = $brand->load('media');
        $isEditMode = true;

        return view('admin.brands.form', compact('brandRecord', 'isEditMode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandsFormRequest $request, Brand $brand): RedirectResponse
    {
        $validatedData = $request->validated();

        $brand->update([
            'name' => $validatedData['name'],
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('picture')) {
            $mediaItem = $brand->addMediaFromRequest('picture')
                ->toMediaCollection('brand_logo');
            $brand->update(['picture' => $mediaItem->getUrl()]);
        }

        return redirect()->route('admin.brands.index')
            ->with('successMessage', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('successMessage', 'Brand deleted successfully.');
    }
}
