@extends('layouts.admin')

@section('title', $isEditMode ? 'Edit Promotion' : 'Add New Promotion')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div class="shell-header">
        <div class="shell-actions">
            <a href="{{ route('admin.promotions.index') }}" class="btn btn-warning">
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
                <h2 class="card-heading">{{ $isEditMode ? 'Promotion Details (#' . $promotionRecord->id . ')' : 'Promotion Information Form' }}</h2>
            </div>
        </div>

        <div class="content-card-body">
            <form action="{{ $isEditMode ? route('admin.promotions.update', $promotionRecord->id) : route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-3">
                @csrf
                @if($isEditMode)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="promotionNameInput" class="form-label">Promotion Name <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="promotionNameInput"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $promotionRecord->name) }}"
                                placeholder="e.g., Bali Villa Security Year-End Special Discount"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="promotionSequenceInput" class="form-label">Sequence</label>
                            <input
                                type="number"
                                id="promotionSequenceInput"
                                name="sequence"
                                class="form-control @error('sequence') is-invalid @enderror"
                                value="{{ old('sequence', $promotionRecord->sequence ?? 0) }}"
                                min="0"
                                placeholder="0"
                            >
                            @error('sequence')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="promotionPriceInput" class="form-label">Promotional Price (Rp) <span class="text-danger">*</span></label>
                            <input
                                type="number"
                                step="any"
                                id="promotionPriceInput"
                                name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $promotionRecord->price) }}"
                                min="0"
                                placeholder="e.g., 2450000"
                                required
                            >
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="promotionPictureInput" class="form-label">Promotion Image <span class="text-muted fw-normal">(Optional)</span></label>
                            @php
                                $promotionMediaUrl = $isEditMode ? $promotionRecord->getFirstMediaUrl('promotion_image') : '';
                            @endphp
                            @if($isEditMode && $promotionMediaUrl)
                                <div class="mb-2 d-flex align-items-center gap-3">
                                    <img src="{{ $promotionMediaUrl }}" alt="{{ $promotionRecord->name }}" style="height: 48px; width: auto; object-fit: cover; border-radius: 8px; border: 1px solid var(--card-border); padding: 2px; background: #fff;">
                                    <small class="text-muted">Current promotion image</small>
                                </div>
                            @endif
                            <input
                                type="file"
                                id="promotionPictureInput"
                                name="picture"
                                class="form-control @error('picture') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png,.webp,.svg"
                            >
                            @error('picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" style="font-size: 0.75rem;">JPG, PNG, WEBP, SVG (Max 2MB).</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="promotionDescriptionEngInput" class="form-label">Description (English)</label>
                    <textarea
                        id="promotionDescriptionEngInput"
                        name="description_eng"
                        rows="6"
                        class="form-control tinymce-editor @error('description_eng') is-invalid @enderror"
                        placeholder="Enter promotional details in English..."
                    >{{ old('description_eng', $promotionRecord->description_eng) }}</textarea>
                    @error('description_eng')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="promotionDescriptionInaInput" class="form-label">Description (Indonesian)</label>
                    <textarea
                        id="promotionDescriptionInaInput"
                        name="description_ina"
                        rows="6"
                        class="form-control tinymce-editor @error('description_ina') is-invalid @enderror"
                        placeholder="Enter promotional details in Indonesian..."
                    >{{ old('description_ina', $promotionRecord->description_ina) }}</textarea>
                    @error('description_ina')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $isEditMode ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof window.tinymce !== 'undefined' && window.tinymce.editors.length === 0) {
            window.tinymce.init({
                selector: 'textarea.tinymce-editor',
                base_url: '{{ asset("js/tinymce") }}',
                suffix: '.min',
                license_key: 'gpl',
                height: 280,
                menubar: false,
                branding: false,
                promotion: false,
                plugins: 'lists link table code wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link table | removeformat code',
                setup: function (editorInstance) {
                    editorInstance.on('change input undo redo', function () {
                        editorInstance.save();
                    });
                }
            });
        }
    });
</script>
@endpush
