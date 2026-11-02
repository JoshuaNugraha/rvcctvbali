<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotionsFormRequest;
use App\Models\Promotion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $promotionList = Promotion::with(['user', 'media'])->orderBy('sequence')->latest()->get();

        return view('admin.promotions.index', compact('promotionList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $promotionRecord = new Promotion;
        $isEditMode = false;

        return view('admin.promotions.form', compact('promotionRecord', 'isEditMode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromotionsFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $promotionRecord = new Promotion;
        $promotionRecord->name = $validatedData['name'];
        $promotionRecord->slug = Str::slug($validatedData['name']).'-'.Str::random(5);
        $promotionRecord->sequence = (int) ($validatedData['sequence'] ?? 0);
        $promotionRecord->description_eng = $validatedData['description_eng'] ?? null;
        $promotionRecord->description_ina = $validatedData['description_ina'] ?? null;
        $promotionRecord->price = (float) $validatedData['price'];
        $promotionRecord->user_id = Auth::id();
        $promotionRecord->save();

        if ($request->hasFile('picture')) {
            $promotionRecord->addMediaFromRequest('picture')
                ->toMediaCollection('promotion_image');
        }

        return redirect()->route('admin.promotions.index')
            ->with('successMessage', 'New promotion published successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion): View
    {
        $promotionRecord = $promotion->load(['user', 'media']);
        $isEditMode = true;

        return view('admin.promotions.form', compact('promotionRecord', 'isEditMode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion): View
    {
        $promotionRecord = $promotion->load('media');
        $isEditMode = true;

        return view('admin.promotions.form', compact('promotionRecord', 'isEditMode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PromotionsFormRequest $request, Promotion $promotion): RedirectResponse
    {
        $validatedData = $request->validated();

        $promotion->update([
            'name' => $validatedData['name'],
            'sequence' => (int) ($validatedData['sequence'] ?? 0),
            'description_eng' => $validatedData['description_eng'] ?? null,
            'description_ina' => $validatedData['description_ina'] ?? null,
            'price' => (float) $validatedData['price'],
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('picture')) {
            $promotion->addMediaFromRequest('picture')
                ->toMediaCollection('promotion_image');
        }

        return redirect()->route('admin.promotions.index')
            ->with('successMessage', 'Promotion updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion): RedirectResponse
    {
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('successMessage', 'Promotion deleted successfully.');
    }
}
