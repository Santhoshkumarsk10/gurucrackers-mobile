@extends('layouts.mobile')

@section('title', ($shop['name'] ?? 'Guru Crackers') . ' - Sivakasi Direct Orders')

@push('styles')
<style>
    /* Search Bar */
    .search-box-wrap {
        margin: 10px 14px 8px 14px;
        position: relative;
    }
    .search-input {
        width: 100%;
        background: white;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 11px 40px 11px 42px;
        font-size: 0.92rem;
        outline: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.15);
    }
    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
    }
    .search-clear-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: #e2e8f0;
        border: none;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        color: #475569;
        cursor: pointer;
    }
    .search-status-bar {
        display: none;
        padding: 2px 16px 8px 16px;
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 600;
        justify-content: space-between;
        align-items: center;
    }

    /* Banner Carousel */
    .banner-carousel-wrapper {
        position: relative;
        padding-bottom: 6px;
    }
    .banner-container {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        gap: 12px;
        padding: 2px 14px 8px 14px;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }
    .banner-container::-webkit-scrollbar {
        display: none;
    }
    .banner-slide {
        flex: 0 0 92%;
        scroll-snap-align: center;
        border-radius: 18px;
        overflow: hidden;
        aspect-ratio: 16/7;
        background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.09);
        position: relative;
    }
    .banner-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .carousel-dots {
        display: flex;
        justify-content: center;
        gap: 6px;
        padding: 4px 0;
    }
    .carousel-dots .dot {
        width: 6px;
        height: 6px;
        border-radius: 3px;
        background: #cbd5e1;
        transition: all 0.25s ease;
    }
    .carousel-dots .dot.active {
        width: 20px;
        background: var(--primary);
    }

    /* Category Filter Pills */
    .category-scroll {
        display: flex;
        overflow-x: auto;
        gap: 8px;
        padding: 6px 14px 12px 14px;
        scrollbar-width: none;
        position: sticky;
        top: 56px;
        background: var(--bg-body);
        z-index: 90;
    }
    .category-scroll::-webkit-scrollbar {
        display: none;
    }
    .cat-pill {
        white-space: nowrap;
        padding: 7px 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
        background: white;
        border: 1.5px solid #e2e8f0;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .cat-pill .pill-count {
        background: #f1f5f9;
        color: #64748b;
        padding: 1px 6px;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 800;
    }
    .cat-pill.active {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border-color: #dc2626;
        color: white;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }
    .cat-pill.active .pill-count {
        background: rgba(255, 255, 255, 0.25);
        color: white;
    }

    /* Category Section */
    .category-title {
        font-size: 1.05rem;
        font-weight: 800;
        margin: 16px 14px 10px 14px;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .category-title i {
        color: var(--primary);
        font-size: 14px;
    }
    .category-badge-count {
        font-size: 0.72rem;
        background: #f1f5f9;
        color: #64748b;
        padding: 2px 8px;
        border-radius: 12px;
        font-weight: 700;
        margin-left: auto;
    }

    /* Product Card */
    .product-card {
        background: white;
        border-radius: 16px;
        padding: 12px;
        margin: 0 14px 10px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1.5px solid #f1f5f9;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    .product-card.in-cart {
        border-color: #86efac;
        background: #f0fdf4;
        box-shadow: 0 4px 14px rgba(22, 163, 74, 0.12);
    }
    .prod-img-wrap {
        width: 78px;
        height: 78px;
        border-radius: 14px;
        background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #fed7aa;
        position: relative;
    }
    .prod-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .prod-info {
        flex: 1;
        min-width: 0;
    }
    .prod-name {
        font-size: 0.92rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.3;
    }
    .prod-tamil {
        font-size: 0.8rem;
        color: #64748b;
        margin-top: 2px;
        font-weight: 600;
    }
    .prod-pricing {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-top: 6px;
        flex-wrap: wrap;
    }
    .net-rate {
        font-size: 1.12rem;
        font-weight: 800;
        color: #16a34a;
    }
    .actual-rate {
        font-size: 0.78rem;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .discount-pill {
        font-size: 0.65rem;
        font-weight: 800;
        background: #fee2e2;
        color: #dc2626;
        padding: 2px 6px;
        border-radius: 6px;
        letter-spacing: 0.2px;
    }

    /* Stepper */
    .stepper {
        display: flex;
        align-items: center;
        background: #f1f5f9;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .product-card.in-cart .stepper {
        border-color: #86efac;
        background: white;
    }
    .stepper-btn {
        width: 34px;
        height: 34px;
        border: none;
        background: transparent;
        color: #0f172a;
        font-size: 16px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        user-select: none;
        -webkit-user-select: none;
    }
    .stepper-btn:active {
        background: #e2e8f0;
    }
    .stepper-btn.add-btn {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
    }
    .product-card.in-cart .stepper-btn.add-btn {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
    }
    .stepper-val {
        width: 28px;
        text-align: center;
        font-size: 0.88rem;
        font-weight: 800;
        color: #0f172a;
    }

    /* Floating Cart Bar */
    .floating-cart-bar {
        position: fixed;
        bottom: calc(66px + var(--safe-bottom));
        left: 14px;
        right: 14px;
        z-index: 999;
        background: linear-gradient(135deg, #15803d 0%, #166534 100%);
        color: white;
        border-radius: 18px;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 25px rgba(21, 128, 61, 0.45);
        animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    @keyframes slideUp {
        from { transform: translateY(40px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .cart-summary-text {
        display: flex;
        flex-direction: column;
    }
    .cart-summary-qty {
        font-size: 0.72rem;
        opacity: 0.92;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .cart-save-badge {
        background: #fef08a;
        color: #854d0e;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 1px 6px;
        border-radius: 6px;
    }
    .cart-summary-prices {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }
    .cart-summary-total {
        font-size: 1.2rem;
        font-weight: 800;
    }
    .cart-summary-mrp {
        font-size: 0.78rem;
        text-decoration: line-through;
        opacity: 0.75;
    }
    .cart-btn-action {
        background: #ffffff;
        color: #15803d;
        font-weight: 800;
        font-size: 0.88rem;
        padding: 10px 18px;
        border-radius: 14px;
        border: none;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.18);
        transition: transform 0.15s;
        cursor: pointer;
    }
    .cart-btn-action:active {
        transform: scale(0.96);
    }

    /* Modal / Drawer */
    .drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        z-index: 2000;
        display: none;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .drawer-overlay.active {
        display: block;
        opacity: 1;
    }
    .drawer-sheet {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 26px 26px 0 0;
        z-index: 2001;
        max-height: 92vh;
        overflow-y: auto;
        transform: translateY(100%);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        padding-bottom: calc(24px + var(--safe-bottom));
        box-shadow: 0 -10px 40px rgba(0,0,0,0.25);
    }
    .drawer-sheet.active {
        transform: translateY(0);
    }
    .drawer-handle-bar {
        width: 44px;
        height: 5px;
        background: #cbd5e1;
        border-radius: 3px;
        margin: 10px auto 4px auto;
    }
    .drawer-header {
        padding: 12px 20px 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
    }
    .drawer-close {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #f1f5f9;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #64748b;
        cursor: pointer;
    }

    /* Cart item rows in drawer */
    .drawer-cart-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #e2e8f0;
        gap: 10px;
    }
    .drawer-cart-item-info {
        flex: 1;
        min-width: 0;
    }
    .drawer-cart-item-title {
        font-weight: 700;
        font-size: 0.88rem;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .drawer-cart-item-rate {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 2px;
    }
    .drawer-cart-stepper {
        display: flex;
        align-items: center;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .drawer-cart-stepper button {
        width: 28px;
        height: 28px;
        border: none;
        background: transparent;
        font-weight: 800;
        color: #0f172a;
        font-size: 13px;
        cursor: pointer;
    }
    .drawer-cart-stepper span {
        width: 24px;
        text-align: center;
        font-size: 0.82rem;
        font-weight: 800;
    }
    .drawer-cart-row-total {
        font-weight: 800;
        font-size: 0.92rem;
        color: #16a34a;
        min-width: 60px;
        text-align: right;
    }

    /* Price breakdown card */
    .price-breakdown-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 14px 16px;
        margin: 16px 0;
        border: 1px solid #e2e8f0;
    }
    .breakdown-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.82rem;
        color: #64748b;
        margin-bottom: 6px;
    }
    .breakdown-row.highlight {
        color: #16a34a;
        font-weight: 700;
    }
    .breakdown-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 8px 0;
    }
    .breakdown-total {
        display: flex;
        justify-content: space-between;
        font-weight: 800;
        font-size: 1.05rem;
        color: #0f172a;
    }

    /* Form Inputs */
    .form-group {
        margin-bottom: 12px;
        position: relative;
    }
    .form-label {
        display: block;
        font-size: 0.78rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 5px;
    }
    .form-input {
        width: 100%;
        padding: 11px 14px;
        border-radius: 12px;
        border: 1.5px solid #cbd5e1;
        font-size: 0.92rem;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }
    .form-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }
</style>
@endpush

@section('content')
    <!-- App Header -->
    <header class="app-header">
        <div class="header-content">
            <div class="brand-info">
                <div class="brand-icon" id="headerLogoWrap">
                    @if(!empty($shop['logo_url']))
                        <img id="headerLogoImg" src="{{ $shop['logo_url'] }}" alt="Guru Crackers">
                    @else
                        <i class="fa-solid fa-burst" style="color: #dc2626; font-size: 20px;"></i>
                    @endif
                </div>
                <div>
                    <h1 class="brand-title">{{ $shop['name'] ?? 'Guru Crackers' }}</h1>
                    <span class="brand-subtitle"><i class="fa-solid fa-shield-halved"></i> Sivakasi Factory Direct Rates</span>
                </div>
            </div>
            <div class="header-actions">
                <a href="tel:{{ $shop['phone'] ?? '9789874381' }}" class="header-btn" title="Call Store">
                    <i class="fa-solid fa-phone"></i>
                </a>
                <a href="https://wa.me/91{{ $shop['phone'] ?? '9789874381' }}?text=Hello%20Guru%20Crackers,%20I%20want%20to%20place%20an%20order" target="_blank" class="header-btn" title="WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Search Input -->
    <div class="search-box-wrap">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
        <input type="text" id="productSearch" class="search-input" placeholder="Search crackers by English or தமிழ் name..." oninput="filterProducts()">
        <button type="button" id="searchClearBtn" class="search-clear-btn" onclick="clearSearch()">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div id="searchStatusBar" class="search-status-bar">
        <span id="searchResultCount">Showing all crackers</span>
        <a href="javascript:void(0)" onclick="clearSearch()" style="color: var(--primary); text-decoration: none;">Clear</a>
    </div>

    <!-- Banner Carousel -->
    @if(!empty($banners) && count($banners) > 0)
        <div class="banner-carousel-wrapper">
            <div class="banner-container" id="bannerContainer">
                @foreach($banners as $index => $banner)
                    @if(!empty($banner['image_url']))
                        <div class="banner-slide" data-index="{{ $index }}">
                            <img src="{{ $banner['image_url'] }}" alt="Festival Banner" loading="lazy">
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="carousel-dots" id="carouselDots">
                @foreach($banners as $index => $banner)
                    <span class="dot {{ $index === 0 ? 'active' : '' }}" onclick="scrollToBanner({{ $index }})"></span>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Category Filter Pills -->
    <div class="category-scroll" id="categoryScroll">
        <a href="javascript:void(0)" class="cat-pill active" onclick="selectCategory(null, this)">
            <span>All Crackers</span>
            <span class="pill-count" id="pill-count-all">
                {{ collect($categories)->sum(fn($c) => count($c['products'] ?? [])) }}
            </span>
        </a>
        @foreach($categories as $cat)
            <a href="javascript:void(0)" class="cat-pill" onclick="selectCategory({{ $cat['id'] }}, this)" data-cat-id="{{ $cat['id'] }}">
                <span>{{ $cat['name'] }}</span>
                <span class="pill-count">{{ count($cat['products'] ?? []) }}</span>
            </a>
        @endforeach
    </div>

    <!-- Product Catalog List -->
    <main class="page-content" id="catalogContent">
        @forelse($categories as $cat)
            <div class="category-group" data-cat-id="{{ $cat['id'] }}">
                <h2 class="category-title">
                    <i class="fa-solid fa-burst"></i>
                    <span>{{ $cat['name'] }}</span>
                    <span class="category-badge-count">{{ count($cat['products'] ?? []) }} Items</span>
                </h2>

                <div class="products-list">
                    @foreach($cat['products'] as $prod)
                        @php
                            $discountPercent = $prod['actual_rate'] > $prod['net_rate'] 
                                ? round((($prod['actual_rate'] - $prod['net_rate']) / $prod['actual_rate']) * 100) 
                                : 0;
                        @endphp
                        <div class="product-card" 
                             id="prod-card-{{ $prod['id'] }}"
                             data-prod-id="{{ $prod['id'] }}" 
                             data-rate="{{ $prod['net_rate'] }}"
                             data-actual-rate="{{ $prod['actual_rate'] ?? $prod['net_rate'] }}"
                             data-name-clean="{{ $prod['name'] }}"
                             data-tamil-clean="{{ $prod['tamil_name'] ?? '' }}"
                             data-name="{{ strtolower($prod['name']) }}" 
                             data-tamil="{{ strtolower($prod['tamil_name'] ?? '') }}">
                            
                            <div class="prod-img-wrap">
                                @if(!empty($prod['image_url']))
                                    <img src="{{ $prod['image_url'] }}" alt="{{ $prod['name'] }}" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display: none; align-items: center; justify-content: center; width: 100%; height: 100%;">
                                        <i class="fa-solid fa-fire text-danger" style="font-size: 26px; color: #dc2626;"></i>
                                    </div>
                                @else
                                    <i class="fa-solid fa-fire text-danger" style="font-size: 26px; color: #dc2626;"></i>
                                @endif
                            </div>

                            <div class="prod-info">
                                <div class="prod-name">{{ $prod['name'] }}</div>
                                @if(!empty($prod['tamil_name']))
                                    <div class="prod-tamil tamil-text">{{ $prod['tamil_name'] }}</div>
                                @endif
                                
                                <div class="prod-pricing">
                                    <span class="net-rate">₹{{ number_format($prod['net_rate'], 0) }}</span>
                                    @if($discountPercent > 0)
                                        <span class="actual-rate">₹{{ number_format($prod['actual_rate'], 0) }}</span>
                                        <span class="discount-pill">{{ $discountPercent }}% OFF</span>
                                    @endif
                                </div>
                            </div>

                            <div class="stepper">
                                <button type="button" class="stepper-btn" onclick="handleStepperClick(this, -1)">-</button>
                                <span class="stepper-val" id="qty-val-{{ $prod['id'] }}">0</span>
                                <button type="button" class="stepper-btn add-btn" onclick="handleStepperClick(this, 1)">+</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div id="loadingOrEmptyState" style="text-align: center; padding: 50px 20px; color: #64748b;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 32px; color: var(--primary); margin-bottom: 14px;"></i>
                <p style="font-weight: 700; color: #1e293b; font-size: 1rem;">Connecting to Guru Crackers Store...</p>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;">Loading latest prices and categories</p>
            </div>
        @endforelse
    </main>

    <!-- Floating Cart Bar -->
    <div id="floatingCart" class="floating-cart-bar" style="display: none;">
        <div class="cart-summary-text">
            <div class="cart-summary-qty">
                <span id="cartBarQty">0 Items</span>
                <span id="cartBarSave" class="cart-save-badge">Save ₹0</span>
            </div>
            <div class="cart-summary-prices">
                <span class="cart-summary-total" id="cartBarTotal">₹0</span>
                <span class="cart-summary-mrp" id="cartBarMrp">₹0</span>
            </div>
        </div>
        <button type="button" class="cart-btn-action" onclick="openCartDrawer()">
            <span>View Cart</span>
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <!-- Cart & Checkout Drawer -->
    <div id="drawerOverlay" class="drawer-overlay" onclick="closeCartDrawer()"></div>
    <div id="drawerSheet" class="drawer-sheet">
        <div class="drawer-handle-bar"></div>
        <div class="drawer-header">
            <div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a;">Your Cart & Checkout</h3>
                <span style="font-size: 0.75rem; color: #64748b;">Sivakasi Factory Direct Wholesale Rates</span>
            </div>
            <button type="button" class="drawer-close" onclick="closeCartDrawer()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div style="padding: 14px 20px;">
            <!-- Cart Items List -->
            <div id="drawerCartItems" style="margin-bottom: 14px; max-height: 240px; overflow-y: auto;">
                <!-- Populated via JS -->
            </div>

            <!-- Price Breakdown -->
            <div class="price-breakdown-card">
                <div class="breakdown-row">
                    <span>Total Cracker MRP:</span>
                    <span id="drawerTotalMrp">₹0</span>
                </div>
                <div class="breakdown-row highlight">
                    <span>Special Sivakasi Discount:</span>
                    <span id="drawerTotalDiscount">-₹0</span>
                </div>
                <div class="breakdown-row">
                    <span>Packing & Handling:</span>
                    <span style="color: #16a34a; font-weight: 700;">FREE</span>
                </div>
                <div class="breakdown-divider"></div>
                <div class="breakdown-total">
                    <span>Final Amount:</span>
                    <span id="drawerGrandTotal" style="color: #16a34a;">₹0</span>
                </div>
            </div>

            <!-- Customer Details Form -->
            <form id="checkoutForm" onsubmit="handleCheckout(event)">
                <div class="form-group">
                    <label class="form-label">Customer Full Name *</label>
                    <input type="text" id="cust_name" name="name" class="form-input" placeholder="e.g. Santhosh Kumar" required minlength="3">
                </div>

                <div class="form-group">
                    <label class="form-label">WhatsApp / Mobile Number (10 Digits) *</label>
                    <input type="tel" id="cust_phone1" name="phone1" class="form-input" placeholder="e.g. 9876543210" pattern="[6-9][0-9]{9}" maxlength="10" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Alternate Phone Number (Optional)</label>
                    <input type="tel" id="cust_phone2" name="phone2" class="form-input" placeholder="Secondary mobile" pattern="[6-9][0-9]{9}" maxlength="10">
                </div>

                <div class="form-group">
                    <label class="form-label">Delivery Address / Street *</label>
                    <textarea id="cust_address" name="delivery_address" class="form-input" rows="2" placeholder="Door No, Street name, Area landmark" required minlength="5"></textarea>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1.2;">
                        <label class="form-label">City / Town *</label>
                        <input type="text" id="cust_city" name="city" class="form-input" placeholder="e.g. Madurai" required>
                    </div>
                    <div class="form-group" style="flex: 0.8;">
                        <label class="form-label">Pincode *</label>
                        <input type="tel" id="cust_pincode" name="pincode" class="form-input" placeholder="6 digits" pattern="[0-9]{6}" maxlength="6" required>
                    </div>
                </div>

                <input type="hidden" name="state" value="Tamil Nadu">

                <div id="checkoutError" style="display: none; padding: 12px 14px; background: #fee2e2; color: #dc2626; border-radius: 12px; font-size: 0.84rem; font-weight: 700; margin-bottom: 12px; border: 1px solid #fca5a5;"></div>

                <button type="submit" id="submitOrderBtn" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; border: none; border-radius: 14px; font-weight: 800; font-size: 1rem; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.35); display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer;">
                    <i class="fa-solid fa-lock"></i>
                    <span>Confirm & Proceed to Payment</span>
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Cart storage state
    let cart = JSON.parse(localStorage.getItem('guru_cracker_cart') || '{}');

    function saveCart() {
        localStorage.setItem('guru_cracker_cart', JSON.stringify(cart));
        renderCartUI();
    }

    function handleStepperClick(btn, delta) {
        const card = btn.closest('.product-card');
        if (!card) return;
        const id = card.getAttribute('data-prod-id');
        const name = card.getAttribute('data-name-clean');
        const rate = parseFloat(card.getAttribute('data-rate'));
        const actualRate = parseFloat(card.getAttribute('data-actual-rate') || rate);
        const tamil = card.getAttribute('data-tamil-clean') || '';
        updateQty(id, delta, rate, name, actualRate, tamil);
    }

    function updateQty(id, delta, rate, name, actualRate = 0, tamilName = '') {
        actualRate = actualRate || rate;
        if (!cart[id]) {
            cart[id] = {
                id: id,
                qty: 0,
                rate: rate,
                actualRate: actualRate,
                name: name,
                tamilName: tamilName
            };
        }
        cart[id].qty += delta;
        if (cart[id].qty <= 0) {
            delete cart[id];
        }
        saveCart();
    }

    function renderCartUI() {
        let totalItems = 0;
        let totalPrice = 0;
        let totalMrp = 0;

        // Reset all card steppers & in-cart classes
        document.querySelectorAll('.stepper-val').forEach(el => el.textContent = '0');
        document.querySelectorAll('.product-card').forEach(card => card.classList.remove('in-cart'));

        for (const [id, item] of Object.entries(cart)) {
            const valEl = document.getElementById(`qty-val-${id}`);
            if (valEl) valEl.textContent = item.qty;

            const card = document.getElementById(`prod-card-${id}`);
            if (card && item.qty > 0) {
                card.classList.add('in-cart');
            }

            totalItems += item.qty;
            totalPrice += item.qty * item.rate;
            totalMrp += item.qty * (item.actualRate || item.rate);
        }

        const totalSavings = Math.max(0, totalMrp - totalPrice);

        // Update Bottom Nav Badge
        const navBadge = document.getElementById('nav-cart-badge');
        if (navBadge) {
            navBadge.textContent = totalItems;
            navBadge.style.display = totalItems > 0 ? 'flex' : 'none';
        }

        // Update Floating Cart Bar
        const bar = document.getElementById('floatingCart');
        if (bar) {
            if (totalItems > 0) {
                bar.style.display = 'flex';
                document.getElementById('cartBarQty').textContent = `${totalItems} ${totalItems === 1 ? 'Item' : 'Items'} Added`;
                document.getElementById('cartBarTotal').textContent = `₹${totalPrice.toLocaleString('en-IN')}`;
                
                const mrpEl = document.getElementById('cartBarMrp');
                const saveEl = document.getElementById('cartBarSave');
                if (totalSavings > 0) {
                    mrpEl.style.display = 'inline';
                    mrpEl.textContent = `₹${totalMrp.toLocaleString('en-IN')}`;
                    saveEl.style.display = 'inline-block';
                    saveEl.textContent = `Save ₹${totalSavings.toLocaleString('en-IN')}`;
                } else {
                    mrpEl.style.display = 'none';
                    saveEl.style.display = 'none';
                }
            } else {
                bar.style.display = 'none';
            }
        }

        // Populate Drawer Items List
        const drawerContainer = document.getElementById('drawerCartItems');
        if (drawerContainer) {
            if (totalItems === 0) {
                drawerContainer.innerHTML = `
                    <div style="text-align: center; padding: 30px 10px; color: #94a3b8;">
                        <i class="fa-solid fa-cart-shopping" style="font-size: 38px; margin-bottom: 10px; color: #cbd5e1;"></i>
                        <p style="font-weight: 700; color: #475569;">Your cart is empty</p>
                        <p style="font-size: 0.8rem;">Add your favorite crackers from the catalog above</p>
                    </div>
                `;
            } else {
                let html = '';
                for (const [id, item] of Object.entries(cart)) {
                    html += `
                        <div class="drawer-cart-row">
                            <div class="drawer-cart-item-info">
                                <div class="drawer-cart-item-title">${item.name}</div>
                                <div class="drawer-cart-item-rate">₹${item.rate} × ${item.qty}</div>
                            </div>
                            <div class="drawer-cart-stepper">
                                <button type="button" onclick="updateQty(${item.id}, -1, ${item.rate}, ${JSON.stringify(item.name)}, ${item.actualRate || item.rate})">-</button>
                                <span>${item.qty}</span>
                                <button type="button" onclick="updateQty(${item.id}, 1, ${item.rate}, ${JSON.stringify(item.name)}, ${item.actualRate || item.rate})">+</button>
                            </div>
                            <div class="drawer-cart-row-total">₹${(item.rate * item.qty).toLocaleString('en-IN')}</div>
                        </div>
                    `;
                }
                drawerContainer.innerHTML = html;
            }

            document.getElementById('drawerTotalMrp').textContent = `₹${totalMrp.toLocaleString('en-IN')}`;
            document.getElementById('drawerTotalDiscount').textContent = `-₹${totalSavings.toLocaleString('en-IN')}`;
            document.getElementById('drawerGrandTotal').textContent = `₹${totalPrice.toLocaleString('en-IN')}`;
        }
    }

    function openCartDrawer() {
        document.getElementById('drawerOverlay').classList.add('active');
        document.getElementById('drawerSheet').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeCartDrawer() {
        document.getElementById('drawerOverlay').classList.remove('active');
        document.getElementById('drawerSheet').classList.remove('active');
        document.body.style.overflow = '';
    }

    function selectCategory(catId, btn) {
        document.querySelectorAll('.cat-pill').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');

        // Scroll pill into view smoothly
        btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

        const groups = document.querySelectorAll('.category-group');
        groups.forEach(group => {
            if (!catId || group.getAttribute('data-cat-id') == catId) {
                group.style.display = 'block';
            } else {
                group.style.display = 'none';
            }
        });

        // Reset search input if any
        if (document.getElementById('productSearch').value.trim() !== '') {
            clearSearch();
        }
    }

    function filterProducts() {
        const query = document.getElementById('productSearch').value.toLowerCase().trim();
        const clearBtn = document.getElementById('searchClearBtn');
        const statusBar = document.getElementById('searchStatusBar');
        const resultCountEl = document.getElementById('searchResultCount');
        const cards = document.querySelectorAll('.product-card');

        if (query.length > 0) {
            clearBtn.style.display = 'flex';
            statusBar.style.display = 'flex';
        } else {
            clearBtn.style.display = 'none';
            statusBar.style.display = 'none';
        }

        let visibleCount = 0;
        cards.forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const tamil = card.getAttribute('data-tamil') || '';
            if (name.includes(query) || tamil.includes(query)) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide category titles based on visible children
        document.querySelectorAll('.category-group').forEach(group => {
            const visibleInGroup = group.querySelectorAll('.product-card[style*="display: flex"]').length;
            const hasAnyVisible = query === '' ? true : (visibleInGroup > 0);
            group.style.display = hasAnyVisible ? 'block' : 'none';
        });

        if (resultCountEl) {
            resultCountEl.textContent = `Found ${visibleCount} ${visibleCount === 1 ? 'cracker' : 'crackers'} matching "${query}"`;
        }
    }

    function clearSearch() {
        const input = document.getElementById('productSearch');
        input.value = '';
        document.getElementById('searchClearBtn').style.display = 'none';
        document.getElementById('searchStatusBar').style.display = 'none';
        document.querySelectorAll('.product-card').forEach(card => card.style.display = 'flex');
        document.querySelectorAll('.category-group').forEach(group => group.style.display = 'block');
    }

    // Carousel Dot Sync & Auto Scroll
    function scrollToBanner(index) {
        const container = document.getElementById('bannerContainer');
        const slides = container ? container.querySelectorAll('.banner-slide') : [];
        if (slides[index]) {
            slides[index].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }

    const bannerContainer = document.getElementById('bannerContainer');
    if (bannerContainer) {
        bannerContainer.addEventListener('scroll', () => {
            const scrollLeft = bannerContainer.scrollLeft;
            const width = bannerContainer.offsetWidth * 0.92;
            const activeIndex = Math.round(scrollLeft / width);
            const dots = document.querySelectorAll('.carousel-dots .dot');
            dots.forEach((dot, idx) => {
                dot.classList.toggle('active', idx === activeIndex);
            });
        });

        // Auto Advance carousel every 4.5s
        let bannerIdx = 0;
        setInterval(() => {
            const slides = bannerContainer.querySelectorAll('.banner-slide');
            if (slides.length <= 1) return;
            bannerIdx = (bannerIdx + 1) % slides.length;
            scrollToBanner(bannerIdx);
        }, 4500);
    }

    // Client-side Checkout
    async function handleCheckout(event) {
        event.preventDefault();
        const errEl = document.getElementById('checkoutError');
        errEl.style.display = 'none';

        if (Object.keys(cart).length === 0) {
            errEl.textContent = 'Please add at least one product to your cart.';
            errEl.style.display = 'block';
            return;
        }

        const btn = document.getElementById('submitOrderBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing Order...';

        const payload = {
            name: document.getElementById('cust_name').value.trim(),
            phone1: document.getElementById('cust_phone1').value.trim(),
            phone2: document.getElementById('cust_phone2').value.trim() || null,
            delivery_address: document.getElementById('cust_address').value.trim(),
            city: document.getElementById('cust_city').value.trim(),
            state: 'Tamil Nadu',
            pincode: document.getElementById('cust_pincode').value.trim(),
            products: {}
        };

        for (const [id, item] of Object.entries(cart)) {
            payload.products[id] = { qty: item.qty };
        }

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('{{ route("mobile.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (data.success && data.order_number) {
                // Clear local cart
                localStorage.removeItem('guru_cracker_cart');
                cart = {};
                window.location.href = `/order-success/${data.order_number}`;
            } else {
                errEl.textContent = data.message || 'Validation failed. Please check the details you entered.';
                errEl.style.display = 'block';
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-lock"></i> Confirm & Proceed to Payment';
            }
        } catch (e) {
            console.error('Checkout error:', e);
            errEl.textContent = 'Network error connecting to store. Please check your internet connection.';
            errEl.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-lock"></i> Confirm & Proceed to Payment';
        }
    }

    // Dynamic Live Catalog Loader Fallback
    async function checkAndLoadLiveCatalog() {
        const existingProducts = document.querySelectorAll('.product-card');
        if (existingProducts.length > 0) return;

        const mainContent = document.getElementById('catalogContent');
        if (mainContent) {
            mainContent.innerHTML = `
                <div style="text-align: center; padding: 50px 20px; color: #64748b;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size: 32px; color: var(--primary); margin-bottom: 14px;"></i>
                    <p style="font-weight: 700; color: #1e293b; font-size: 1rem;">Connecting to Guru Crackers Store...</p>
                    <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;">Loading latest prices and categories</p>
                </div>
            `;
        }

        try {
            const apiBase = "{{ $backendUrl ?? 'http://192.168.1.8:8000' }}";
            const res = await fetch(apiBase + '/api/v1/catalog', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();

            if (data.success && data.categories && data.categories.length > 0) {
                renderCategoriesAndProducts(data.categories);
            } else {
                showRetryUI('No products found in store catalog.');
            }
        } catch (err) {
            console.error('Client fetch failed:', err);
            showRetryUI('Could not connect to store server. Please verify Wi-Fi connection.');
        }
    }

    function showRetryUI(msg) {
        const mainContent = document.getElementById('catalogContent');
        if (!mainContent) return;
        mainContent.innerHTML = `
            <div style="text-align: center; padding: 40px 20px; color: #dc2626;">
                <i class="fa-solid fa-wifi" style="font-size: 36px; margin-bottom: 12px; color: #cbd5e1;"></i>
                <p style="font-weight: 700; color: #0f172a;">Unable to load crackers catalog</p>
                <p style="font-size: 0.82rem; color: #64748b; margin: 6px 0 16px 0;">${msg}</p>
                <button type="button" onclick="checkAndLoadLiveCatalog()" style="padding: 10px 24px; background: var(--primary); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 0.9rem; cursor: pointer;">
                    <i class="fa-solid fa-rotate-right"></i> Retry Connection
                </button>
            </div>
        `;
    }

    function renderCategoriesAndProducts(categories) {
        // Category Pills
        const catScroll = document.getElementById('categoryScroll');
        if (catScroll) {
            let totalProds = 0;
            categories.forEach(c => totalProds += (c.products ? c.products.length : 0));

            let pillsHtml = `
                <a href="javascript:void(0)" class="cat-pill active" onclick="selectCategory(null, this)">
                    <span>All Crackers</span>
                    <span class="pill-count">${totalProds}</span>
                </a>
            `;
            categories.forEach(cat => {
                const count = cat.products ? cat.products.length : 0;
                pillsHtml += `
                    <a href="javascript:void(0)" class="cat-pill" onclick="selectCategory(${cat.id}, this)" data-cat-id="${cat.id}">
                        <span>${cat.name}</span>
                        <span class="pill-count">${count}</span>
                    </a>
                `;
            });
            catScroll.innerHTML = pillsHtml;
        }

        // Product Groups
        const mainContent = document.getElementById('catalogContent');
        if (!mainContent) return;

        let contentHtml = '';
        categories.forEach(cat => {
            if (!cat.products || cat.products.length === 0) return;

            contentHtml += `
                <div class="category-group" data-cat-id="${cat.id}">
                    <h2 class="category-title">
                        <i class="fa-solid fa-burst"></i>
                        <span>${cat.name}</span>
                        <span class="category-badge-count">${cat.products.length} Items</span>
                    </h2>
                    <div class="products-list">
            `;

            cat.products.forEach(prod => {
                const imgTag = prod.image_url 
                    ? `<img src="${prod.image_url}" alt="${prod.name}" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                       <div style="display: none; align-items: center; justify-content: center; width: 100%; height: 100%;">
                           <i class="fa-solid fa-fire text-danger" style="font-size: 26px; color: #dc2626;"></i>
                       </div>` 
                    : `<i class="fa-solid fa-fire text-danger" style="font-size: 26px; color: #dc2626;"></i>`;

                const discountPercent = prod.actual_rate > prod.net_rate 
                    ? Math.round(((prod.actual_rate - prod.net_rate) / prod.actual_rate) * 100) 
                    : 0;

                const discountBadge = discountPercent > 0 
                    ? `<span class="actual-rate">₹${prod.actual_rate}</span><span class="discount-pill">${discountPercent}% OFF</span>` 
                    : '';

                const tamilHtml = prod.tamil_name 
                    ? `<div class="prod-tamil tamil-text">${prod.tamil_name}</div>` 
                    : '';

                const safeName = (prod.name || '').replace(/"/g, '&quot;');
                const safeTamil = (prod.tamil_name || '').replace(/"/g, '&quot;');

                contentHtml += `
                    <div class="product-card" 
                         id="prod-card-${prod.id}" 
                         data-prod-id="${prod.id}" 
                         data-rate="${prod.net_rate}"
                         data-actual-rate="${prod.actual_rate || prod.net_rate}"
                         data-name-clean="${safeName}"
                         data-tamil-clean="${safeTamil}"
                         data-name="${prod.name.toLowerCase()}" 
                         data-tamil="${(prod.tamil_name || '').toLowerCase()}">
                        <div class="prod-img-wrap">${imgTag}</div>
                        <div class="prod-info">
                            <div class="prod-name">${prod.name}</div>
                            ${tamilHtml}
                            <div class="prod-pricing">
                                <span class="net-rate">₹${prod.net_rate}</span>
                                ${discountBadge}
                            </div>
                        </div>
                        <div class="stepper">
                            <button type="button" class="stepper-btn" onclick="handleStepperClick(this, -1)">-</button>
                            <span class="stepper-val" id="qty-val-${prod.id}">0</span>
                            <button type="button" class="stepper-btn add-btn" onclick="handleStepperClick(this, 1)">+</button>
                        </div>
                    </div>
                `;
            });

            contentHtml += `</div></div>`;
        });

        mainContent.innerHTML = contentHtml;
        renderCartUI();
    }

    // Initialize UI on load
    document.addEventListener('DOMContentLoaded', () => {
        renderCartUI();
        checkAndLoadLiveCatalog();
    });
</script>
@endpush
