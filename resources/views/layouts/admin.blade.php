<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - RV CCTV Bali</title>

    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon-64.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Bootstrap 5 & Theme Styles from Macca ERP -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}?v={{ filemtime(public_path('css/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}?v={{ filemtime(public_path('css/select2-bootstrap-5-theme.min.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}?v={{ filemtime(public_path('css/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">

    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- Top Navigation Header -->
    <header class="app-topbar">
        <div class="topbar-brand">
            <button class="mobile-nav-toggle" id="sidebar-toggle-btn" aria-label="Toggle Navigation">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            <img src="{{ asset('favicon-64.png') }}" alt="RV CCTV Bali" class="brand-monogram p-1 bg-white" style="object-fit: contain;">
            <div class="brand-text-group">
                <span class="brand-name">RV CCTV Bali</span>
                <span class="brand-badge">Admin</span>
            </div>
        </div>

        <!-- Right Actions & Profile Pill -->
        <div class="topbar-user-area">
            <!-- User Profile Pill Dropdown -->
            <div class="dropdown">
                <div class="user-profile-pill" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                    <div class="user-avatar-circle">{{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}</div>
                    <span class="user-label-name">{{ auth()->user()->name ?? 'Administrator' }}</span>
                    <svg class="user-pill-caret" viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow" style="border-radius: 12px; border: 1px solid var(--card-border); margin-top: 8px;">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-bold" style="color: var(--burgundy-900);">{{ auth()->user()->name ?? 'Administrator' }}</div>
                        <small class="text-muted">{{ auth()->user()->email ?? 'admin@admin.com' }}</small>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger d-flex align-items-center gap-2">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Application Body: Sidebar + Large Curved Content Shell -->
    <div class="app-frame">
        <!-- Sidebar Navigation -->
        <aside class="app-sidebar" id="sidebar">
            <div class="sidebar-category-label">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="9"></rect>
                    <rect x="14" y="3" width="7" height="5"></rect>
                    <rect x="14" y="12" width="7" height="9"></rect>
                    <rect x="3" y="16" width="7" height="5"></rect>
                </svg>
                <span>Dashboard</span>
            </a>

            <div class="sidebar-category-label">Inventory & Products</div>

            <!-- Parent Menu: Products (Submenu: Channels, Brands) -->
            @php
                $isProductsActive = request()->routeIs('admin.channels.*') || request()->routeIs('admin.brands.*');
            @endphp
            <div class="sidebar-nav-group">
                <button type="button" class="sidebar-nav-parent {{ $isProductsActive ? 'open active' : '' }}" data-target="submenu-products" data-tooltip="Products">
                    <div class="sidebar-nav-parent-content">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span>Products</span>
                    </div>
                    <svg class="sidebar-nav-parent-chevron" viewBox="0 0 24 24">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
                <div class="sidebar-submenu {{ $isProductsActive ? 'open' : '' }}" id="submenu-products">
                    <a href="{{ route('admin.channels.index') }}" class="sidebar-submenu-link {{ request()->routeIs('admin.channels.*') ? 'active' : '' }}" data-tooltip="Channels">
                        <span class="submenu-dot"></span>
                        <span>Channels</span>
                    </a>
                    <a href="{{ route('admin.brands.index') }}" class="sidebar-submenu-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" data-tooltip="Brands">
                        <span class="submenu-dot"></span>
                        <span>Brands</span>
                    </a>
                </div>
            </div>

            <div class="sidebar-category-label">Catalog & Marketing</div>
            <a href="{{ route('admin.packages.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}" data-tooltip="Packages">
                <svg viewBox="0 0 24 24">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                <span>Packages</span>
            </a>

            <a href="{{ route('admin.promotions.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}" data-tooltip="Promotions">
                <svg viewBox="0 0 24 24">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                <span>Promotions</span>
            </a>

            <a href="{{ route('admin.past-projects.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.past-projects.*') ? 'active' : '' }}" data-tooltip="Past Projects">
                <svg viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                <span>Past Projects</span>
            </a>

            <div class="sidebar-category-label">Information & Setup</div>
            <a href="{{ route('admin.about-us.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.about-us.*') ? 'active' : '' }}" data-tooltip="About Us">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <span>About Us</span>
            </a>

            <!-- Parent Menu: Setting (Childs: Address, Phone Number, Social Media) -->
            @php
                $isSettingsActive = request()->routeIs('admin.settings.*');
            @endphp
            <div class="sidebar-nav-group">
                <button type="button" class="sidebar-nav-parent {{ $isSettingsActive ? 'open active' : '' }}" data-target="submenu-settings" data-tooltip="Settings">
                    <div class="sidebar-nav-parent-content">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                        <span>Settings</span>
                    </div>
                    <svg class="sidebar-nav-parent-chevron" viewBox="0 0 24 24">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
                <div class="sidebar-submenu {{ $isSettingsActive ? 'open' : '' }}" id="submenu-settings">
                    <a href="{{ route('admin.settings.address.index') }}" class="sidebar-submenu-link {{ request()->routeIs('admin.settings.address.*') ? 'active' : '' }}" data-tooltip="Address">
                        <span class="submenu-dot"></span>
                        <span>Address</span>
                    </a>
                    <a href="{{ route('admin.settings.phone-number.index') }}" class="sidebar-submenu-link {{ request()->routeIs('admin.settings.phone-number.*') ? 'active' : '' }}" data-tooltip="Phone Number">
                        <span class="submenu-dot"></span>
                        <span>Phone Number</span>
                    </a>
                    <a href="{{ route('admin.settings.social-media.index') }}" class="sidebar-submenu-link {{ request()->routeIs('admin.settings.social-media.*') ? 'active' : '' }}" data-tooltip="Social Media">
                        <span class="submenu-dot"></span>
                        <span>Social Media</span>
                    </a>
                </div>
            </div>

            <div class="sidebar-bottom-badge">
                RV CCTV Bali &bull; Solutions
            </div>
        </aside>

        <!-- Large White/Clean Curved Canvas Shell -->
        <main class="app-content-shell">
            @if(session('successMessage'))
                <div class="alert alert-success d-flex align-items-center justify-content-between mb-4 shadow-sm" style="border-radius: 12px; background-color: var(--status-success-bg); border-color: var(--status-success-border); color: var(--status-success-text);" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <span>{{ session('successMessage') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-4 shadow-sm" style="border-radius: 12px; background-color: var(--status-danger-bg); border-color: var(--status-danger-border); color: var(--status-danger-text);" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $errorMessage)
                            <li>{{ $errorMessage }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts from Macca ERP + DataTables + Select2 + SweetAlert2 + TinyMCE + Bootstrap 5 -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}?v={{ filemtime(public_path('js/jquery.min.js')) }}"></script>
    <script src="{{ asset('js/select2.min.js') }}?v={{ filemtime(public_path('js/select2.min.js')) }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}?v={{ filemtime(public_path('js/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>

    @stack('scripts')
</body>
</html>
