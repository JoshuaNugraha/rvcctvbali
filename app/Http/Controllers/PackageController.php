<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackagesFormRequest;
use App\Models\Brand;
use App\Models\Channel;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $packageList = Package::with(['channel', 'user'])->orderBy('sequence')->latest()->get();

        return view('admin.packages.index', compact('packageList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $packageRecord = new Package;
        $channelList = Channel::orderBy('total_channels')->get();
        $brandList = Brand::orderBy('name')->get();
        $isEditMode = false;

        return view('admin.packages.form', compact('packageRecord', 'channelList', 'brandList', 'isEditMode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackagesFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $packageRecord = new Package;
        $packageRecord->name = $validatedData['name'];
        $packageRecord->slug = Str::slug($validatedData['name']).'-'.Str::random(5);
        $packageRecord->sequence = (int) ($validatedData['sequence'] ?? 0);
        $packageRecord->channel_id = $validatedData['channel_id'] ?? null;
        $packageRecord->brands = array_values($validatedData['brands'] ?? []);
        $packageRecord->price = (float) $validatedData['price'];
        $packageRecord->cameras = $validatedData['cameras'] ?? null;
        $packageRecord->recorder_unit = $validatedData['recorder_unit'] ?? null;
        $packageRecord->storage = $validatedData['storage'] ?? null;
        $packageRecord->power_connectors = $validatedData['power_connectors'] ?? null;
        $packageRecord->cable = $validatedData['cable'] ?? null;
        $packageRecord->service = $validatedData['service'] ?? null;
        $packageRecord->description_eng = $validatedData['description_eng'] ?? null;
        $packageRecord->description_ina = $validatedData['description_ina'] ?? null;
        $packageRecord->user_id = Auth::id();
        $packageRecord->save();

        return redirect()->route('admin.packages.index')
            ->with('successMessage', 'New CCTV package created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package): View
    {
        $packageRecord = $package->load(['channel', 'user']);
        $channelList = Channel::orderBy('total_channels')->get();
        $brandList = Brand::orderBy('name')->get();
        $isEditMode = true;

        return view('admin.packages.form', compact('packageRecord', 'channelList', 'brandList', 'isEditMode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package): View
    {
        $packageRecord = $package;
        $channelList = Channel::orderBy('total_channels')->get();
        $brandList = Brand::orderBy('name')->get();
        $isEditMode = true;

        return view('admin.packages.form', compact('packageRecord', 'channelList', 'brandList', 'isEditMode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackagesFormRequest $request, Package $package): RedirectResponse
    {
        $validatedData = $request->validated();

        $package->update([
            'name' => $validatedData['name'],
            'sequence' => (int) ($validatedData['sequence'] ?? 0),
            'channel_id' => $validatedData['channel_id'] ?? null,
            'brands' => array_values($validatedData['brands'] ?? []),
            'price' => (float) $validatedData['price'],
            'cameras' => $validatedData['cameras'] ?? null,
            'recorder_unit' => $validatedData['recorder_unit'] ?? null,
            'storage' => $validatedData['storage'] ?? null,
            'power_connectors' => $validatedData['power_connectors'] ?? null,
            'cable' => $validatedData['cable'] ?? null,
            'service' => $validatedData['service'] ?? null,
            'description_eng' => $validatedData['description_eng'] ?? null,
            'description_ina' => $validatedData['description_ina'] ?? null,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.packages.index')
            ->with('successMessage', 'CCTV package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('successMessage', 'CCTV package deleted successfully.');
    }
}
