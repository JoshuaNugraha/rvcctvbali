<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AddressSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settingRecord = Setting::firstOrCreate(
            ['name' => 'address'],
            [
                'content' => [
                    'street' => 'Jl. By Pass Ngurah Rai No. 128',
                    'city' => 'Denpasar Selatan',
                    'province' => 'Bali',
                    'postal_code' => '80222',
                    'country' => 'Indonesia',
                    'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3943.872887701061!2d115.20237399999998!3d-8.7036194!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2410150ed09ef%3A0x6d66419d5b314f56!2sRV%20CCTV%20TECHNOLOGY!5e0!3m2!1sid!2sid!4v1793423332997!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>',
                ],
            ]
        );

        return view('admin.settings.address', compact('settingRecord'));
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
        return $this->update($request, 'address');
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
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
            'maps_embed' => ['nullable', 'string'],
        ]);

        Setting::updateOrCreate(
            ['name' => 'address'],
            ['content' => $validatedData]
        );

        return redirect()->route('admin.settings.address.index')
            ->with('successMessage', 'Company address settings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Setting::where('name', 'address')->delete();

        return redirect()->route('admin.settings.address.index')
            ->with('successMessage', 'Address setting reset.');
    }
}
