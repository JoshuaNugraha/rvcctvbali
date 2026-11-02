@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Welcome Hero Card with Visitor Analytics -->
    <div class="welcome-card d-block">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <h1 class="welcome-title mb-1">Statistik Pengunjung Website</h1>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="badge py-2 px-3 rounded-pill text-white" style="background-color: var(--burgundy-900); font-size: 0.75rem; font-weight: 600;">
                    Total: {{ number_format($totalVisitors) }}
                </span>
            </div>
        </div>

        <div class="row g-3">
            <!-- Per Hari -->
            <div class="col-12 col-md-4">
                <div class="bg-white p-3 rounded-3 border h-100 shadow-sm" style="border-color: #F5CCD5 !important;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--burgundy-700); letter-spacing: 0.04em;">Per Hari (Hari Ini)</span>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #FFF5F7; color: var(--burgundy-900);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <span style="font-size: 2rem; font-weight: 800; color: #1E293B; line-height: 1;">{{ number_format($visitorsToday) }}</span>
                        <span style="font-size: 0.825rem; font-weight: 600; color: #64748B;">Pengunjung</span>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex align-items-center justify-content-between" style="border-color: #F1F5F9 !important; font-size: 0.75rem; color: #64748B;">
                        <span>Hari ini</span>
                        <span class="fw-semibold text-dark">{{ now()->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Per Minggu -->
            <div class="col-12 col-md-4">
                <div class="bg-white p-3 rounded-3 border h-100 shadow-sm" style="border-color: #F5CCD5 !important;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--burgundy-700); letter-spacing: 0.04em;">Per Minggu (Pekan Ini)</span>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #FFF5F7; color: var(--burgundy-900);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <span style="font-size: 2rem; font-weight: 800; color: #1E293B; line-height: 1;">{{ number_format($visitorsThisWeek) }}</span>
                        <span style="font-size: 0.825rem; font-weight: 600; color: #64748B;">Pengunjung</span>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex align-items-center justify-content-between" style="border-color: #F1F5F9 !important; font-size: 0.75rem; color: #64748B;">
                        <span>Pekan berjalan</span>
                        <span class="fw-semibold text-dark">{{ now()->startOfWeek()->translatedFormat('d M') }} - {{ now()->endOfWeek()->translatedFormat('d M') }}</span>
                    </div>
                </div>
            </div>

            <!-- Per Bulan -->
            <div class="col-12 col-md-4">
                <div class="bg-white p-3 rounded-3 border h-100 shadow-sm" style="border-color: #F5CCD5 !important;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--burgundy-700); letter-spacing: 0.04em;">Per Bulan (Bulan Ini)</span>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #FFF5F7; color: var(--burgundy-900);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <span style="font-size: 2rem; font-weight: 800; color: #1E293B; line-height: 1;">{{ number_format($visitorsThisMonth) }}</span>
                        <span style="font-size: 0.825rem; font-weight: 600; color: #64748B;">Pengunjung</span>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex align-items-center justify-content-between" style="border-color: #F1F5F9 !important; font-size: 0.75rem; color: #64748B;">
                        <span>Bulan berjalan</span>
                        <span class="fw-semibold text-dark">{{ now()->translatedFormat('F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Metric Cards -->
    <div class="row g-3">
        <div class="col-12 col-sm-6 col-xl">
            <div class="stat-metric-card h-100">
                <span class="stat-metric-label">Channel Presets</span>
                <span class="stat-metric-value">{{ $totalChannels }} Presets</span>
                <span class="stat-metric-hint">DVR/NVR capacities</span>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl">
            <div class="stat-metric-card h-100">
                <span class="stat-metric-label">Supported Brands</span>
                <span class="stat-metric-value">{{ $totalBrands }} Brands</span>
                <span class="stat-metric-hint">Official CCTV manufacturers</span>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl">
            <div class="stat-metric-card h-100">
                <span class="stat-metric-label">Security Packages</span>
                <span class="stat-metric-value">{{ $totalPackages }} Packages</span>
                <span class="stat-metric-hint">Active catalog offerings</span>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl">
            <div class="stat-metric-card h-100">
                <span class="stat-metric-label">Active Promotions</span>
                <span class="stat-metric-value">{{ $totalPromotions }} Deals</span>
                <span class="stat-metric-hint">Marketing discounts</span>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl">
            <div class="stat-metric-card h-100">
                <span class="stat-metric-label">Past Projects</span>
                <span class="stat-metric-value">{{ $totalProjects }} Portfolio</span>
                <span class="stat-metric-hint">Client installations</span>
            </div>
        </div>
    </div>

    <!-- DataTables Table Card -->
    <div class="content-card">
        <div class="content-card-header">
            <div>
                <h2 class="card-heading">CCTV Packages Catalog</h2>
                <span style="font-size: 0.775rem; color: var(--text-subtle);">Displaying real-time security packages with integrated DataTables</span>
            </div>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary btn-sm">Manage All Packages</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="dashboard-packages-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Sequence</th>
                        <th>Package Name</th>
                        <th>Channels</th>
                        <th>Brands</th>
                        <th>Price (IDR)</th>
                        <th>Creator</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPackages as $package)
                        <tr>
                            <td><strong>#{{ $package->sequence }}</strong></td>
                            <td>
                                <div class="fw-bold" style="color: var(--burgundy-900);">{{ $package->name }}</div>
                                <small class="text-muted">{{ Str::limit(strip_tags((string) $package->description_eng), 60) }}</small>
                            </td>
                            <td>
                                @if($package->channel)
                                    <span class="badge badge-info">{{ $package->channel->total_channels }} Channels</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if(is_array($package->brands))
                                    @foreach($package->brands as $brandName)
                                        <span class="badge badge-secondary me-1">{{ $brandName }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><strong>Rp {{ number_format($package->price, 0, ',', '.') }}</strong></td>
                            <td>{{ $package->user?->name ?? 'System' }}</td>
                            <td>{{ $package->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
