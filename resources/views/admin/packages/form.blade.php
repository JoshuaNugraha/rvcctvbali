@extends('layouts.admin')

@section('title', $isEditMode ? 'Edit Package' : 'Add New Package')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div class="shell-header">
        <div class="shell-actions">
            <a href="{{ route('admin.packages.index') }}" class="btn btn-warning">
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
                <h2 class="card-heading">{{ $isEditMode ? 'Package Details (#' . $packageRecord->id . ')' : 'Package Information Form' }}</h2>
            </div>
        </div>

        <div class="content-card-body">
            <form action="{{ $isEditMode ? route('admin.packages.update', $packageRecord->id) : route('admin.packages.store') }}" method="POST" class="d-flex flex-column gap-3">
                @csrf
                @if($isEditMode)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="packageNameInput" class="form-label">Package Name <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="packageNameInput"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $packageRecord->name) }}"
                                placeholder="e.g., 4-Camera Analog Package"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="packageSequenceInput" class="form-label">Sequence</label>
                            <input
                                type="number"
                                id="packageSequenceInput"
                                name="sequence"
                                class="form-control @error('sequence') is-invalid @enderror"
                                value="{{ old('sequence', $packageRecord->sequence ?? 0) }}"
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
                            <label for="packageChannelSelect" class="form-label">Channel Configuration</label>
                            <select
                                id="packageChannelSelect"
                                name="channel_id"
                                class="form-select select2 @error('channel_id') is-invalid @enderror"
                                data-placeholder="-- Select Channel --"
                            >
                                <option value="">-- Select Channel --</option>
                                @foreach($channelList as $channelItem)
                                    <option
                                        value="{{ $channelItem->id }}"
                                        {{ (string) old('channel_id', $packageRecord->channel_id) === (string) $channelItem->id ? 'selected' : '' }}
                                    >
                                        {{ $channelItem->total_channels }} Channels
                                    </option>
                                @endforeach
                            </select>
                            @error('channel_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="packagePriceInput" class="form-label">Price (Rp) <span class="text-danger">*</span></label>
                            <input
                                type="number"
                                step="any"
                                id="packagePriceInput"
                                name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $packageRecord->price) }}"
                                min="0"
                                placeholder="e.g., 3600000"
                                required
                            >
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="packageBrandsSelect" class="form-label">Supported Brands</label>
                    @php
                        $selectedBrands = old('brands', is_array($packageRecord->brands) ? $packageRecord->brands : []);
                    @endphp
                    <select
                        id="packageBrandsSelect"
                        name="brands[]"
                        class="form-select select2 @error('brands') is-invalid @enderror"
                        multiple="multiple"
                        data-placeholder="Select supported brands..."
                    >
                        @foreach($brandList as $brandItem)
                            <option
                                value="{{ $brandItem->name }}"
                                {{ in_array($brandItem->name, $selectedBrands, true) ? 'selected' : '' }}
                            >
                                {{ $brandItem->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brands')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Package Specification List (pkg-spec-list) -->
                <div class="pt-2 border-top">
                    <h3 class="h6 fw-bold mb-3" style="color: var(--burgundy-900);">Package Specifications (Inclusions List)</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="packageCamerasInput" class="form-label">Cameras</label>
                                <input
                                    type="text"
                                    id="packageCamerasInput"
                                    name="cameras"
                                    class="form-control @error('cameras') is-invalid @enderror"
                                    value="{{ old('cameras', $packageRecord->cameras) }}"
                                    placeholder="e.g., 4 Units (Outdoor / Indoor)"
                                >
                                @error('cameras')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="packageRecorderUnitInput" class="form-label">Recorder Unit</label>
                                <input
                                    type="text"
                                    id="packageRecorderUnitInput"
                                    name="recorder_unit"
                                    class="form-control @error('recorder_unit') is-invalid @enderror"
                                    value="{{ old('recorder_unit', $packageRecord->recorder_unit) }}"
                                    placeholder="e.g., 4-Channel DVR"
                                >
                                @error('recorder_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="packageStorageInput" class="form-label">Storage</label>
                                <input
                                    type="text"
                                    id="packageStorageInput"
                                    name="storage"
                                    class="form-control @error('storage') is-invalid @enderror"
                                    value="{{ old('storage', $packageRecord->storage) }}"
                                    placeholder="e.g., 500GB Surveillance Hard Drive"
                                >
                                @error('storage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="packagePowerConnectorsInput" class="form-label">Power &amp; Connectors</label>
                                <input
                                    type="text"
                                    id="packagePowerConnectorsInput"
                                    name="power_connectors"
                                    class="form-control @error('power_connectors') is-invalid @enderror"
                                    value="{{ old('power_connectors', $packageRecord->power_connectors) }}"
                                    placeholder="e.g., Adapter/PSU + BNC + DC Jacks"
                                >
                                @error('power_connectors')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="packageCableInput" class="form-label">RG59+P Cable</label>
                                <input
                                    type="text"
                                    id="packageCableInput"
                                    name="cable"
                                    class="form-control @error('cable') is-invalid @enderror"
                                    value="{{ old('cable', $packageRecord->cable) }}"
                                    placeholder="e.g., Free 40 Meters (10M / Camera)"
                                >
                                @error('cable')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="packageServiceInput" class="form-label">Service</label>
                                <input
                                    type="text"
                                    id="packageServiceInput"
                                    name="service"
                                    class="form-control @error('service') is-invalid @enderror"
                                    value="{{ old('service', $packageRecord->service) }}"
                                    placeholder="e.g., Free Installation & Online Setup"
                                >
                                @error('service')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="packageDescriptionEngInput" class="form-label">Description (English)</label>
                    <textarea
                        id="packageDescriptionEngInput"
                        name="description_eng"
                        rows="6"
                        class="form-control tinymce-editor @error('description_eng') is-invalid @enderror"
                        placeholder="Enter package description in English..."
                    >{{ old('description_eng', $packageRecord->description_eng) }}</textarea>
                    @error('description_eng')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="packageDescriptionInaInput" class="form-label">Description (Indonesian)</label>
                    <textarea
                        id="packageDescriptionInaInput"
                        name="description_ina"
                        rows="6"
                        class="form-control tinymce-editor @error('description_ina') is-invalid @enderror"
                        placeholder="Enter package description in Indonesian..."
                    >{{ old('description_ina', $packageRecord->description_ina) }}</textarea>
                    @error('description_ina')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">Cancel</a>
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
