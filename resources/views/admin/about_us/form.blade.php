@extends('layouts.admin')

@section('title', 'Edit About Us')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div class="shell-header">
        <div class="shell-actions">
            <a href="{{ route('admin.about-us.index') }}" class="btn btn-warning">
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
                <h2 class="card-heading">About Us Details ({{ $aboutRecord->title }})</h2>
            </div>
        </div>

        <div class="content-card-body">
            <form action="{{ route('admin.about-us.update', $aboutRecord->id) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-3">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="aboutTitleInput" class="form-label">Title <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        id="aboutTitleInput"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $aboutRecord->title) }}"
                        placeholder="e.g., RV CCTV Technology Bali — Official Distributor & Integrator"
                        required
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aboutSubTitleEngInput" class="form-label">Subtitle (English)</label>
                            <input
                                type="text"
                                id="aboutSubTitleEngInput"
                                name="sub_title_eng"
                                class="form-control @error('sub_title_eng') is-invalid @enderror"
                                value="{{ old('sub_title_eng', $aboutRecord->sub_title_eng ?: $aboutRecord->sub_title) }}"
                                placeholder="e.g., Serving on-site consultations and surveys across Denpasar, Badung, Gianyar, Tabanan, and surrounding areas in Bali."
                            >
                            @error('sub_title_eng')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" style="font-size: 0.75rem;">Showroom subtitle displayed in English.</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aboutSubTitleInaInput" class="form-label">Subtitle (Indonesian)</label>
                            <input
                                type="text"
                                id="aboutSubTitleInaInput"
                                name="sub_title_ina"
                                class="form-control @error('sub_title_ina') is-invalid @enderror"
                                value="{{ old('sub_title_ina', $aboutRecord->sub_title_ina) }}"
                                placeholder="e.g., Melayani survei dan konsultasi di tempat se-Bali (Denpasar, Badung, Gianyar, Tabanan)."
                            >
                            @error('sub_title_ina')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" style="font-size: 0.75rem;">Showroom subtitle displayed in Indonesian.</small>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aboutHeadlineEngInput" class="form-label">Headline / Section Heading (English)</label>
                            <input
                                type="text"
                                id="aboutHeadlineEngInput"
                                name="headline_eng"
                                class="form-control @error('headline_eng') is-invalid @enderror"
                                value="{{ old('headline_eng', $aboutRecord->headline_eng) }}"
                                placeholder="e.g., Complete Security Solutions in Bali from Consultation to After-Sales Support."
                            >
                            @error('headline_eng')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" style="font-size: 0.75rem;">Displays on the right side of About Us on the visitor page (English).</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aboutHeadlineInaInput" class="form-label">Headline / Section Heading (Indonesian)</label>
                            <input
                                type="text"
                                id="aboutHeadlineInaInput"
                                name="headline_ina"
                                class="form-control @error('headline_ina') is-invalid @enderror"
                                value="{{ old('headline_ina', $aboutRecord->headline_ina) }}"
                                placeholder="e.g., Solusi Keamanan CCTV Terlengkap di Bali dari Konsultasi hingga Garansi Purnajual."
                            >
                            @error('headline_ina')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" style="font-size: 0.75rem;">Displays on the right side of About Us on the visitor page (Indonesian).</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="aboutPictureInput" class="form-label">About Us / Showroom Image <span class="text-muted fw-normal">(Optional)</span></label>
                    @php
                        $aboutMediaUrl = $isEditMode ? $aboutRecord->getFirstMediaUrl('about_image') : '';
                    @endphp
                    @if($isEditMode && $aboutMediaUrl)
                        <div class="mb-2 d-flex align-items-center gap-3">
                            <img src="{{ $aboutMediaUrl }}" alt="{{ $aboutRecord->title }}" style="height: 48px; width: auto; object-fit: cover; border-radius: 8px; border: 1px solid var(--card-border); padding: 2px; background: #fff;">
                            <small class="text-muted">Current image</small>
                        </div>
                    @endif
                    <input
                        type="file"
                        id="aboutPictureInput"
                        name="picture"
                        class="form-control @error('picture') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp,.svg"
                    >
                    @error('picture')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted" style="font-size: 0.75rem;">JPG, PNG, WEBP, SVG (Max 2MB).</small>
                </div>

                <div class="form-group">
                    <label for="aboutDescriptionEngInput" class="form-label">Description (English)</label>
                    <textarea
                        id="aboutDescriptionEngInput"
                        name="description_eng"
                        rows="6"
                        class="form-control tinymce-editor @error('description_eng') is-invalid @enderror"
                        placeholder="Enter About Us description in English..."
                    >{{ old('description_eng', $aboutRecord->description_eng) }}</textarea>
                    @error('description_eng')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="aboutDescriptionInaInput" class="form-label">Description (Indonesian)</label>
                    <textarea
                        id="aboutDescriptionInaInput"
                        name="description_ina"
                        rows="6"
                        class="form-control tinymce-editor @error('description_ina') is-invalid @enderror"
                        placeholder="Enter About Us description in Indonesian..."
                    >{{ old('description_ina', $aboutRecord->description_ina) }}</textarea>
                    @error('description_ina')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                @if($aboutRecord->features && $aboutRecord->features->count() > 0)
                    <!-- 4 Feature Cards Section -->
                    <div class="pt-4 mt-2 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h3 class="h6 fw-bold mb-1" style="color: var(--burgundy-900);">About Card Features (4 Pillars)</h3>
                                <p class="text-muted small mb-0">Manage the 4 key feature cards displayed on the visitor page (English &amp; Indonesian).</p>
                            </div>
                            <span class="badge badge-info">{{ $aboutRecord->features->count() }} Cards</span>
                        </div>

                        <div class="row g-3">
                            @foreach($aboutRecord->features as $idx => $feat)
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 bg-light d-flex flex-column gap-2" style="border-color: var(--card-border) !important;">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <strong style="color: var(--burgundy-900);">Feature Card #{{ $feat->sequence ?? ($idx + 1) }}</strong>
                                            <span class="badge badge-secondary">Pillar {{ $feat->sequence }}</span>
                                        </div>

                                        <input type="hidden" name="features[{{ $feat->id }}][sequence]" value="{{ $feat->sequence }}">

                                        <div class="form-group">
                                            <label class="form-label small fw-semibold">Title (English) <span class="text-danger">*</span></label>
                                            <input
                                                type="text"
                                                name="features[{{ $feat->id }}][title_eng]"
                                                class="form-control form-control-sm"
                                                value="{{ old('features.'.$feat->id.'.title_eng', $feat->title_eng) }}"
                                                required
                                            >
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label small fw-semibold">Title (Indonesian) <span class="text-danger">*</span></label>
                                            <input
                                                type="text"
                                                name="features[{{ $feat->id }}][title_ina]"
                                                class="form-control form-control-sm"
                                                value="{{ old('features.'.$feat->id.'.title_ina', $feat->title_ina) }}"
                                                required
                                            >
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label small fw-semibold">Description (English) <span class="text-danger">*</span></label>
                                            <textarea
                                                name="features[{{ $feat->id }}][description_eng]"
                                                rows="2"
                                                class="form-control form-control-sm"
                                                required
                                            >{{ old('features.'.$feat->id.'.description_eng', $feat->description_eng) }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label small fw-semibold">Description (Indonesian) <span class="text-danger">*</span></label>
                                            <textarea
                                                name="features[{{ $feat->id }}][description_ina]"
                                                rows="2"
                                                class="form-control form-control-sm"
                                                required
                                            >{{ old('features.'.$feat->id.'.description_ina', $feat->description_ina) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.about-us.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        Update
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

