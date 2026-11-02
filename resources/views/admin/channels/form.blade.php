@extends('layouts.admin')

@section('title', $isEditMode ? 'Edit Channel Configuration' : 'Add New Channel Configuration')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div class="shell-header">
        <div class="shell-actions">
            <a href="{{ route('admin.channels.index') }}" class="btn btn-warning">
                <svg viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div>
                <h2 class="card-heading">{{ $isEditMode ? 'Channel Details (#' . $channelRecord->id . ')' : 'Channel Configuration Form' }}</h2>
            </div>
        </div>

        <div class="content-card-body">
            <form action="{{ $isEditMode ? route('admin.channels.update', $channelRecord->id) : route('admin.channels.store') }}" method="POST" class="d-flex flex-column gap-3">
                @csrf
                @if($isEditMode)
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="totalChannelsInput" class="form-label">Total Channels <span class="text-danger">*</span></label>
                    <input
                        type="number"
                        id="totalChannelsInput"
                        name="total_channels"
                        class="form-control @error('total_channels') is-invalid @enderror"
                        value="{{ old('total_channels', $channelRecord->total_channels) }}"
                        min="1"
                        max="128"
                        placeholder="e.g., 4, 8, 16, 32"
                        required
                    >
                    @error('total_channels')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted" style="font-size: 0.75rem;">Enter a unique channel capacity between 1 and 128.</small>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.channels.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $isEditMode ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
