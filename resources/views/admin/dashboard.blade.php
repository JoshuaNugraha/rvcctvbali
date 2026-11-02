@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Welcome Hero Card -->
    <div class="welcome-card">
        <div class="row align-items-center w-100 g-3">
            <div class="col-12 col-md-8">
                <div class="welcome-content">
                    <h1 class="welcome-title">Welcome back, {{ auth()->user()->name }}!</h1>
                    <p class="welcome-text">Overview of security systems, active camera packages, channel setups, and company marketing operations in Bali.</p>
                    <div class="d-flex flex-wrap gap-2 pt-2">
                        <a href="{{ route('admin.packages.index') }}" class="btn btn-primary">
                            <svg viewBox="0 0 24 24">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Manage Packages
                        </a>
                        <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">
                            View Promotions
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 text-md-end d-none d-md-block">
                <div class="welcome-illustration">
                    <svg width="120" height="110" viewBox="0 0 120 110" fill="none">
                        <rect x="15" y="10" width="90" height="90" rx="14" fill="#FFFFFF" stroke="#F5CCD5" stroke-width="2"/>
                        <circle cx="60" cy="55" r="24" stroke="#801B2E" stroke-width="3" fill="#FFF5F7"/>
                        <circle cx="60" cy="55" r="10" fill="#801B2E"/>
                        <line x1="60" y1="20" x2="60" y2="28" stroke="#801B2E" stroke-width="3" stroke-linecap="round"/>
                        <line x1="60" y1="82" x2="60" y2="90" stroke="#801B2E" stroke-width="3" stroke-linecap="round"/>
                        <line x1="25" y1="55" x2="33" y2="55" stroke="#801B2E" stroke-width="3" stroke-linecap="round"/>
                        <line x1="87" y1="55" x2="95" y2="55" stroke="#801B2E" stroke-width="3" stroke-linecap="round"/>
                    </svg>
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
