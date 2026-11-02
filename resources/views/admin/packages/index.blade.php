@extends('layouts.admin')

@section('title', 'Packages Management')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div class="shell-header">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: var(--burgundy-900);">Security Packages</h1>
        </div>
    </div>

    <!-- DataTables Table Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="shell-actions">
                <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Add</span>
                </a>
            </div>
            <span class="badge badge-info">{{ $packageList->count() }} Packages</span>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="packages-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">Seq</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Channels</th>
                        <th scope="col">Brands</th>
                        <th scope="col">Price</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Created At</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packageList as $package)
                        <tr>
                            <td><strong>#{{ $package->sequence }}</strong></td>
                            <td>
                                <div class="fw-bold" style="color: var(--burgundy-900); font-size: 0.95rem;">
                                    {{ $package->name }}
                                </div>
                                <div class="text-muted small">{{ Str::limit(strip_tags((string) $package->description_eng), 75) }}</div>
                                <code class="small text-muted">{{ $package->slug }}</code>
                            </td>
                            <td>
                                @if($package->channel)
                                    <span class="badge badge-info">{{ $package->channel->total_channels }} Channels</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if(is_array($package->brands) && count($package->brands) > 0)
                                    @foreach($package->brands as $brandItem)
                                        <span class="badge badge-info me-1">{{ $brandItem }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <strong>Rp {{ number_format($package->price, 0, ',', '.') }}</strong>
                            </td>
                            <td>{{ $package->user?->name ?? 'System' }}</td>
                            <td>{{ $package->created_at->format('d M Y') }}</td>
                            <td class="actions-cell">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-secondary btn-sm">
                                        Edit
                                    </a>
                                    <form
                                        action="{{ route('admin.packages.destroy', $package->id) }}"
                                        method="POST"
                                        class="d-inline delete-confirm-form"
                                        data-confirm-title="Delete Package?"
                                        data-confirm-text="Are you sure you want to delete '{{ $package->name }}'? This action cannot be undone."
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
