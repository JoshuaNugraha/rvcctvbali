@extends('layouts.admin')

@section('title', 'Phone Number Settings')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div>
        <h1 class="h3 fw-bold mb-1" style="color: var(--burgundy-900);">Phone & WhatsApp Settings</h1>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">Official customer hotline, WhatsApp instant consultation, and contact line.</p>
    </div>

    @php
        $phoneData = (array) ($settingRecord->content ?? []);
        $currentPhone = $phoneData['phone_number'] ?? '';
        $rawDigits = preg_replace('/[^0-9]/', '', $currentPhone);
    @endphp

    <!-- Edit Form Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div>
                <h2 class="card-heading">Edit Official Contact Phone Number</h2>
                <span style="font-size: 0.775rem; color: var(--text-subtle);">Single contact line used across the entire website for visitor calls and WhatsApp chats</span>
            </div>
            <span class="badge badge-success">Online Contact Line</span>
        </div>

        <div class="content-card-body">
            <form action="{{ route('admin.settings.phone-number.update', $settingRecord->id) }}" method="POST" class="d-flex flex-column gap-3">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="phoneNumberInput" class="form-label">Phone / WhatsApp Number <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        id="phoneNumberInput"
                        name="phone_number"
                        class="form-control @error('phone_number') is-invalid @enderror"
                        value="{{ old('phone_number', $currentPhone) }}"
                        placeholder="e.g., +62 878-5513-0070"
                        required
                    >
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted" style="font-size: 0.75rem;">
                        This single contact number is used across the entire website (header WhatsApp badge, package inquiry buttons, floating WhatsApp button, and footer). Include country code prefix (e.g., +62).
                    </small>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2">
                    <button type="submit" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        <span>Save Phone Number</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTables Table Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div>
                <h2 class="card-heading">Contact Line Overview</h2>
                <span style="font-size: 0.775rem; color: var(--text-subtle);">Active contact channel details</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="phones-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">Contact Channel</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">WhatsApp Direct Link</th>
                        <th scope="col">Status</th>
                        <th scope="col">Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Official Hotline & WhatsApp</strong></td>
                        <td>
                            <strong style="color: var(--burgundy-900);">{{ $currentPhone ?: '-' }}</strong>
                        </td>
                        <td>
                            @if(!empty($rawDigits))
                                <a href="https://wa.me/{{ $rawDigits }}" target="_blank" rel="noopener" class="btn btn-secondary btn-sm py-1 px-2">
                                    wa.me/{{ $rawDigits }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td><span class="badge badge-success">Active Primary Line</span></td>
                        <td>{{ $settingRecord->updated_at ? $settingRecord->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
