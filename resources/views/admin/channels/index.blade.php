@extends('layouts.admin')

@section('title', 'Channels Management')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div class="shell-header">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: var(--burgundy-900);">DVR/NVR Channels</h1>
        </div>
    </div>

    <!-- DataTables Table Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="shell-actions">
                <a href="{{ route('admin.channels.create') }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Add</span>
                </a>
            </div>
            <span class="badge badge-info">{{ $channelList->count() }} Presets</span>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="channels-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Total Channels</th>
                        <th scope="col">Linked Packages</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Created At</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($channelList as $channel)
                        <tr>
                            <td><strong>#{{ $channel->id }}</strong></td>
                            <td>
                                <span class="badge badge-info" style="font-size: 0.85rem;">
                                    {{ $channel->total_channels }} Channels
                                </span>
                            </td>
                            <td>{{ $channel->packages->count() }} packages</td>
                            <td>{{ $channel->user?->name ?? 'System' }}</td>
                            <td>{{ $channel->created_at->format('d M Y, H:i') }}</td>
                            <td class="actions-cell">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <a href="{{ route('admin.channels.edit', $channel->id) }}" class="btn btn-secondary btn-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.channels.destroy', $channel->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this channel configuration?');">
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
