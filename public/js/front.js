/**
 * RV CCTV TECHNOLOGY BALI - Interactive Features:
 * 1. Top Offers 3-Card Horizontal Slider (#promotions)
 * 2. Instant Channel Filter (All / 2CH / 3CH / 4CH / 6CH / 8CH / 16CH) & Brand Switcher (Dahua / Hikvision / HiLook)
 * 3. Accurate Analog CCTV Calculator Slider synced with Official Website Pricelist
 * 4. WhatsApp Order Modal Pre-fill & Redirect (+62 878-5513-0070)
 */

document.addEventListener('DOMContentLoaded', () => {
  // Official Analog CCTV Website Pricelist
  const analogPrices = {
    dahua: {
      label: 'Dahua',
      prices: {
        '2CH': 2450000,
        '3CH': 2700000,
        '4CH': 3600000,
        '6CH': 4990000,
        '8CH': 6400000,
        '16CH': 12600000
      }
    },
    hikvision: {
      label: 'Hikvision',
      prices: {
        '2CH': 2950000,
        '3CH': 3500000,
        '4CH': 4200000,
        '6CH': 5900000,
        '8CH': 7900000,
        '16CH': 17950000
      }
    },
    hilook: {
      label: 'HiLook',
      prices: {
        '2CH': 2400000,
        '3CH': 2600000,
        '4CH': 3200000,
        '6CH': 4100000,
        '8CH': 5900000,
        '16CH': 12500000
      }
    }
  };

  const channelSteps = [
    { key: '2CH', cams: 2, cableMeters: 20 },
    { key: '3CH', cams: 3, cableMeters: 30 },
    { key: '4CH', cams: 4, cableMeters: 40 },
    { key: '6CH', cams: 6, cableMeters: 60 },
    { key: '8CH', cams: 8, cableMeters: 80 },
    { key: '16CH', cams: 16, cableMeters: 160 }
  ];

  function formatRupiah(numValue) {
    return 'Rp ' + numValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  // 0. Top Offers 3-Card Horizontal Slider (#promotions)
  const topOffersTrack = document.getElementById('topOffersTrack');
  const offerPrevBtn = document.getElementById('offerPrevBtn');
  const offerNextBtn = document.getElementById('offerNextBtn');

  if (topOffersTrack && offerPrevBtn && offerNextBtn) {
    let offerIndex = 0;

    function getVisibleOfferCount() {
      if (window.innerWidth < 768) return 1;
      if (window.innerWidth < 992) return 2;
      return 3;
    }

    function updateOfferSlider() {
      const cardElements = topOffersTrack.querySelectorAll('.offer-card');
      const visibleCount = getVisibleOfferCount();
      const maxIndex = Math.max(0, cardElements.length - visibleCount);
      if (offerIndex > maxIndex) offerIndex = 0;
      if (offerIndex < 0) offerIndex = maxIndex;

      if (cardElements.length > 0) {
        const cardWidth = cardElements[0].getBoundingClientRect().width;
        const gapWidth = 20;
        const offsetPx = offerIndex * (cardWidth + gapWidth);
        topOffersTrack.style.transform = `translateX(-${offsetPx}px)`;
      }
    }

    offerNextBtn.addEventListener('click', () => {
      const cardElements = topOffersTrack.querySelectorAll('.offer-card');
      const maxIndex = Math.max(0, cardElements.length - getVisibleOfferCount());
      offerIndex = offerIndex >= maxIndex ? 0 : offerIndex + 1;
      updateOfferSlider();
    });

    offerPrevBtn.addEventListener('click', () => {
      const cardElements = topOffersTrack.querySelectorAll('.offer-card');
      const maxIndex = Math.max(0, cardElements.length - getVisibleOfferCount());
      offerIndex = offerIndex <= 0 ? maxIndex : offerIndex - 1;
      updateOfferSlider();
    });

    window.addEventListener('resize', updateOfferSlider);
  }

  const isIndonesian = document.body.getAttribute('data-active-lang') === 'id';

  // 1. Channel & Brand Filter Pills (Dynamic Database Package List)
  const chFilterBtns = document.querySelectorAll('.ch-filter-btn');
  const brandFilterBtns = document.querySelectorAll('.brand-filter-btn');
  const pkgCols = document.querySelectorAll('.pkg-col');
  const pkgCards = document.querySelectorAll('.pkg-card[data-pkg-ch]');

  let activeChannelFilter = 'all';
  let activeBrandFilter = 'all';

  function updateCardBrandSelection(cardElement, rowElement) {
    if (!cardElement || !rowElement) return;
    const brandRows = cardElement.querySelectorAll('.pkg-brand-row');
    brandRows.forEach((rowItem) => rowItem.classList.remove('active'));
    rowElement.classList.add('active');

    const brandLabel = rowElement.getAttribute('data-brand-label') || 'Official';
    const formattedPrice = rowElement.getAttribute('data-price') || '';
    const pkgTitle = cardElement.getAttribute('data-pkg-title') || 'CCTV Package';

    const brandLabelEl = cardElement.querySelector('.pkg-active-brand-label');
    if (brandLabelEl) {
      brandLabelEl.textContent = brandLabel;
    }

    const priceTagEl = cardElement.querySelector('.pkg-price-tag');
    if (priceTagEl && formattedPrice) {
      priceTagEl.textContent = formattedPrice;
    }

    const orderBtnEl = cardElement.querySelector('.pkg-order-btn');
    if (orderBtnEl) {
      orderBtnEl.textContent = isIndonesian ? `Pesan ${pkgTitle}` : `Order ${pkgTitle}`;
      const promoText = isIndonesian ? 'Harga Spesial Website' : 'Special Website Order Price';
      orderBtnEl.setAttribute(
        'data-pkg-name',
        `${pkgTitle} (${brandLabel}) - ${formattedPrice} (${promoText})`
      );
    }
  }

  function applyPackageFilters() {
    pkgCols.forEach((colElement) => {
      const itemCh = colElement.getAttribute('data-ch-item') || '';
      const itemBrandsRaw = colElement.getAttribute('data-brands') || '';
      const itemBrands = itemBrandsRaw
        .split(',')
        .map((brandVal) => brandVal.trim().toLowerCase())
        .filter(Boolean);

      const matchesChannel = activeChannelFilter === 'all' || itemCh === activeChannelFilter;
      const matchesBrand = activeBrandFilter === 'all' || itemBrands.includes(activeBrandFilter);

      if (matchesChannel && matchesBrand) {
        colElement.classList.remove('d-none');

        if (activeBrandFilter !== 'all') {
          const cardElement = colElement.querySelector('.pkg-card');
          const matchingRow = cardElement?.querySelector(`.pkg-brand-row[data-brand-row="${activeBrandFilter}"]`);
          if (cardElement && matchingRow) {
            updateCardBrandSelection(cardElement, matchingRow);
          }
        }
      } else {
        colElement.classList.add('d-none');
      }
    });
  }

  chFilterBtns.forEach((filterBtn) => {
    filterBtn.addEventListener('click', () => {
      chFilterBtns.forEach((btnItem) => btnItem.classList.remove('active'));
      filterBtn.classList.add('active');
      activeChannelFilter = filterBtn.getAttribute('data-ch') || 'all';
      applyPackageFilters();
    });
  });

  brandFilterBtns.forEach((brandBtn) => {
    brandBtn.addEventListener('click', () => {
      brandFilterBtns.forEach((btnItem) => btnItem.classList.remove('active'));
      brandBtn.classList.add('active');
      activeBrandFilter = (brandBtn.getAttribute('data-brand') || 'all').toLowerCase();
      applyPackageFilters();
    });
  });

  // Allow clicking individual brand price rows inside any package card
  pkgCards.forEach((cardElement) => {
    const brandRows = cardElement.querySelectorAll('.pkg-brand-row');
    brandRows.forEach((rowElement) => {
      rowElement.addEventListener('click', () => {
        updateCardBrandSelection(cardElement, rowElement);
      });
    });
  });

  // 3. Accurate Analog CCTV Calculator (camPointRange)
  const camPointRange = document.getElementById('camPointRange');
  const camPointValue = document.getElementById('camPointValue');
  const calcChannelDetail = document.getElementById('calcChannelDetail');
  const calcRecommendationText = document.getElementById('calcRecommendationText');
  const calcOrderBtn = document.getElementById('calcOrderBtn');
  const camTickBtns = document.querySelectorAll('.cam-tick-btn');
  const calcBrandBtns = document.querySelectorAll('.calc-brand-btn');

  let activeCalcBrand = 'dahua';

  function updateCamCalculator() {
    if (!camPointRange) return;
    const stepIdx = Math.max(0, Math.min(5, parseInt(camPointRange.value, 10) || 2));
    const stepObj = channelSteps[stepIdx] || channelSteps[2];
    const brandObj = analogPrices[activeCalcBrand] || analogPrices.dahua;
    const priceNum = brandObj.prices[stepObj.key];
    const formattedPrice = formatRupiah(priceNum);

    if (camPointValue) {
      camPointValue.textContent = isIndonesian ? `${stepObj.cams} Kamera` : `${stepObj.cams} Cameras`;
    }
    if (calcChannelDetail) {
      const packageLabel = isIndonesian ? 'Paket Analog' : 'Analog Package';
      calcChannelDetail.textContent = `${brandObj.label} • ${stepObj.key} ${packageLabel}`;
    }
    if (calcRecommendationText) {
      calcRecommendationText.textContent = formattedPrice;
    }
    if (calcOrderBtn) {
      const promoSuffix = isIndonesian ? 'Harga Spesial Website' : 'Special Website Order Price';
      const packageTitle = isIndonesian ? 'Paket CCTV Analog' : 'Analog CCTV Package';
      calcOrderBtn.setAttribute(
        'data-pkg-name',
        `${brandObj.label} ${stepObj.key} ${packageTitle} - ${formattedPrice} (${promoSuffix})`
      );
    }

    camTickBtns.forEach((tickBtn) => {
      const btnIdx = parseInt(tickBtn.getAttribute('data-idx'), 10);
      if (btnIdx === stepIdx) {
        tickBtn.classList.add('active');
      } else {
        tickBtn.classList.remove('active');
      }
    });
  }

  if (camPointRange) {
    camPointRange.addEventListener('input', updateCamCalculator);

    camTickBtns.forEach((tickBtn) => {
      tickBtn.addEventListener('click', () => {
        const idxValue = tickBtn.getAttribute('data-idx');
        camPointRange.value = idxValue;
        updateCamCalculator();
      });
    });

    calcBrandBtns.forEach((calcBtn) => {
      calcBtn.addEventListener('click', () => {
        calcBrandBtns.forEach((btnItem) => btnItem.classList.remove('active'));
        calcBtn.classList.add('active');
        activeCalcBrand = calcBtn.getAttribute('data-calc-brand') || 'dahua';
        updateCamCalculator();
      });
    });

    updateCamCalculator();
  }

  // 4. WhatsApp Order Modal Pre-fill & Redirect (+62 878-5513-0070)
  const waOrderModal = document.getElementById('waOrderModal');
  const modalPkgInput = document.getElementById('modalPkgInput');
  const waQuickForm = document.getElementById('waQuickForm');

  if (waOrderModal) {
    waOrderModal.addEventListener('show.bs.modal', (modalEvent) => {
      const triggerButton = modalEvent.relatedTarget;
      const pkgName = triggerButton
        ? triggerButton.getAttribute('data-pkg-name')
        : 'CCTV Package Consultation (Special Website Order Price)';
      if (modalPkgInput) {
        modalPkgInput.value = pkgName || 'CCTV Package Consultation';
      }
    });
  }

  if (waQuickForm) {
    waQuickForm.addEventListener('submit', (submitEvent) => {
      submitEvent.preventDefault();
      const selectedPkg = modalPkgInput ? modalPkgInput.value : 'Analog CCTV Package';
      const customerName = document.getElementById('modalUserName')?.value.trim() || 'Customer';
      const locationArea = document.getElementById('modalArea')?.value.trim() || 'Bali';

      const greeting = isIndonesian
        ? 'Halo RV CCTV TECHNOLOGY BALI, saya ingin klaim *Harga Spesial Website*:'
        : 'Hello RV CCTV TECHNOLOGY BALI, I would like to claim the *Special Website Order Price*:';
      const labelName = isIndonesian ? 'Nama' : 'Name';
      const labelPkg = isIndonesian ? 'Pilihan Paket' : 'Selected Package';
      const labelLoc = isIndonesian ? 'Lokasi di Bali' : 'Location in Bali';

      const messageParts = [
        greeting,
        `• ${labelName}: ${customerName}`,
        `• ${labelPkg}: ${selectedPkg}`
      ];

      if (locationArea) {
        messageParts.push(`• ${labelLoc}: ${locationArea}`);
      }

      const messageText = messageParts.join('\n');

      const waPhoneNumber = (document.body.dataset.waPhone || '6287855130070').replace(/[^0-9]/g, '');
      const waUrl = `https://wa.me/${waPhoneNumber}?text=${encodeURIComponent(messageText)}`;
      window.open(waUrl, '_blank', 'noopener,noreferrer');
    });
  }
});

