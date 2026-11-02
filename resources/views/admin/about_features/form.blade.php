@extends('layouts.admin')

@section('title', $isEditMode ? 'Edit About Feature Card' : 'Add New About Feature Card')

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
                <span>Back to About Us</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div>
                <h2 class="card-heading">{{ $isEditMode ? 'About Feature Card Details (#' . $featureRecord->id . ')' : 'New About Feature Card Form' }}</h2>
                <span style="font-size: 0.775rem; color: var(--text-subtle);">Configure feature pillar displayed in the 4-card grid on About Us section</span>
            </div>
            <span class="badge badge-info">Pillar #{{ $featureRecord->sequence ?? 'New' }}</span>
        </div>

        <div class="content-card-body">
            <form action="{{ $isEditMode ? route('admin.about-features.update', $featureRecord->id) : route('admin.about-features.store') }}" method="POST" class="d-flex flex-column gap-3">
                @csrf
                @if($isEditMode)
                    @method('PUT')
                @endif

                <input type="hidden" name="about_us_id" value="{{ $featureRecord->about_us_id }}">

                <div class="form-group" style="max-width: 200px;">
                    <label for="featureSequenceInput" class="form-label">Sequence / Order <span class="text-danger">*</span></label>
                    <input
                        type="number"
                        id="featureSequenceInput"
                        name="sequence"
                        class="form-control @error('sequence') is-invalid @enderror"
                        value="{{ old('sequence', $featureRecord->sequence ?? 1) }}"
                        min="1"
                        max="99"
                        required
                    >
                    @error('sequence')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted" style="font-size: 0.75rem;">Display position (1 to 4).</small>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="featureTitleEngInput" class="form-label">Title (English) <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="featureTitleEngInput"
                                name="title_eng"
                                class="form-control @error('title_eng') is-invalid @enderror"
                                value="{{ old('title_eng', $featureRecord->title_eng) }}"
                                placeholder="e.g., 2-Year Official Warranty"
                                required
                            >
                            @error('title_eng')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="featureTitleInaInput" class="form-label">Title (Indonesian) <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="featureTitleInaInput"
                                name="title_ina"
                                class="form-control @error('title_ina') is-invalid @enderror"
                                value="{{ old('title_ina', $featureRecord->title_ina) }}"
                                placeholder="e.g., Garansi Resmi 2 Tahun"
                                required
                            >
                            @error('title_ina')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="featureDescEngInput" class="form-label">Description (English) <span class="text-danger">*</span></label>
                            <textarea
                                id="featureDescEngInput"
                                name="description_eng"
                                rows="4"
                                class="form-control @error('description_eng') is-invalid @enderror"
                                placeholder="e.g., 100% original units from authorized distributors with warranty claims in Bali."
                                required
                            >{{ old('description_eng', $featureRecord->description_eng) }}</textarea>
                            @error('description_eng')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="featureDescInaInput" class="form-label">Description (Indonesian) <span class="text-danger">*</span></label>
                            <textarea
                                id="featureDescInaInput"
                                name="description_ina"
                                rows="4"
                                class="form-control @error('description_ina') is-invalid @enderror"
                                placeholder="e.g., 100% unit original dari distributor resmi dengan klaim garansi mudah di Bali."
                                required
                            >{{ old('description_ina', $featureRecord->description_ina) }}</textarea>
                            @error('description_ina')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.about-us.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $isEditMode ? 'Update Feature' : 'Save Feature' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

