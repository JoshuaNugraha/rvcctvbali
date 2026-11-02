@extends('layouts.admin')

@section('title', 'Social Media Settings')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header Section -->
    <div>
        <h1 class="h3 fw-bold mb-1" style="color: var(--burgundy-900);">Social Media Channels</h1>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">RV CCTV Bali public social profiles, video portfolios, and branding links.</p>
    </div>

    @php
        $socialData = (array) ($settingRecord->content ?? []);
    @endphp

    <!-- Edit Form Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div>
                <h2 class="card-heading">Edit Social Media Profiles</h2>
                <span style="font-size: 0.775rem; color: var(--text-subtle);">Configure official URLs linked from the website footer and social badges</span>
            </div>
            <span class="badge badge-success">Connected Channels</span>
        </div>

        <div class="content-card-body">
            <form action="{{ route('admin.settings.social-media.update', $settingRecord->id) }}" method="POST" class="d-flex flex-column gap-3">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="socialInstagramInput" class="form-label">Instagram Profile URL</label>
                            <input
                                type="url"
                                id="socialInstagramInput"
                                name="instagram"
                                class="form-control @error('instagram') is-invalid @enderror"
                                value="{{ old('instagram', $socialData['instagram'] ?? '') }}"
                                placeholder="https://instagram.com/rvcctvbali"
                            >
                            @error('instagram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="socialFacebookInput" class="form-label">Facebook Page URL</label>
                            <input
                                type="url"
                                id="socialFacebookInput"
                                name="facebook"
                                class="form-control @error('facebook') is-invalid @enderror"
                                value="{{ old('facebook', $socialData['facebook'] ?? '') }}"
                                placeholder="https://facebook.com/rvcctvbali"
                            >
                            @error('facebook')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="socialYoutubeInput" class="form-label">YouTube Channel URL</label>
                            <input
                                type="url"
                                id="socialYoutubeInput"
                                name="youtube"
                                class="form-control @error('youtube') is-invalid @enderror"
                                value="{{ old('youtube', $socialData['youtube'] ?? '') }}"
                                placeholder="https://youtube.com/@rvcctvbali"
                            >
                            @error('youtube')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="socialTiktokInput" class="form-label">TikTok Profile URL</label>
                            <input
                                type="url"
                                id="socialTiktokInput"
                                name="tiktok"
                                class="form-control @error('tiktok') is-invalid @enderror"
                                value="{{ old('tiktok', $socialData['tiktok'] ?? '') }}"
                                placeholder="https://tiktok.com/@rvcctvbali"
                            >
                            @error('tiktok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2">
                    <button type="submit" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        <span>Save Social Media Links</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTables Table Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div>
                <h2 class="card-heading">Social Media Profiles Overview</h2>
                <span style="font-size: 0.775rem; color: var(--text-subtle);">Profiles managed with live target preview</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="social-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">Platform</th>
                        <th scope="col">Profile URL</th>
                        <th scope="col">Target Preview</th>
                        <th scope="col">Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Instagram</strong></td>
                        <td><code>{{ $socialData['instagram'] ?? '-' }}</code></td>
                        <td>
                            @if(!empty($socialData['instagram']))
                                <a href="{{ $socialData['instagram'] }}" target="_blank" rel="noopener" class="btn btn-secondary btn-sm py-1 px-2">Open Link</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $settingRecord->updated_at ? $settingRecord->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Facebook Page</strong></td>
                        <td><code>{{ $socialData['facebook'] ?? '-' }}</code></td>
                        <td>
                            @if(!empty($socialData['facebook']))
                                <a href="{{ $socialData['facebook'] }}" target="_blank" rel="noopener" class="btn btn-secondary btn-sm py-1 px-2">Open Link</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $settingRecord->updated_at ? $settingRecord->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>YouTube Channel</strong></td>
                        <td><code>{{ $socialData['youtube'] ?? '-' }}</code></td>
                        <td>
                            @if(!empty($socialData['youtube']))
                                <a href="{{ $socialData['youtube'] }}" target="_blank" rel="noopener" class="btn btn-secondary btn-sm py-1 px-2">Open Link</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $settingRecord->updated_at ? $settingRecord->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>TikTok Official</strong></td>
                        <td><code>{{ $socialData['tiktok'] ?? '-' }}</code></td>
                        <td>
                            @if(!empty($socialData['tiktok']))
                                <a href="{{ $socialData['tiktok'] }}" target="_blank" rel="noopener" class="btn btn-secondary btn-sm py-1 px-2">Open Link</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $settingRecord->updated_at ? $settingRecord->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
