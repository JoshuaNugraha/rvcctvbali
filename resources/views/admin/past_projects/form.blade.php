@extends('layouts.admin')

@section('title', $isEditMode ? 'Edit Past Project' : 'Add New Past Project')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div class="shell-header">
        <div class="shell-actions">
            <a href="{{ route('admin.past-projects.index') }}" class="btn btn-warning">
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
                <h2 class="card-heading">{{ $isEditMode ? 'Past Project Details (#' . $projectRecord->id . ')' : 'Past Project Information Form' }}</h2>
            </div>
        </div>

        <div class="content-card-body">
            <form action="{{ $isEditMode ? route('admin.past-projects.update', $projectRecord->id) : route('admin.past-projects.store') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-3">
                @csrf
                @if($isEditMode)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="projectTitleInput" class="form-label">Project Title <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="projectTitleInput"
                                name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $projectRecord->title) }}"
                                placeholder="e.g., 8-Channel Hikvision ColorVu Private Villa Installation"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="projectSequenceInput" class="form-label">Sequence</label>
                            <input
                                type="number"
                                id="projectSequenceInput"
                                name="sequence"
                                class="form-control @error('sequence') is-invalid @enderror"
                                value="{{ old('sequence', $projectRecord->sequence ?? 0) }}"
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
                            <label for="projectSubTitleInput" class="form-label">Location / Subtitle</label>
                            <input
                                type="text"
                                id="projectSubTitleInput"
                                name="sub_title"
                                class="form-control @error('sub_title') is-invalid @enderror"
                                value="{{ old('sub_title', $projectRecord->sub_title) }}"
                                placeholder="e.g., Canggu & Seminyak"
                            >
                            @error('sub_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="projectPictureInput" class="form-label">Project Image <span class="text-muted fw-normal">(Optional)</span></label>
                            @php
                                $projectMediaUrl = $isEditMode ? $projectRecord->getFirstMediaUrl('project_image') : '';
                            @endphp
                            @if($isEditMode && $projectMediaUrl)
                                <div class="mb-2 d-flex align-items-center gap-3">
                                    <img src="{{ $projectMediaUrl }}" alt="{{ $projectRecord->title }}" style="height: 48px; width: auto; object-fit: cover; border-radius: 8px; border: 1px solid var(--card-border); padding: 2px; background: #fff;">
                                    <small class="text-muted">Current project image</small>
                                </div>
                            @endif
                            <input
                                type="file"
                                id="projectPictureInput"
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
                    <label for="projectDescriptionEngInput" class="form-label">Description (English)</label>
                    <textarea
                        id="projectDescriptionEngInput"
                        name="description_eng"
                        rows="6"
                        class="form-control tinymce-editor @error('description_eng') is-invalid @enderror"
                        placeholder="Enter project description in English..."
                    >{{ old('description_eng', $projectRecord->description_eng) }}</textarea>
                    @error('description_eng')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="projectDescriptionInaInput" class="form-label">Description (Indonesian)</label>
                    <textarea
                        id="projectDescriptionInaInput"
                        name="description_ina"
                        rows="6"
                        class="form-control tinymce-editor @error('description_ina') is-invalid @enderror"
                        placeholder="Enter project description in Indonesian..."
                    >{{ old('description_ina', $projectRecord->description_ina) }}</textarea>
                    @error('description_ina')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.past-projects.index') }}" class="btn btn-secondary">Cancel</a>
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

