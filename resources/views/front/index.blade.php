<!DOCTYPE html>
<html lang="{{ ($currentLang ?? 'en') === 'id' ? 'id' : 'en' }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ ($currentLang ?? 'en') === 'id' ? 'RV CCTV TECHNOLOGY | Paket CCTV Siap Pasang & Teknisi Profesional di Bali' : 'RV CCTV TECHNOLOGY | Ready-to-Install CCTV Packages & Professional Installation in Bali' }}</title>
  <meta name="description" content="{{ ($currentLang ?? 'en') === 'id' ? 'Distributor resmi & jasa pasang CCTV profesional di Bali (Denpasar, Badung, Gianyar, Tabanan). Paket CCTV 2, 4, 8, 16 Channel Hikvision, Dahua, HiLook & Ezviz bergaransi resmi.' : 'Official distributor & professional CCTV installation service in Bali (Denpasar, Badung, Gianyar, Tabanan). Ready-to-install 2, 4, 8, 16 Channel Hikvision, Dahua, HiLook & Ezviz packages with official warranty.' }}">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
  <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon-64.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Custom Styles -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ filemtime(public_path('css/styles.css')) }}">
</head>
<body data-active-lang="{{ $currentLang ?? 'en' }}" data-wa-phone="{{ preg_replace('/[^0-9]/', '', (string) (($phoneSetting?->content ?? [])['phone_number'] ?? '6287855130070')) ?: '6287855130070' }}">
  @php
    $isId = ($currentLang ?? 'en') === 'id';

    $addressContent = (array) ($addressSetting?->content ?? []);
    $formattedAddress = implode(', ', array_filter([
        $addressContent['street'] ?? null,
        $addressContent['city'] ?? null,
        $addressContent['province'] ?? null,
        $addressContent['postal_code'] ?? null,
        $addressContent['country'] ?? null,
    ]));
    if (empty($formattedAddress)) {
        $formattedAddress = 'Jl. By Pass Ngurah Rai No. 128, Denpasar Selatan, Bali 80222, Indonesia';
    }

    $phoneContent = (array) ($phoneSetting?->content ?? []);
    $displayPhone = $phoneContent['phone_number'] ?? '+62 878-5513-0070';
    $rawDigitsPhone = preg_replace('/[^0-9]/', '', $displayPhone);
    if (empty($rawDigitsPhone)) {
        $rawDigitsPhone = '6287855130070';
    }

    $socialContent = (array) ($socialSetting?->content ?? []);
    $instagramUrl = !empty($socialContent['instagram']) ? $socialContent['instagram'] : 'https://instagram.com/rvcctvbali';
    $facebookUrl = !empty($socialContent['facebook']) ? $socialContent['facebook'] : 'https://facebook.com/rvcctvbali';
    $youtubeUrl = !empty($socialContent['youtube']) ? $socialContent['youtube'] : 'https://youtube.com/@rvcctvbali';
    $tiktokUrl = !empty($socialContent['tiktok']) ? $socialContent['tiktok'] : 'https://tiktok.com/@rvcctvbali';
  @endphp

  <!-- ========================================================================
       1. STICKY HEADER WITH OFFICIAL LOGO & MULTILINGUAL NAVIGATION
       ======================================================================== -->
  <header class="main-navbar sticky-top">
    <div class="container">
      <nav class="navbar navbar-expand-lg p-0">
        <!-- OFFICIAL LOGO IMAGE -->
        <a class="brand-logo-wrap" href="#home">
          <img src="{{ asset('logo.png') }}" alt="RV CCTV Technology Logo" class="navbar-logo-img">
        </a>

        <button class="navbar-toggler navbar-toggler-custom shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <div class="navbar-collapse-box d-flex flex-column flex-lg-row align-items-lg-center gap-3 gap-lg-3">
            <ul class="navbar-nav nav-menu-list mb-0">
              <li class="nav-item">
                <a class="nav-link nav-pill-link active" href="#home">
                  {{ $isId ? 'Beranda' : 'Home' }}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-pill-link" href="#promotions">
                  {{ $isId ? 'Promo' : 'Promotions' }}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-pill-link" href="#list-paket">
                  {{ $isId ? 'Paket CCTV' : 'Packages' }}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-pill-link" href="#past-projects">
                  {{ $isId ? 'Proyek Kami' : 'Past Projects' }}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-pill-link" href="#about-us">
                  {{ $isId ? 'Tentang Kami' : 'About Us' }}
                </a>
              </li>
            </ul>

            <div class="d-flex flex-wrap align-items-center gap-2">
              <div class="lang-switcher-pills" role="group" aria-label="Language Switcher">
                <a
                  href="{{ route('home', ['lang' => 'en']) }}"
                  class="lang-switch-btn {{ !$isId ? 'active' : '' }}"
                  data-lang-switch="en"
                >
                  English
                </a>
                <a
                  href="{{ route('home', ['lang' => 'id']) }}"
                  class="lang-switch-btn {{ $isId ? 'active' : '' }}"
                  data-lang-switch="id"
                >
                  Indonesia
                </a>
              </div>

              <button
                type="button"
                class="btn-nav-consult"
                data-bs-toggle="modal"
                data-bs-target="#waOrderModal"
                data-pkg-name="{{ $isId ? 'Konsultasi Gratis & Survei Lokasi (Bali)' : 'Free Consultation & Site Survey (Bali)' }}"
              >
                {{ $isId ? 'Konsultasi Gratis' : 'Free Consultation' }}
              </button>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <main>

    <!-- ======================================================================
         2. FULL-WIDTH ANIMATED VIDEO HERO SECTION (8 SECONDS, NO TEXT/BUTTONS)
         ====================================================================== -->
    <section id="home" class="hero-video-section">
      <video class="hero-bg-video" autoplay muted loop playsinline>
        <source src="{{ asset('hero-cctv.mp4') }}" type="video/mp4">
      </video>
    </section>

    <!-- ======================================================================
         3. PROMOTIONS SECTION (TOP OFFERS 3-CARD SLIDER + WIDE BOTTOM BANNER)
         ====================================================================== -->
    <section id="promotions" class="promotions-section">
      <div class="container">
        
        <!-- Top Header Row: Title Left, Link Right -->
        <div class="top-offers-header">
          <h2 class="top-offers-title">{{ $isId ? 'PENAWARAN TERBAIK' : 'TOP OFFERS' }}</h2>
          <a href="#list-paket" class="top-offers-link">{{ $isId ? 'Lihat Semua Paket' : 'View All Packages' }}</a>
        </div>

        <!-- Row 1: 3-Card Horizontal Slider with Left & Right Chevrons -->
        <div class="top-offers-slider-wrap">
          <button type="button" class="offer-nav-arrow offer-prev" id="offerPrevBtn" aria-label="Previous Offer">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
          </button>

          <div class="top-offers-viewport" id="topOffersViewport">
            <div class="top-offers-track" id="topOffersTrack">
              @php
                $promoSlides = [];
                if (isset($promotionList) && $promotionList->count() > 0) {
                    foreach ($promotionList as $promo) {
                        $mediaUrl = $promo->getFirstMediaUrl('promotion_image');
                        $promoSlides[] = [
                            'name' => $promo->name,
                            'image' => $mediaUrl ?: null,
                        ];
                    }
                }

                $fallbackPromoImages = [
                    'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1558002038-1055907df827?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=900&q=80',
                ];

                while (count($promoSlides) < 4) {
                    $idx = count($promoSlides);
                    $promoSlides[] = [
                        'name' => 'Special CCTV Promotion ' . ($idx + 1),
                        'image' => $fallbackPromoImages[$idx % count($fallbackPromoImages)],
                    ];
                }
              @endphp

              @foreach($promoSlides as $idx => $slide)
                @php
                  $slideImg = $slide['image'] ?: ($fallbackPromoImages[$idx % count($fallbackPromoImages)]);
                @endphp
                <div class="offer-card offer-card-image" data-bs-toggle="modal" data-bs-target="#waOrderModal" data-pkg-name="{{ $slide['name'] }}">
                  <img src="{{ $slideImg }}" alt="{{ $slide['name'] }}" class="offer-full-img">
                </div>
              @endforeach
            </div>
          </div>

          <button type="button" class="offer-nav-arrow offer-next" id="offerNextBtn" aria-label="Next Offer">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </button>
        </div>

        <!-- Row 2: Full-Width Bottom Promo Banner (Full Image, No Text) -->
        <div class="offer-wide-banner-clean mt-4" data-bs-toggle="modal" data-bs-target="#waOrderModal" data-pkg-name="{{ $isId ? 'Promo Banner Spesial' : 'Special Banner Promo' }}">
          <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1400&q=80" alt="Special CCTV Promotion Banner" class="offer-wide-full-img">
        </div>

      </div>
    </section>

    <!-- ======================================================================
         4. ANALOG CCTV PACKAGE LIST (DYNAMIC FROM DATABASE)
         ====================================================================== -->
    <section id="list-paket" class="section-spacer bg-white border-top border-bottom">
      <div class="container">

        <!-- Special Website Pricing Banner -->
        <div class="web-special-banner mb-4">
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
              <div class="web-special-tag">
                {{ $isId ? 'PROMO EKSKLUSIF ONLINE' : 'EXCLUSIVE ONLINE PROMO' }}
              </div>
              <h2 class="h3 fw-bolder mb-1 text-white">
                {{ $isId ? 'Harga Spesial Pemesanan Website' : 'Special Website Order Pricing' }}
              </h2>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
              <span class="small text-white-50 fw-bold me-1">
                {{ $isId ? 'Pilih Merk:' : 'Select Brand:' }}
              </span>
              <div class="brand-selector-pills" role="group" aria-label="Select CCTV Brand">
                <button type="button" class="brand-filter-btn active" data-brand="all">
                  {{ $isId ? 'Semua' : 'All' }}
                </button>
                @foreach($brandList as $brandItem)
                  <button type="button" class="brand-filter-btn" data-brand="{{ strtolower($brandItem->name) }}">
                    {{ $brandItem->name }}
                  </button>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        <!-- Section Subheader & Channel Filter Pills -->
        <div class="row align-items-end mb-4">
          <div class="col-lg-6">
            <h3 class="h4 fw-bolder mb-1">
              {{ $isId ? 'Paket Kamera Analog Siap Pasang' : 'Ready-to-Install Analog Camera Packages' }}
            </h3>
          </div>
          <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">
            <div class="channel-selector-pills" role="group">
              <button type="button" class="ch-filter-btn active" data-ch="all">
                {{ $isId ? 'Semua' : 'All' }}
              </button>
              @foreach($channelList as $channelItem)
                <button type="button" class="ch-filter-btn" data-ch="{{ $channelItem->total_channels }}ch">
                  {{ $channelItem->total_channels }}CH
                </button>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Dynamic Package Cards Grid from Database -->
        <div class="row g-4" id="packageCardsGrid">
          @forelse($packageList as $packageItem)
            @php
              $totalChannelsCount = $packageItem->channel?->total_channels ?? 0;
              $channelFilterKey = $totalChannelsCount ? $totalChannelsCount . 'ch' : 'other';
              $channelBadgeLabel = $totalChannelsCount ? $totalChannelsCount . 'CH' : 'PKG';
              $packageBrands = is_array($packageItem->brands) ? array_values($packageItem->brands) : [];
              $packageBrandsLower = array_map('strtolower', $packageBrands);
              $firstBrandName = $packageBrands[0] ?? 'Official';
              $formattedPrice = 'Rp ' . number_format($packageItem->price, 0, ',', '.');
              $pkgDescription = $isId
                ? ($packageItem->description_ina ?: $packageItem->description_eng)
                : ($packageItem->description_eng ?: $packageItem->description_ina);
            @endphp
            <div
              class="col-12 col-md-6 col-xl-4 pkg-col"
              data-ch-item="{{ $channelFilterKey }}"
              data-brands="{{ implode(',', $packageBrandsLower) }}"
            >
              <div class="pkg-card {{ $loop->iteration === 2 ? 'pkg-popular' : '' }}" data-pkg-ch="{{ $channelBadgeLabel }}" data-pkg-title="{{ $packageItem->name }}">
                <div>
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="pkg-ch-circle">
                      <span>{{ $totalChannelsCount ?: $loop->iteration }}</span>
                      <small>{{ $totalChannelsCount ? 'CH' : 'PKG' }}</small>
                    </div>
                    <div class="text-end">
                      <div class="pkg-web-price-note">
                        {{ $isId ? 'Harga Spesial Order Website' : 'Special Website Order Price' }}
                      </div>
                      <div class="fw-bold small text-dark">{{ $packageItem->name }}</div>
                    </div>
                  </div>

                  <!-- Brand Price Comparison Selector inside Card -->
                  @if(count($packageBrands) > 0)
                    <div class="pkg-brand-prices">
                      @foreach($packageBrands as $brandName)
                        <div
                          class="pkg-brand-row {{ $loop->first ? 'active' : '' }}"
                          data-brand-row="{{ strtolower($brandName) }}"
                          data-brand-label="{{ $brandName }}"
                          data-price="{{ $formattedPrice }}"
                        >
                          <span>{{ $brandName }} {{ $totalChannelsCount ? $totalChannelsCount . 'CH' : '' }}</span>
                          <strong>{{ $formattedPrice }}</strong>
                        </div>
                      @endforeach
                    </div>
                  @endif

                  <div class="pkg-inclusions-title">
                    {{ $isId ? "Kelengkapan Paket ($channelBadgeLabel):" : "Analog Package Inclusions ($channelBadgeLabel):" }}
                  </div>
                  <ul class="pkg-spec-list">
                    <li><span class="text-muted">{{ $isId ? 'Kamera' : 'Cameras' }}</span> <strong>{{ $packageItem->cameras ?: '-' }}</strong></li>
                    <li><span class="text-muted">{{ $isId ? 'Perekam Unit' : 'Recorder Unit' }}</span> <strong>{{ $packageItem->recorder_unit ?: '-' }}</strong></li>
                    <li><span class="text-muted">{{ $isId ? 'Penyimpanan' : 'Storage' }}</span> <strong>{{ $packageItem->storage ?: '-' }}</strong></li>
                    <li><span class="text-muted">{{ $isId ? 'Power & Konektor' : 'Power & Connectors' }}</span> <strong>{{ $packageItem->power_connectors ?: '-' }}</strong></li>
                    <li><span class="text-muted">{{ $isId ? 'Kabel RG59+P' : 'RG59+P Cable' }}</span> <strong>{{ $packageItem->cable ?: '-' }}</strong></li>
                    <li><span class="text-muted">{{ $isId ? 'Layanan' : 'Service' }}</span> <strong>{{ $packageItem->service ?: '-' }}</strong></li>
                  </ul>

                  @if($pkgDescription)
                    <div class="pkg-custom-desc small text-muted mt-2 pt-2 border-top">
                      {!! $pkgDescription !!}
                    </div>
                  @endif
                </div>

                <div class="mt-3">
                  <small class="text-muted d-block">
                    {{ $isId ? 'Harga Terpilih' : 'Selected Price' }} (<span class="pkg-active-brand-label">{{ $firstBrandName }}</span>):
                  </small>
                  <div class="pkg-price-tag mb-3" @if($loop->iteration === 2) style="color: var(--brand-red);" @endif>
                    {{ $formattedPrice }}
                  </div>
                  <button
                    type="button"
                    class="{{ $loop->iteration === 2 ? 'btn-crimson-pill' : 'btn-dark-pill' }} w-100 pkg-order-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#waOrderModal"
                    data-pkg-name="{{ $packageItem->name }} ({{ $firstBrandName }}) - {{ $formattedPrice }} ({{ $isId ? 'Harga Spesial Website' : 'Special Website Order Price' }})"
                  >
                    {{ $isId ? 'Pesan ' . $packageItem->name : 'Order ' . $packageItem->name }}
                  </button>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="text-center py-5 text-muted">
                {{ $isId ? 'Belum ada paket CCTV yang tersedia saat ini.' : 'No packages available at the moment.' }}
              </div>
            </div>
          @endforelse
        </div>

        <!-- Interactive Smart Point Estimator (Synced with Official Analog Prices) -->
        <div class="smart-estimator-box">
          <div class="row align-items-center g-4">
            <div class="col-lg-4">
              <h3 class="h4 fw-bold mb-1">
                {{ $isId ? 'Kalkulator Paket CCTV Analog' : 'Analog CCTV Package Calculator' }}
              </h3>
              <p class="small text-white-50 mb-2">
                {{ $isId ? 'Geser jumlah kamera dan pilih merk favorit' : 'Slide or click channel count and choose a brand' }}
              </p>
              <div class="calc-brand-pills" role="group" aria-label="Select Calculator Brand">
                <button type="button" class="calc-brand-btn active" data-calc-brand="dahua">Dahua</button>
                <button type="button" class="calc-brand-btn" data-calc-brand="hikvision">Hikvision</button>
                <button type="button" class="calc-brand-btn" data-calc-brand="hilook">HiLook</button>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label for="camPointRange" class="small fw-bold">
                  {{ $isId ? 'Jumlah Kamera:' : 'Camera Channel Count:' }}
                </label>
                <span id="camPointValue" class="fw-bolder text-brand-red font-mono-tech fs-5">
                  4 {{ $isId ? 'Kamera' : 'Cameras' }}
                </span>
              </div>
              <input type="range" class="form-range" id="camPointRange" min="0" max="5" step="1" value="2">
              <div class="cam-range-ticks font-mono-tech">
                <button type="button" class="cam-tick-btn" data-idx="0">2CH</button>
                <button type="button" class="cam-tick-btn" data-idx="1">3CH</button>
                <button type="button" class="cam-tick-btn active" data-idx="2">4CH</button>
                <button type="button" class="cam-tick-btn" data-idx="3">6CH</button>
                <button type="button" class="cam-tick-btn" data-idx="4">8CH</button>
                <button type="button" class="cam-tick-btn" data-idx="5">16CH</button>
              </div>
            </div>
            <div class="col-lg-3 text-lg-end">
              <div id="calcChannelDetail" class="small text-white-50">
                Dahua • 4CH {{ $isId ? 'Paket Analog' : 'Analog Package' }}
              </div>
              <div id="calcRecommendationText" class="h4 fw-bolder text-warning mb-1">Rp 3.600.000</div>
              <div class="small text-white-50 mb-2" style="font-size: 0.72rem;">
                {{ $isId ? 'Harga Spesial Order Website' : 'Special Website Order Price' }}
              </div>
              <button type="button" id="calcOrderBtn" class="btn-crimson-pill w-100" data-bs-toggle="modal" data-bs-target="#waOrderModal" data-pkg-name="Dahua 4CH Analog CCTV Package - Rp 3.600.000 ({{ $isId ? 'Harga Spesial Website' : 'Special Website Order Price' }})">
                {{ $isId ? 'Pesan via WhatsApp' : 'Order via WhatsApp' }}
              </button>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- ======================================================================
         5. PAST PROJECTS (BALI INSTALLATION PORTFOLIO)
         ====================================================================== -->
    <section id="past-projects" class="section-spacer" style="background-color: var(--bg-dark); color: #FFFFFF;">
      <div class="container">
        <div class="row align-items-end mb-4 mb-lg-5">
          <div class="col-lg-8">
            <h2 class="display-6 fw-bolder mb-2">
              {{ $isId ? 'Proyek Kami' : 'Past Projects' }}
            </h2>
            <p class="text-white-50 mb-0">
              {{ $isId
                ? 'CCTV terpasang rapi di seluruh Bali.'
                : 'Camera points neatly installed across Bali.' }}
            </p>
          </div>
        </div>

        <div class="row g-4">
          @forelse($pastProjectList as $projectItem)
            @php
              $projectMediaUrl = $projectItem->getFirstMediaUrl('project_image');
              $projectDesc = $isId
                ? ($projectItem->description_ina ?: $projectItem->description_eng)
                : ($projectItem->description_eng ?: $projectItem->description_ina);
            @endphp
            <div class="col-12 col-md-4">
              <div class="project-monitor-card">
                <div class="project-img-wrap">
                  @if($projectMediaUrl)
                    <img src="{{ $projectMediaUrl }}" alt="{{ $projectItem->title }}">
                  @else
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="{{ $projectItem->title }}">
                  @endif
                </div>
                <div class="p-4">
                  <span class="font-mono-tech text-brand-red small fw-bold">
                    {{ strtoupper($projectItem->sub_title ?: 'BALI, INDONESIA') }}
                  </span>
                  <h3 class="h5 fw-bold mt-1 mb-2">{{ $projectItem->title }}</h3>
                  <div class="small text-white-50 mb-3">
                    {!! $projectDesc !!}
                  </div>
                  <div class="pt-3 border-top border-secondary border-opacity-25 d-flex justify-content-between small font-mono-tech text-white-50">
                    <span>RV CCTV PRO</span>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 col-md-4">
              <div class="project-monitor-card">
                <div class="project-img-wrap">
                  <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="Private Villa CCTV Installation">
                </div>
                <div class="p-4">
                  <span class="font-mono-tech text-brand-red small fw-bold">CANGGU &amp; SEMINYAK</span>
                  <h3 class="h5 fw-bold mt-1 mb-2">{{ $isId ? 'Instalasi Villa Pribadi Hikvision ColorVu' : '8-Channel Hikvision ColorVu Private Villa Installation' }}</h3>
                  <p class="small text-white-50 mb-3">
                    {{ $isId ? 'Instalasi pipa konduit rapi untuk pemantauan 24 jam area kolam renang dan akses masuk vila.' : 'Concealed ceiling conduit wiring for 24-hour full-color monitoring of the swimming pool area, villa parking, and main entrance access.' }}
                  </p>
                </div>
              </div>
            </div>
          @endforelse
        </div>

      </div>
    </section>

    <!-- ======================================================================
         6. ABOUT US (WHY CHOOSE US & SHOWROOM)
         ====================================================================== -->
    <section id="about-us" class="section-spacer">
      <div class="container">
        <div class="row g-4 g-lg-5 align-items-center">
          
          <!-- Left: Showroom Visual Banner -->
          <div class="col-lg-5">
            <div class="showroom-visual-card shadow">
              @php
                $aboutMediaUrl = $aboutUsRecord?->getFirstMediaUrl('about_image');
                $aboutDesc = $isId
                  ? ($aboutUsRecord?->description_ina ?: $aboutUsRecord?->description_eng)
                  : ($aboutUsRecord?->description_eng ?: $aboutUsRecord?->description_ina);
              @endphp
              @if($aboutMediaUrl)
                <img src="{{ $aboutMediaUrl }}" alt="RV CCTV Showroom">
              @else
                <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=900&q=80" alt="RV CCTV Showroom and Consultation Team">
              @endif
              <div class="position-relative z-2">
                <span class="badge bg-brand-red font-mono-tech mb-2">
                  {{ $isId ? 'SHOWROOM RESMI BALI' : 'OFFICIAL BALI SHOWROOM' }}
                </span>
                <h3 class="h3 fw-bold mb-2">
                  {{ $aboutUsRecord?->title ?: ($isId ? 'Kunjungi & Tes Kualitas Kamera Langsung' : 'Visit & Test Our Camera Quality Directly') }}
                </h3>
                @php
                  $aboutSubtitle = $isId
                    ? ($aboutUsRecord?->sub_title_ina ?: $aboutUsRecord?->sub_title_eng ?: 'Melayani survei dan konsultasi di tempat se-Bali (Denpasar, Badung, Gianyar, Tabanan).')
                    : ($aboutUsRecord?->sub_title_eng ?: $aboutUsRecord?->sub_title_ina ?: 'Serving on-site consultations and surveys across Denpasar, Badung, Gianyar, Tabanan, and surrounding areas in Bali.');
                @endphp
                <p class="small text-white-50 mb-3">
                  {{ $aboutSubtitle }}
                </p>
                <button type="button" class="btn-crimson-pill btn-sm" data-bs-toggle="modal" data-bs-target="#waOrderModal" data-pkg-name="{{ $isId ? 'Jadwal Kunjungan Showroom' : 'Showroom Visit Appointment' }}">
                  {{ $isId ? 'Jadwalkan Kunjungan' : 'Book a Showroom Visit' }}
                </button>
              </div>
            </div>
          </div>

          <!-- Right: About Story & 4 Pillars -->
          <div class="col-lg-7">
            @php
              $aboutHeadline = $isId
                ? ($aboutUsRecord?->headline_ina ?: $aboutUsRecord?->headline_eng ?: 'Solusi Keamanan CCTV Terlengkap di Bali dari Konsultasi hingga Garansi Purnajual.')
                : ($aboutUsRecord?->headline_eng ?: $aboutUsRecord?->headline_ina ?: 'Complete Security Solutions in Bali from Consultation to After-Sales Support.');
            @endphp
            <h2 class="display-6 fw-bolder mb-3">
              {{ $aboutHeadline }}
            </h2>
            <div class="text-muted mb-4">
              @if($aboutDesc)
                {!! $aboutDesc !!}
              @else
                <p>
                  <strong>RV CCTV TECHNOLOGY</strong> {{ $isId
                    ? 'menyediakan sistem kamera CCTV jernih, tahan cuaca, dan mudah dipantau langsung dari smartphone untuk kebutuhan rumah maupun bisnis Anda.'
                    : 'provides crystal-clear, durable surveillance systems that are easy to monitor directly from your smartphone for residential and commercial properties.' }}
                </p>
              @endif
            </div>

            @php
              $featureCards = ($aboutUsRecord && $aboutUsRecord->features->count() > 0)
                ? $aboutUsRecord->features->take(4)
                : \App\Models\AboutFeature::orderBy('sequence')->take(4)->get();
            @endphp
            <div class="row g-3">
              @if($featureCards->count() > 0)
                @foreach($featureCards as $featureItem)
                  <div class="col-sm-6">
                    <div class="about-card-feature">
                      <h4 class="h6 fw-bold">
                        {{ $isId
                          ? ($featureItem->title_ina ?: $featureItem->title_eng)
                          : ($featureItem->title_eng ?: $featureItem->title_ina) }}
                      </h4>
                      <p class="small text-muted mb-0">
                        {{ $isId
                          ? ($featureItem->description_ina ?: $featureItem->description_eng)
                          : ($featureItem->description_eng ?: $featureItem->description_ina) }}
                      </p>
                    </div>
                  </div>
                @endforeach
              @else
                <div class="col-sm-6">
                  <div class="about-card-feature">
                    <h4 class="h6 fw-bold">{{ $isId ? 'Garansi Resmi 2 Tahun' : '2-Year Official Warranty' }}</h4>
                    <p class="small text-muted mb-0">
                      {{ $isId
                        ? '100% unit original dari distributor resmi Hikvision, Dahua, dan Ezviz dengan klaim garansi mudah di Bali.'
                        : '100% original units from authorized Hikvision, Dahua, and Ezviz distributors with hassle-free warranty claims in Bali.' }}
                    </p>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="about-card-feature">
                    <h4 class="h6 fw-bold">{{ $isId ? 'Standar Instalasi Vila & Hotel' : 'Villa & Hotel Standard Installation' }}</h4>
                    <p class="small text-muted mb-0">
                      {{ $isId
                        ? 'Jalur kabel tertutup dengan pipa pelindung rapi untuk menjaga estetika arsitektur bangunan Anda.'
                        : 'Concealed cable routing with neat protective conduits to preserve your building\'s architectural aesthetics.' }}
                    </p>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="about-card-feature">
                    <h4 class="h6 fw-bold">{{ $isId ? 'Gratis Survei Area Bali' : 'Free Bali Area Survey' }}</h4>
                    <p class="small text-muted mb-0">
                      {{ $isId
                        ? 'Rekomendasi penempatan sudut kamera terbaik tanpa titik buta (zero blind spot).'
                        : 'Optimal lens placement recommendations to ensure every critical angle is covered with zero blind spots.' }}
                    </p>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="about-card-feature">
                    <h4 class="h6 fw-bold">{{ $isId ? 'Panduan Aplikasi & Dukungan Teknisi' : 'App Setup & Maintenance Support' }}</h4>
                    <p class="small text-muted mb-0">
                      {{ $isId
                        ? 'Konfigurasi aplikasi HP hingga aktif dan siap pakai, didukung teknisi lokal yang responsif.'
                        : 'Guided mobile app configuration until fully active, backed by responsive on-site technician support.' }}
                    </p>
                  </div>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

  <!-- ========================================================================
       7. FOOTER WITH OFFICIAL LOGO & SOCIAL MEDIA LOGOS
       ======================================================================== -->
  <footer class="site-footer">
    <div class="container">
      <div class="row g-4 pb-4 border-bottom border-secondary border-opacity-25">
        
        <div class="col-lg-4">
          <div class="footer-logo-box mb-3">
            <img src="{{ asset('logo.png') }}" alt="RV CCTV Technology Logo">
          </div>
          <p class="small mb-3" style="max-width: 420px;">
            {{ $isId
              ? 'Paket CCTV siap pasang, IP Camera, dan layanan instalasi profesional untuk Denpasar, Badung (Kuta, Canggu, Seminyak, Jimbaran, Nusa Dua), Gianyar (Ubud), dan seluruh wilayah Bali.'
              : 'Ready-to-install CCTV packages, IP Cameras, and professional installation services for Denpasar, Badung (Kuta, Canggu, Seminyak, Jimbaran, Nusa Dua), Gianyar (Ubud), and all across Bali.' }}
          </p>
          <div class="small text-white">
            <div>
              <strong>{{ $isId ? 'Area Layanan & Alamat:' : 'Service Area & Address:' }}</strong>
              {{ $formattedAddress }}
            </div>
            <div>
              <strong>{{ $isId ? 'WhatsApp & Kontak:' : 'WhatsApp & Contact Person:' }}</strong>
              <a href="https://wa.me/{{ $rawDigitsPhone }}" target="_blank" rel="noopener" class="text-white text-decoration-none">
                {{ $displayPhone }}
              </a>
            </div>
          </div>
        </div>

        <div class="col-6 col-lg-2">
          <h3 class="h6 fw-bold text-white mb-3">
            {{ $isId ? 'Menu Cepat' : 'Quick Links' }}
          </h3>
          <ul class="list-unstyled small d-flex flex-column gap-2">
            <li><a href="#home" class="text-secondary text-decoration-none">{{ $isId ? 'Beranda' : 'Home' }}</a></li>
            <li><a href="#promotions" class="text-secondary text-decoration-none">{{ $isId ? 'Promo & Diskon Spesial' : 'Promotions & Special Sale' }}</a></li>
            <li><a href="#list-paket" class="text-secondary text-decoration-none">{{ $isId ? 'Paket CCTV 2 / 4 / 8 / 16 CH' : 'CCTV Packages 2 / 4 / 8 / 16 CH' }}</a></li>
            <li><a href="#past-projects" class="text-secondary text-decoration-none">{{ $isId ? 'Portofolio Proyek Bali' : 'Bali Project Portfolio' }}</a></li>
            <li><a href="#about-us" class="text-secondary text-decoration-none">{{ $isId ? 'Tentang Kami & Showroom' : 'About Us & Showroom' }}</a></li>
          </ul>
        </div>

        <div class="col-6 col-lg-2">
          <h3 class="h6 fw-bold text-white mb-3">
            {{ $isId ? 'Media Sosial' : 'Social Media' }}
          </h3>
          <p class="small mb-3">
            {{ $isId ? 'Ikuti update dokumentasi kami:' : 'Follow our updates:' }}
          </p>
          <div class="d-flex flex-wrap gap-2">
            <!-- Instagram -->
            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" class="social-icon-btn" aria-label="Instagram">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
            </a>
            <!-- Facebook -->
            <a href="{{ $facebookUrl }}" target="_blank" rel="noopener" class="social-icon-btn" aria-label="Facebook">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </a>
            <!-- YouTube -->
            <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener" class="social-icon-btn" aria-label="YouTube">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/></svg>
            </a>
            <!-- TikTok -->
            <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener" class="social-icon-btn" aria-label="TikTok">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg>
            </a>
          </div>
        </div>

        <div class="col-lg-4">
          <h3 class="h6 fw-bold text-white mb-3">
            {{ $isId ? 'Lokasi Toko' : 'Store Location' }}
          </h3>
          <div class="footer-map-container mb-2">
            @php
              $mapsEmbedHtml = $addressContent['maps_embed'] ?? '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3943.872887701061!2d115.20237399999998!3d-8.7036194!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2410150ed09ef%3A0x6d66419d5b314f56!2sRV%20CCTV%20TECHNOLOGY!5e0!3m2!1sid!2sid!4v1793423332997!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>';
            @endphp
            {!! $mapsEmbedHtml !!}
          </div>
          <a href="https://maps.google.com/?q=RV+CCTV+TECHNOLOGY" target="_blank" rel="noopener" class="small text-white-50 text-decoration-none d-inline-flex align-items-center gap-1">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span>{{ $isId ? 'Buka Petunjuk Arah di Google Maps →' : 'Get Directions on Google Maps →' }}</span>
          </a>
        </div>

      </div>

      <div class="pt-4 d-flex flex-wrap justify-content-between align-items-center small gap-2">
        <span>&copy; 2026 RV CCTV TECHNOLOGY BALI. {{ $isId ? 'Hak cipta dilindungi undang-undang.' : 'All rights reserved.' }}</span>
        <span>{{ $isId ? 'Pembayaran: Transfer Bank / Tunai saat Pasang • Garansi Resmi' : 'Payment: Bank Transfer / Cash on Installation • Official Warranty' }}</span>
      </div>
    </div>
  </footer>

  <!-- ========================================================================
       8. FLOATING WHATSAPP BUTTON (BOTTOM RIGHT)
       ======================================================================== -->
  <div class="wa-floating-wrapper">
    <button type="button" class="wa-floating-btn" data-bs-toggle="modal" data-bs-target="#waOrderModal" data-pkg-name="{{ $isId ? 'Chat Langsung via WhatsApp' : 'Direct Chat via Floating WhatsApp' }}">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12.031 2c-5.516 0-9.969 4.453-9.969 9.969 0 1.766.469 3.484 1.344 4.984L2 22l5.188-1.359c1.453.797 3.109 1.219 4.843 1.219 5.516 0 9.969-4.453 9.969-9.969S17.547 2 12.031 2zm5.813 14.125c-.25.703-1.438 1.344-2 1.422-.531.078-1.203.109-1.938-.125-.453-.141-1.031-.328-1.766-.641-3.094-1.328-5.109-4.469-5.266-4.672-.156-.203-1.266-1.688-1.266-3.219s.797-2.281 1.078-2.594c.281-.312.609-.391.813-.391.203 0 .406.016.578.016.188 0 .438-.078.688.516.25.609.859 2.094.938 2.25.078.156.125.344.016.547-.109.203-.156.344-.313.531-.156.188-.328.406-.469.547-.156.156-.313.328-.141.625.172.297.766 1.266 1.641 2.047 1.125 1.016 2.078 1.328 2.375 1.484.297.156.469.125.641-.078.172-.203.75-.875.953-1.172.203-.297.406-.25.672-.156.266.094 1.703.813 1.984.953.281.141.469.219.547.344.078.125.078.734-.172 1.438z"/>
      </svg>
      <span>{{ $isId ? 'Chat WhatsApp' : 'Chat WhatsApp' }}</span>
    </button>
  </div>

  <!-- ========================================================================
       WHATSAPP INSTANT ORDER & CONSULTATION MODAL
       ======================================================================== -->
  <div class="modal fade" id="waOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
        <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
          <div>
            <span class="badge bg-brand-soft font-mono-tech mb-1">
              {{ $isId ? 'RV CCTV TECHNOLOGY • RESPON CEPAT' : 'RV CCTV TECHNOLOGY • FAST RESPONSE' }}
            </span>
            <h4 class="modal-title fw-bolder">
              {{ $isId ? 'Konsultasi & Pemesanan Paket' : 'Consultation & Package Order' }}
            </h4>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body px-4 pb-4">
          <form id="waQuickForm">
            <x-honeypot />
            <div class="mb-3">
              <label class="form-label small fw-bold text-muted">
                {{ $isId ? 'Paket / Layanan yang Dipilih' : 'Selected Package / Service' }}
              </label>
              <input type="text" id="modalPkgInput" class="form-control bg-light fw-bold" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-bold text-muted">
                {{ $isId ? 'Nama Anda' : 'Your Name' }}
              </label>
              <input type="text" id="modalUserName" class="form-control" placeholder="{{ $isId ? 'cth., Wayan Pratama' : 'e.g., Wayan Pratama' }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-bold text-muted">
                {{ $isId ? 'Area Lokasi di Bali' : 'Location Area in Bali' }}
              </label>
              <input type="text" id="modalArea" class="form-control" placeholder="{{ $isId ? 'cth., Denpasar / Canggu / Seminyak' : 'e.g., Denpasar / Canggu / Seminyak' }}">
            </div>
            <button type="submit" class="btn-crimson-pill w-100 py-3 mt-2">
              {{ $isId ? 'Kirim ke WhatsApp Sekarang →' : 'Send to WhatsApp Now →' }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5.3 JS Bundle -->
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/front.js') }}?v={{ filemtime(public_path('js/front.js')) }}"></script>
</body>
</html>
