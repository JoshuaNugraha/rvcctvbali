@extends('layouts.admin')

@section('title', 'Brands Management')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div class="shell-header">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: var(--burgundy-900);">CCTV Brands</h1>
        </div>
    </div>

    <!-- DataTables Table Card -->
    <div class="content-card">
        <div class="content-card-header">
           <div class="shell-actions">
            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Add</span>
            </a>
        </div>
            <span class="badge badge-info">{{ $brandList->count() }} Brands</span>
        </div>
         

        <div class="table-responsive">
            <table class="data-table" id="brands-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Brand Name</th>
                        <th scope="col">Picture / Logo</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Created At</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brandList as $brand)
                        <tr>
                            <td><strong>#{{ $brand->id }}</strong></td>
                            <td>
                                <span class="fw-bold" style="color: var(--burgundy-900); font-size: 0.95rem;">
                                    {{ $brand->name }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $brandMediaUrl = $brand->getFirstMediaUrl('brand_logo');
                                @endphp
                                @if($brandMediaUrl)
                                    <img src="{{ $brandMediaUrl }}" alt="{{ $brand->name }}" style="height: 32px; width: auto; object-fit: contain; border-radius: 6px; border: 1px solid var(--card-border); padding: 2px; background: #fff;">
                                @elseif($brand->picture)
                                    @if(str_starts_with($brand->picture, 'uploads/') && file_exists(public_path($brand->picture)))
                                        <img src="{{ asset($brand->picture) }}" alt="{{ $brand->name }}" style="height: 32px; width: auto; object-fit: contain; border-radius: 6px; border: 1px solid var(--card-border); padding: 2px; background: #fff;">
                                    @else
                                        <span class="badge badge-info">{{ $brand->picture }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">No picture</span>
                                @endif
                            </td>
                            <td>{{ $brand->user?->name ?? 'System' }}</td>
                            <td>{{ $brand->created_at->format('d M Y, H:i') }}</td>
                            <td class="actions-cell">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-secondary btn-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this brand?');">
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
