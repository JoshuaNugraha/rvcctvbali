@extends('layouts.admin')

@section('title', 'Past Projects')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div class="shell-header">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: var(--burgundy-900);">Past Projects Portfolio</h1>
        </div>
    </div>

    <!-- DataTables Table Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="shell-actions">
                <a href="{{ route('admin.past-projects.create') }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Add</span>
                </a>
            </div>
            <span class="badge badge-info">{{ $projectList->count() }} Projects</span>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="past-projects-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">Seq</th>
                        <th scope="col">Project Title</th>
                        <th scope="col">Picture</th>
                        <th scope="col">Location / Subtitle</th>
                        <th scope="col">Description</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Created At</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projectList as $project)
                        <tr>
                            <td><strong>#{{ $project->sequence }}</strong></td>
                            <td>
                                <div class="fw-bold" style="color: var(--burgundy-900); font-size: 0.95rem;">
                                    {{ $project->title }}
                                </div>
                                <code class="small text-muted">{{ $project->slug }}</code>
                            </td>
                            <td>
                                @php
                                    $projectMediaUrl = $project->getFirstMediaUrl('project_image');
                                @endphp
                                @if($projectMediaUrl)
                                    <img src="{{ $projectMediaUrl }}" alt="{{ $project->title }}" style="height: 36px; width: auto; object-fit: cover; border-radius: 6px; border: 1px solid var(--card-border); padding: 2px; background: #fff;">
                                @else
                                    <span class="text-muted">No picture</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $project->sub_title ?? 'Bali, Indonesia' }}</span>
                            </td>
                            <td>
                                <span class="text-muted small">{{ Str::limit(strip_tags((string) $project->description_eng), 80) }}</span>
                            </td>
                            <td>{{ $project->user?->name ?? 'System' }}</td>
                            <td>{{ $project->created_at->format('d M Y') }}</td>
                            <td class="actions-cell">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <a href="{{ route('admin.past-projects.edit', $project->id) }}" class="btn btn-secondary btn-sm">
                                        Edit
                                    </a>
                                    <form
                                        action="{{ route('admin.past-projects.destroy', $project->id) }}"
                                        method="POST"
                                        class="d-inline delete-confirm-form"
                                        data-confirm-title="Delete Past Project?"
                                        data-confirm-text="Are you sure you want to delete '{{ $project->title }}'? This action cannot be undone."
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm badge-danger" style="border-radius: 8px; padding: 0.35rem 0.75rem;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
