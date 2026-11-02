<?php

namespace App\Http\Controllers;

use App\Http\Requests\PastProjectsFormRequest;
use App\Models\PastProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PastProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectList = PastProject::with(['user', 'media'])->orderBy('sequence')->latest()->get();

        return view('admin.past_projects.index', compact('projectList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $projectRecord = new PastProject;
        $isEditMode = false;

        return view('admin.past_projects.form', compact('projectRecord', 'isEditMode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PastProjectsFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $projectRecord = new PastProject;
        $projectRecord->title = $validatedData['title'];
        $projectRecord->sub_title = $validatedData['sub_title'] ?? null;
        $projectRecord->slug = Str::slug($validatedData['title']).'-'.Str::random(5);
        $projectRecord->sequence = (int) ($validatedData['sequence'] ?? 0);
        $projectRecord->description_eng = $validatedData['description_eng'] ?? null;
        $projectRecord->description_ina = $validatedData['description_ina'] ?? null;
        $projectRecord->user_id = Auth::id();
        $projectRecord->save();

        if ($request->hasFile('picture')) {
            $projectRecord->addMediaFromRequest('picture')
                ->toMediaCollection('project_image');
        }

        return redirect()->route('admin.past-projects.index')
            ->with('successMessage', 'Past project record added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PastProject $pastProject): View
    {
        $projectRecord = $pastProject->load(['user', 'media']);
        $isEditMode = true;

        return view('admin.past_projects.form', compact('projectRecord', 'isEditMode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PastProject $pastProject): View
    {
        $projectRecord = $pastProject->load('media');
        $isEditMode = true;

        return view('admin.past_projects.form', compact('projectRecord', 'isEditMode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PastProjectsFormRequest $request, PastProject $pastProject): RedirectResponse
    {
        $validatedData = $request->validated();

        $pastProject->update([
            'title' => $validatedData['title'],
            'sub_title' => $validatedData['sub_title'] ?? null,
            'sequence' => (int) ($validatedData['sequence'] ?? 0),
            'description_eng' => $validatedData['description_eng'] ?? null,
            'description_ina' => $validatedData['description_ina'] ?? null,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('picture')) {
            $pastProject->addMediaFromRequest('picture')
                ->toMediaCollection('project_image');
        }

        return redirect()->route('admin.past-projects.index')
            ->with('successMessage', 'Past project record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PastProject $pastProject): RedirectResponse
    {
        $pastProject->delete();

        return redirect()->route('admin.past-projects.index')
            ->with('successMessage', 'Past project deleted successfully.');
    }
}
