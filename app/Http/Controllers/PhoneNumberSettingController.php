<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhoneNumberSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settingRecord = Setting::firstOrCreate(
            ['name' => 'phone_number'],
            [
                'content' => [
                    'phone_number' => '+62 878-5513-0070',
                ],
            ]
        );

        return view('admin.settings.phone_number', compact('settingRecord'));
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
        return $this->update($request, 'phone_number');
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
            'phone_number' => ['required', 'string', 'max:50'],
        ]);

        Setting::updateOrCreate(
            ['name' => 'phone_number'],
            ['content' => $validatedData]
        );

        return redirect()->route('admin.settings.phone-number.index')
            ->with('successMessage', 'Phone number updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Setting::where('name', 'phone_number')->delete();

        return redirect()->route('admin.settings.phone-number.index')
            ->with('successMessage', 'Phone number setting reset.');
    }
}
