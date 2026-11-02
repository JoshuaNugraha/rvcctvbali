@extends('layouts.admin')

@section('title', $isEditMode ? 'Edit Brand' : 'Add New Brand')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div class="shell-header">
         <div class="shell-actions">
            <a href="{{ route('admin.brands.index') }}" class="btn btn-warning">
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
                <h2 class="card-heading">{{ $isEditMode ? 'Brand Details (#' . $brandRecord->id . ')' : 'Brand Information Form' }}</h2>
            </div>
        </div>

        <div class="content-card-body">
            <form action="{{ $isEditMode ? route('admin.brands.update', $brandRecord->id) : route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-3">
                @csrf
                @if($isEditMode)
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="brandNameInput" class="form-label">Brand Name <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        id="brandNameInput"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $brandRecord->name) }}"
                        placeholder="e.g., Hikvision, Dahua, HiLook"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="brandPictureInput" class="form-label">Brand Logo / Picture <span class="text-muted fw-normal">(Optional)</span></label>
                    @php
                        $brandMediaUrl = $isEditMode ? $brandRecord->getFirstMediaUrl('brand_logo') : '';
                    @endphp
                    @if($isEditMode && ($brandMediaUrl || $brandRecord->picture))
                        <div class="mb-2 d-flex align-items-center gap-3">
                            @if($brandMediaUrl)
                                <img src="{{ $brandMediaUrl }}" alt="{{ $brandRecord->name }}" style="height: 44px; width: auto; object-fit: contain; border-radius: 8px; border: 1px solid var(--card-border); padding: 4px; background: #fff;">
                            @elseif(str_starts_with((string) $brandRecord->picture, 'uploads/') && file_exists(public_path($brandRecord->picture)))
                                <img src="{{ asset($brandRecord->picture) }}" alt="{{ $brandRecord->name }}" style="height: 44px; width: auto; object-fit: contain; border-radius: 8px; border: 1px solid var(--card-border); padding: 4px; background: #fff;">
                            @else
                                <span class="badge badge-info">{{ $brandRecord->picture }}</span>
                            @endif
                            <small class="text-muted">Current picture</small>
                        </div>
                    @endif
                    <input
                        type="file"
                        id="brandPictureInput"
                        name="picture"
                        class="form-control @error('picture') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp,.svg"
                    >
                    @error('picture')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted" style="font-size: 0.75rem;">JPG, PNG, WEBP, SVG (Max 2MB).</small>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $isEditMode ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
