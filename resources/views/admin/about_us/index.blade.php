@extends('layouts.admin')

@section('title', 'About Us Management')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div class="shell-header">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: var(--burgundy-900);">About Us Information</h1>
        </div>
    </div>

    <!-- DataTables Table Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div>
                <h2 class="card-heading">About Us Entries</h2>
                <span style="font-size: 0.775rem; color: var(--text-subtle);">Manage company profile and showroom information</span>
            </div>
            <span class="badge badge-info">{{ $aboutUsList->count() }} Entries</span>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="about-us-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Picture</th>
                        <th scope="col">Subtitle</th>
                        <th scope="col">Headline</th>
                        <th scope="col">Description</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Updated At</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aboutUsList as $aboutItem)
                        <tr>
                            <td><strong>#{{ $aboutItem->id }}</strong></td>
                            <td>
                                <strong style="color: var(--burgundy-900); font-size: 0.95rem;">
                                    {{ $aboutItem->title }}
                                </strong>
                            </td>
                            <td>
                                @php
                                    $aboutMediaUrl = $aboutItem->getFirstMediaUrl('about_image');
                                @endphp
                                @if($aboutMediaUrl)
                                    <img src="{{ $aboutMediaUrl }}" alt="{{ $aboutItem->title }}" style="height: 36px; width: auto; object-fit: cover; border-radius: 6px; border: 1px solid var(--card-border); padding: 2px; background: #fff;">
                                @else
                                    <span class="text-muted">No picture</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info" title="{{ $aboutItem->sub_title_ina ?? $aboutItem->sub_title_eng }}">
                                    {{ Str::limit($aboutItem->sub_title_ina ?: ($aboutItem->sub_title_eng ?: ($aboutItem->sub_title ?? '-')), 40) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-dark small fw-medium" title="{{ $aboutItem->headline_ina ?? $aboutItem->headline_eng }}">
                                    {{ Str::limit($aboutItem->headline_ina ?: ($aboutItem->headline_eng ?: '-'), 60) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted small">{{ Str::limit(strip_tags((string) $aboutItem->description_eng), 90) }}</span>
                            </td>
                            <td>{{ $aboutItem->user?->name ?? 'System' }}</td>
                            <td>{{ $aboutItem->updated_at->format('d M Y') }}</td>
                            <td class="actions-cell">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <a href="{{ route('admin.about-us.edit', $aboutItem->id) }}" class="btn btn-secondary btn-sm">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- About Card Features (4 Pillars) Table Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div>
                <h2 class="card-heading">About Card Features (4 Pillars)</h2>
                <span style="font-size: 0.775rem; color: var(--text-subtle);">Manage the 4 key feature cards displayed on the visitor About Us section</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-info">{{ $aboutFeatures->count() }} Features</span>
                <a href="{{ route('admin.about-features.create') }}" class="btn btn-primary btn-sm">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Add Feature Card</span>
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="about-features-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order</th>
                        <th scope="col">Title (English)</th>
                        <th scope="col">Title (Indonesian)</th>
                        <th scope="col">Description (English)</th>
                        <th scope="col">Description (Indonesian)</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aboutFeatures as $feature)
                        <tr>
                            <td><strong>#{{ $feature->id }}</strong></td>
                            <td><span class="badge badge-secondary">Pillar {{ $feature->sequence }}</span></td>
                            <td><strong style="color: var(--burgundy-900);">{{ $feature->title_eng }}</strong></td>
                            <td><strong>{{ $feature->title_ina }}</strong></td>
                            <td><span class="text-muted small">{{ Str::limit($feature->description_eng, 65) }}</span></td>
                            <td><span class="text-muted small">{{ Str::limit($feature->description_ina, 65) }}</span></td>
                            <td class="actions-cell">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <a href="{{ route('admin.about-features.edit', $feature->id) }}" class="btn btn-secondary btn-sm">
                                        Edit
                                    </a>
                                    <form
                                        action="{{ route('admin.about-features.destroy', $feature->id) }}"
                                        method="POST"
                                        class="d-inline delete-confirm-form"
                                        data-confirm-title="Delete Feature Card?"
                                        data-confirm-text="Are you sure you want to delete '{{ $feature->title_eng }}'? This action cannot be undone."
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
