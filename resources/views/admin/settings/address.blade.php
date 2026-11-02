@extends('layouts.admin')

@section('title', 'Address Settings')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div>
        <h1 class="h3 fw-bold mb-1" style="color: var(--burgundy-900);">Company Address Settings</h1>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">RV CCTV Bali office, branch, and headquarters location information.</p>
    </div>

    @php
        $addressData = (array) ($settingRecord->content ?? []);
    @endphp

    <!-- Edit Form Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div>
                <h2 class="card-heading">Edit Company Address</h2>
                <span style="font-size: 0.775rem; color: var(--text-subtle);">Update physical store and showroom address details displayed across the website</span>
            </div>
            <span class="badge badge-success">Active Location</span>
        </div>

        <div class="content-card-body">
            <form action="{{ route('admin.settings.address.update', $settingRecord->id) }}" method="POST" class="d-flex flex-column gap-3">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="addressStreetInput" class="form-label">Street Address <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        id="addressStreetInput"
                        name="street"
                        class="form-control @error('street') is-invalid @enderror"
                        value="{{ old('street', $addressData['street'] ?? '') }}"
                        placeholder="e.g., Jl. By Pass Ngurah Rai No. 128"
                        required
                    >
                    @error('street')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="addressCityInput" class="form-label">City / Regency <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="addressCityInput"
                                name="city"
                                class="form-control @error('city') is-invalid @enderror"
                                value="{{ old('city', $addressData['city'] ?? '') }}"
                                placeholder="e.g., Denpasar Selatan"
                                required
                            >
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="addressProvinceInput" class="form-label">Province <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="addressProvinceInput"
                                name="province"
                                class="form-control @error('province') is-invalid @enderror"
                                value="{{ old('province', $addressData['province'] ?? '') }}"
                                placeholder="e.g., Bali"
                                required
                            >
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="addressPostalCodeInput" class="form-label">Postal Code</label>
                            <input
                                type="text"
                                id="addressPostalCodeInput"
                                name="postal_code"
                                class="form-control @error('postal_code') is-invalid @enderror"
                                value="{{ old('postal_code', $addressData['postal_code'] ?? '') }}"
                                placeholder="e.g., 80222"
                            >
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="addressCountryInput" class="form-label">Country <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="addressCountryInput"
                                name="country"
                                class="form-control @error('country') is-invalid @enderror"
                                value="{{ old('country', $addressData['country'] ?? 'Indonesia') }}"
                                placeholder="e.g., Indonesia"
                                required
                            >
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="addressMapsEmbedInput" class="form-label">Google Maps Embed Code (iframe)</label>
                    <textarea
                        id="addressMapsEmbedInput"
                        name="maps_embed"
                        rows="3"
                        class="form-control @error('maps_embed') is-invalid @enderror"
                        placeholder='<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'
                    >{{ old('maps_embed', $addressData['maps_embed'] ?? '') }}</textarea>
                    @error('maps_embed')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted" style="font-size: 0.75rem;">Paste the Google Maps &lt;iframe&gt; embed code. It will be rendered in the visitor website footer.</small>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2">
                    <button type="submit" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        <span>Save Address Settings</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTables Table Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div>
                <h2 class="card-heading">Current Address Overview</h2>
                <span style="font-size: 0.775rem; color: var(--text-subtle);">Address attributes loaded with DataTables</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="address-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">Attribute Key</th>
                        <th scope="col">Current Value</th>
                        <th scope="col">Setting Group</th>
                        <th scope="col">Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Street Address</strong></td>
                        <td>{{ $addressData['street'] ?? '-' }}</td>
                        <td><span class="badge badge-info">Physical Address</span></td>
                        <td>{{ $settingRecord->updated_at ? $settingRecord->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>City / Regency</strong></td>
                        <td>{{ $addressData['city'] ?? '-' }}</td>
                        <td><span class="badge badge-info">Regional</span></td>
                        <td>{{ $settingRecord->updated_at ? $settingRecord->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Province</strong></td>
                        <td>{{ $addressData['province'] ?? '-' }}</td>
                        <td><span class="badge badge-info">Territory</span></td>
                        <td>{{ $settingRecord->updated_at ? $settingRecord->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Postal Code</strong></td>
                        <td>{{ $addressData['postal_code'] ?? '-' }}</td>
                        <td><span class="badge badge-secondary">Postal</span></td>
                        <td>{{ $settingRecord->updated_at ? $settingRecord->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Country</strong></td>
                        <td><strong>{{ $addressData['country'] ?? '-' }}</strong></td>
                        <td><span class="badge badge-success">Nation</span></td>
                        <td>{{ $settingRecord->updated_at ? $settingRecord->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Google Maps Embed</strong></td>
                        <td>
                            @if(!empty($addressData['maps_embed']))
                                <span class="badge badge-success mb-2 d-inline-block">Active Map Embed</span>
                                <div style="max-width: 420px; height: 160px; border-radius: 8px; overflow: hidden; border: 1px solid var(--card-border);" class="admin-maps-preview">
                                    {!! $addressData['maps_embed'] !!}
                                </div>
                            @else
                                <span class="text-muted">Not configured</span>
                            @endif
                        </td>
                        <td><span class="badge badge-info">Map Location</span></td>
                        <td>{{ $settingRecord->updated_at ? $settingRecord->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .admin-maps-preview iframe {
        width: 100% !important;
        height: 100% !important;
        border: 0;
        display: block;
    }
</style>
@endpush
