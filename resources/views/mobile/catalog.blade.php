@extends('layouts.mobile')

@section('title', ($shop['name'] ?? 'Guru Crackers') . ' - Sivakasi Direct Orders')

@push('styles')
<style>
    /* Sticky Category Pills Bar (Eliminates Endless Scroll) */
    .sticky-nav-section {
        position: sticky;
        top: 0;
        z-index: 95;
        background: #f8fafc;
        padding-top: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    /* Search Bar */
    .search-box-wrap {
        margin: 6px 14px 6px 14px;
        position: relative;
    }
    .search-input {
        width: 100%;
        background: white;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 10px 38px 10px 40px;
        font-size: 0.90rem;
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
        font-size: 15px;
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
        padding: 2px 16px 6px 16px;
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 600;
        justify-content: space-between;
        align-items: center;
    }

    /* Category Scrollable Pills */
    .category-scroll {
        display: flex;
        overflow-x: auto;
        padding: 4px 14px 10px 14px;
        gap: 8px;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
        background: #f8fafc;
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
        color: #475569;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        flex-shrink: 0;
    }
    .cat-pill.active {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        border-color: #dc2626;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        transform: scale(1.02);
    }
    .cat-pill .pill-count {
        background: rgba(0,0,0,0.08);
        padding: 2px 6px;
        border-radius: 10px;
        font-size: 0.7rem;
    }
    .cat-pill.active .pill-count {
        background: rgba(255,255,255,0.25);
        color: white;
    }

    /* Banner Carousel */
    .banner-carousel-wrapper {
        margin: 6px 14px 12px 14px;
        position: relative;
    }
    .banner-container {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        border-radius: 18px;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    }
    .banner-container::-webkit-scrollbar {
        display: none;
    }
    .banner-slide {
        flex: 0 0 100%;
        scroll-snap-align: start;
        border-radius: 18px;
        overflow: hidden;
        background: #1e1b4b;
        aspect-ratio: 16 / 7;
        position: relative;
    }
    .banner-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .carousel-dots {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 6px;
    }
    .dot {
        width: 6px;
        height: 6px;
        border-radius: 3px;
        background: #cbd5e1;
        transition: all 0.25s;
        cursor: pointer;
    }
    .dot.active {
        width: 18px;
        background: var(--primary);
    }

    /* Product Section */
    .category-group {
        margin-bottom: 20px;
        animation: fadeIn 0.25s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .category-title {
        font-size: 0.98rem;
        font-weight: 800;
        color: #0f172a;
        margin: 12px 14px 8px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .category-title-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .category-badge-count {
        font-size: 0.72rem;
        font-weight: 700;
        background: #f1f5f9;
        color: #64748b;
        padding: 3px 8px;
        border-radius: 12px;
    }
    /* 2-Column Modern eCommerce Product Grid */
    .products-list, .products-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        padding: 0 12px;
        margin-bottom: 18px;
    }

    /* Modern eCommerce 2-Column Product Card */
    .product-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1.5px solid #f1f5f9;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s;
    }
    .product-card:active {
        transform: scale(0.985);
    }
    .product-card.in-cart {
        border-color: #16a34a;
        background: #f0fdf4;
        box-shadow: 0 4px 14px rgba(22, 163, 74, 0.16);
    }

    .prod-img-box {
        position: relative;
        width: 100%;
        height: 115px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid #f1f5f9;
    }
    .prod-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.25s ease;
    }
    .prod-img-box img.prod-img-fallback {
        object-fit: contain;
        padding: 10px;
        background: #fff8f8;
    }
    .product-card:hover .prod-img-box img {
        transform: scale(1.04);
    }
    .product-card:hover .prod-img-box img.prod-img-fallback {
        transform: scale(1.02);
    }
    .prod-discount-badge {
        position: absolute;
        top: 6px;
        left: 6px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        font-size: 0.64rem;
        font-weight: 800;
        padding: 2px 6px;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(220, 38, 38, 0.35);
        z-index: 2;
    }

    /* Product Card Content */
    .prod-info-block {
        padding: 8px 10px 6px 10px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .prod-title {
        font-size: 0.84rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.25;
        margin-bottom: 2px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        /* min-height: 32px; */
    }
    .prod-tamil-title {
        font-size: 0.72rem;
        color: #be123c;
        font-weight: 700;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .prod-price-row {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-top: auto;
        padding-top: 2px;
    }
    .prod-price-net {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
    }
    .prod-price-mrp {
        font-size: 0.72rem;
        color: #94a3b8;
        text-decoration: line-through;
        font-weight: 600;
    }

    /* Action Area (Line Total + Touch Stepper) */
    .prod-action-bar {
        padding: 8px 10px 10px 10px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-top: auto;
    }
    .prod-total-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 2px;
    }
    .prod-total-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: 0.5px;
        color: #94a3b8;
    }
    .line-total-display {
        font-size: 0.82rem;
        font-weight: 800;
        color: #64748b;
        transition: color 0.15s ease;
    }
    .line-total-display.active {
        color: #be123c;
    }

    /* Touch-Friendly Quantity Stepper */
    .prod-stepper-ctrl {
        display: flex;
        width: 100%;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 2px;
        justify-content: space-between;
        align-items: center;
        transition: all 0.15s ease;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.03);
    }
    .product-card.in-cart .prod-stepper-ctrl {
        border-color: #f43f5e;
        background: #ffffff;
    }
    .prod-stepper-ctrl:focus-within {
        border-color: #be123c !important;
        background: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(190, 18, 60, 0.12);
    }
    .stepper-ctrl-btn {
        width: 32px;
        height: 32px;
        background: transparent;
        color: #475569;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.1s ease;
    }
    .stepper-ctrl-btn:hover {
        background: #ffffff;
        color: #be123c;
    }
    .stepper-ctrl-btn:active {
        transform: scale(0.90);
        background: #fee2e2;
        color: #be123c;
    }
    .qty-input {
        width: 100%;
        max-width: 52px;
        border: none;
        background: transparent;
        text-align: center;
        font-size: 0.92rem;
        font-weight: 800;
        color: #0f172a;
        outline: none;
        -moz-appearance: textfield;
        padding: 0;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Floating Cart Bar */
    .floating-cart-bar {
        position: fixed;
        bottom: calc(65px + var(--safe-bottom));
        left: 14px;
        right: 14px;
        max-width: 572px;
        margin: 0 auto;
        background: linear-gradient(135deg, #15803d 0%, #166534 100%);
        color: white;
        border-radius: 20px;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 990;
        box-shadow: 0 8px 25px rgba(22, 101, 52, 0.38);
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideUpCart 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes slideUpCart {
        from { transform: translateY(80px); opacity: 0; }
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

    /* ============================================================== */
    /* SINGLE PAGE APP (SPA) COMPONENT VIEWS & HEADERS */
    /* ============================================================== */
    .app-view {
        display: none;
        opacity: 0;
        transition: opacity 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        padding-bottom: calc(90px + var(--safe-bottom));
    }
    #view-track {
        padding-bottom: calc(140px + var(--safe-bottom)) !important;
    }
    #trackResults {
        padding-bottom: 40px;
    }
    .app-view.active {
        display: block;
        opacity: 1;
    }

    .view-top-header {
        position: sticky;
        top: 0;
        z-index: 100;
        background: linear-gradient(135deg, #b91c1c 0%, #881337 50%, #7f1d1d 100%);
        color: white;
        padding: calc(var(--safe-top) + 8px) 14px 12px 14px;
        box-shadow: 0 4px 18px rgba(185, 28, 28, 0.26);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .view-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .view-back-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.20);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        cursor: pointer;
        transition: transform 0.15s, background 0.15s;
    }
    .view-back-btn:active {
        transform: scale(0.92);
        background: rgba(255, 255, 255, 0.35);
    }
    .view-title-wrap h2 {
        font-size: 1.12rem;
        font-weight: 800;
        line-height: 1.2;
        margin: 0;
        color: #ffffff;
    }
    .view-title-wrap p {
        font-size: 0.72rem;
        color: #fef08a;
        font-weight: 700;
        margin: 1px 0 0 0;
    }
    .view-header-action {
        padding: 6px 12px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.28);
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        transition: transform 0.15s;
    }
    .view-header-action:active {
        transform: scale(0.95);
    }

    /* Skeleton Shimmer Loader for Catalog */
    @keyframes shimmerAnim {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    .skeleton-shimmer {
        background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
        background-size: 200% 100%;
        animation: shimmerAnim 1.4s ease-in-out infinite;
        border-radius: 12px;
    }
    .catalog-skeleton-wrap {
        padding: 10px 12px 20px 12px;
        transition: opacity 0.25s ease;
    }
    .sk-banner-box {
        height: 140px;
        border-radius: 18px;
        margin-bottom: 12px;
    }
    .sk-search-bar {
        height: 44px;
        border-radius: 14px;
        margin-bottom: 10px;
    }
    .sk-pills-row {
        display: flex;
        gap: 8px;
        overflow-x: hidden;
        margin-bottom: 14px;
    }
    .sk-pill-item {
        height: 32px;
        border-radius: 20px;
        flex-shrink: 0;
    }
    .sk-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }
    .sk-grid-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        padding: 8px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .sk-grid-thumb {
        width: 100%;
        height: 105px;
        border-radius: 10px;
    }
    .sk-grid-title {
        height: 14px;
        border-radius: 6px;
        width: 80%;
    }
    .sk-grid-price {
        height: 18px;
        border-radius: 6px;
        width: 50%;
    }
    .sk-grid-btn {
        height: 32px;
        border-radius: 10px;
        width: 100%;
        margin-top: 4px;
    }

    /* Empty Cart Screen (Vertically & Horizontally Centered) */
    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }
    .empty-cart-wrapper {
        min-height: calc(100vh - 165px);
        min-height: calc(100dvh - 165px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px 16px;
        box-sizing: border-box;
    }
    .empty-cart-card {
        text-align: center;
        padding: 44px 24px;
        background: white;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        width: 100%;
        max-width: 360px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        animation: fadeInScale 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .empty-cart-icon-circle {
        width: 78px;
        height: 78px;
        border-radius: 50%;
        background: #fef2f2;
        color: #dc2626;
        font-size: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px auto;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.12);
    }
    .empty-cart-explore-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        font-weight: 800;
        padding: 13px 26px;
        border-radius: 14px;
        border: none;
        font-size: 0.94rem;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(220, 38, 38, 0.32);
        margin-top: 18px;
        transition: transform 0.15s;
    }
    .empty-cart-explore-btn:active {
        transform: scale(0.96);
    }

    /* Track Order Screen Styles */
    .track-search-card {
        background: white;
        border-radius: 20px;
        padding: 16px;
        margin: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 18px rgba(0,0,0,0.04);
    }
    .track-tabs-bar {
        display: flex;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 14px;
        margin-bottom: 14px;
    }
    .track-tab-btn {
        flex: 1;
        text-align: center;
        padding: 8px 10px;
        font-size: 0.80rem;
        font-weight: 700;
        color: #64748b;
        border: none;
        background: transparent;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .track-tab-btn.active {
        background: white;
        color: var(--primary);
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .track-input-wrap {
        position: relative;
        margin-bottom: 12px;
    }
    .track-input-box {
        width: 100%;
        padding: 12px 42px 12px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        font-size: 0.92rem;
        font-weight: 600;
        outline: none;
        transition: all 0.2s;
    }
    .track-input-box:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .track-clear-btn {
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
    .track-submit-btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 800;
        font-size: 0.94rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.3);
        cursor: pointer;
        transition: transform 0.15s ease;
    }
    .track-submit-btn:active {
        transform: scale(0.98);
    }
    .track-order-card {
        background: white;
        border-radius: 20px;
        margin: 0 14px 16px 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .track-order-header {
        padding: 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .track-order-num {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .track-copy-chip {
        font-size: 0.68rem;
        padding: 2px 7px;
        background: #e2e8f0;
        color: #475569;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
    }
    .track-status-pill {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.74rem;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .status-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .status-processing { background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; }
    .status-dispatched { background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }
    .status-delivered { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .status-cancelled { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }

    /* Timeline Stepper */
    .track-timeline-wrap {
        padding: 16px 14px 12px 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    .track-steps-bar {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 10px 0 4px 0;
    }
    .track-steps-bar::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 20px;
        right: 20px;
        height: 3px;
        background: #e2e8f0;
        z-index: 1;
    }
    .track-step-node {
        position: relative;
        z-index: 2;
        text-align: center;
        width: 25%;
    }
    .track-step-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 5px auto;
        font-size: 12px;
        font-weight: 700;
        border: 2px solid white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .track-step-node.completed .track-step-circle {
        background: #16a34a;
        color: white;
    }
    .track-step-node.active .track-step-circle {
        background: #dc2626;
        color: white;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.2);
    }
    .track-step-label {
        font-size: 0.66rem;
        font-weight: 700;
        color: #64748b;
        line-height: 1.2;
    }
    .track-step-node.completed .track-step-label { color: #16a34a; }
    .track-step-node.active .track-step-label { color: #dc2626; font-weight: 800; }

    .track-details-grid {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    .track-detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
        font-size: 0.82rem;
    }
    .track-detail-label { color: #64748b; font-weight: 600; }
    .track-detail-value { color: #0f172a; font-weight: 700; }

    .track-items-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.80rem;
    }
    .track-items-table th {
        background: #f8fafc;
        padding: 8px 12px;
        font-weight: 700;
        color: #475569;
        text-align: left;
    }
    .track-items-table td {
        padding: 8px 12px;
        border-top: 1px solid #f1f5f9;
        color: #1e293b;
    }
    .track-download-actions {
        padding: 14px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .btn-pdf-download {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #0284c7;
        color: white;
        text-decoration: none;
        padding: 11px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.88rem;
    }
    .btn-whatsapp-support {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #16a34a;
        color: white;
        text-decoration: none;
        padding: 11px;
        border-radius: 12px;
    }
    .items-box {
        padding: 12px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
    }
    .items-box-title {
        font-size: 0.80rem;
        font-weight: 800;
        color: #475569;
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border-bottom: 1px dashed #e2e8f0;
        font-size: 0.82rem;
    }
    .item-row:last-child { border-bottom: none; }
    .item-name { font-weight: 700; color: #1e293b; }
    .item-meta { font-size: 0.74rem; color: #64748b; }

    .order-actions-bar {
        padding: 12px 14px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        background: white;
    }
    .btn-action {
        flex: 1;
        min-width: 130px;
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 0.82rem;
        font-weight: 700;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.15s ease;
    }
    .btn-action:active { transform: scale(0.97); }
    .btn-action-primary { background: var(--primary); color: white; }
    .btn-action-outline { background: #f1f5f9; color: #334155; }
    .btn-action-whatsapp { background: #22c55e; color: white; }

    /* ============================================================== */
    /* IN-APP INVOICE MODAL & FAST DOWNLOAD STYLING                   */
    /* ============================================================== */
    .invoice-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 100005;
        background: rgba(15, 23, 42, 0.78);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        display: none;
        align-items: flex-end;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .invoice-modal-overlay.active {
        display: flex;
        opacity: 1;
    }
    .invoice-modal-container {
        width: 100%;
        max-width: 600px;
        height: 94vh;
        max-height: 94vh;
        background: #f8fafc;
        border-radius: 24px 24px 0 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 -12px 40px rgba(0, 0, 0, 0.35);
        transform: translateY(100%);
        transition: transform 0.32s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .invoice-modal-overlay.active .invoice-modal-container {
        transform: translateY(0);
    }
    .invoice-modal-header {
        padding: 12px 16px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-shrink: 0;
    }
    .invoice-modal-back-btn,
    .invoice-header-action-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: none;
        background: #f1f5f9;
        color: #1e293b;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
    }
    .invoice-modal-back-btn:active,
    .invoice-header-action-btn:active {
        background: #e2e8f0;
        transform: scale(0.94);
    }
    .invoice-modal-title-wrap {
        flex: 1;
        text-align: center;
    }
    .invoice-modal-title-wrap h3 {
        font-size: 0.96rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }
    .invoice-modal-title-wrap span {
        font-size: 0.70rem;
        color: #64748b;
        font-weight: 600;
    }
    .invoice-modal-header-actions {
        display: flex;
        gap: 6px;
    }
    .invoice-modal-body {
        flex: 1;
        overflow-y: auto;
        padding: 12px 10px 16px 10px;
        -webkit-overflow-scrolling: touch;
        background: #f1f5f9;
    }
    .invoice-modal-footer {
        padding: 10px 14px;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 8px;
        flex-shrink: 0;
        padding-bottom: calc(10px + env(safe-area-inset-bottom, 8px));
    }
    .invoice-footer-btn {
        flex: 1;
        padding: 11px 12px;
        border-radius: 12px;
        font-size: 0.84rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: transform 0.15s, opacity 0.2s;
    }
    .invoice-footer-btn:active {
        transform: scale(0.97);
    }
    .invoice-btn-download {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        flex: 1.6;
    }
    .invoice-btn-whatsapp {
        background: #22c55e;
        color: #ffffff;
        flex: 1.1;
    }
    .invoice-btn-close {
        background: #f1f5f9;
        color: #475569;
        flex: 0.8;
    }

    /* Professional A4 Paper Sheet Styling for Invoice */
    .invoice-sheet {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
        padding: 18px 16px;
        margin: 0 auto;
        color: #1e293b;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .inv-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 12px;
        border-bottom: 2px solid #dc2626;
        margin-bottom: 12px;
    }
    .inv-brand-left {
        flex: 1;
    }
    .inv-brand-title {
        font-size: 1.2rem;
        font-weight: 900;
        color: #dc2626;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .inv-brand-tagline {
        font-size: 0.66rem;
        font-weight: 700;
        color: #d97706;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-top: 1px;
    }
    .inv-brand-meta {
        font-size: 0.70rem;
        color: #64748b;
        line-height: 1.35;
        margin-top: 4px;
    }
    .inv-badge-wrap {
        text-align: right;
    }
    .inv-doc-type {
        font-size: 0.88rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .inv-status-chip {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.66rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-top: 4px;
    }
    .inv-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 12px;
        background: #f8fafc;
        padding: 10px 12px;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }
    .inv-box-title {
        font-size: 0.68rem;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }
    .inv-box-name {
        font-size: 0.85rem;
        font-weight: 800;
        color: #0f172a;
    }
    .inv-box-detail {
        font-size: 0.74rem;
        color: #475569;
        line-height: 1.4;
        margin-top: 2px;
    }

    /* Transport Card in Invoice */
    .inv-transport-box {
        background: #faf5ff;
        border: 1px solid #e9d5ff;
        border-radius: 10px;
        padding: 8px 12px;
        margin-bottom: 12px;
        font-size: 0.74rem;
        color: #581c87;
    }
    .inv-transport-title {
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 3px;
        color: #6b21a8;
        font-size: 0.72rem;
        text-transform: uppercase;
    }

    /* Items Table */
    .inv-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 12px;
        font-size: 0.76rem;
    }
    .inv-table th {
        background: #f1f5f9;
        color: #475569;
        font-weight: 800;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 8px 6px;
        text-align: left;
        border-bottom: 1.5px solid #cbd5e1;
    }
    .inv-table th:last-child,
    .inv-table td:last-child {
        text-align: right;
    }
    .inv-table th.text-center,
    .inv-table td.text-center {
        text-align: center;
    }
    .inv-table td {
        padding: 7px 6px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }
    .inv-table tr:last-child td {
        border-bottom: none;
    }
    .inv-item-name {
        font-weight: 700;
        color: #0f172a;
    }

    /* Totals & Summary */
    .inv-summary-wrap {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding-top: 10px;
        border-top: 1.5px solid #e2e8f0;
        margin-bottom: 12px;
    }
    .inv-words-box {
        flex: 1;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        padding: 7px 9px;
    }
    .inv-words-title {
        font-size: 0.64rem;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
    }
    .inv-words-text {
        font-size: 0.72rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2px;
        line-height: 1.3;
    }
    .inv-totals-box {
        width: 160px;
        flex-shrink: 0;
        font-size: 0.76rem;
    }
    .inv-total-row {
        display: flex;
        justify-content: space-between;
        padding: 2px 0;
        color: #64748b;
    }
    .inv-total-row.grand-total {
        margin-top: 5px;
        padding-top: 5px;
        border-top: 1.5px solid #dc2626;
        font-size: 0.92rem;
        font-weight: 900;
        color: #dc2626;
    }

    /* Sign & Notes */
    .inv-bottom-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding-top: 10px;
        border-top: 1px dashed #e2e8f0;
        margin-top: 8px;
        gap: 8px;
    }
    .inv-terms {
        font-size: 0.64rem;
        color: #64748b;
        line-height: 1.35;
        max-width: 62%;
    }
    .inv-signature-box {
        text-align: right;
    }
    .inv-sign-label {
        font-size: 0.64rem;
        color: #64748b;
        margin-top: 24px;
        font-weight: 700;
    }
    .inv-seal {
        font-size: 0.70rem;
        font-weight: 800;
        color: #dc2626;
        text-transform: uppercase;
    }

    /* Print media query */
    @media print {
        body * {
            visibility: hidden;
        }
        #invoiceModal, #invoiceModal * {
            visibility: visible;
        }
        #invoiceModal {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            height: auto !important;
            background: white !important;
            display: block !important;
            opacity: 1 !important;
            backdrop-filter: none !important;
        }
        .invoice-modal-container {
            max-width: 100% !important;
            height: auto !important;
            max-height: none !important;
            transform: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background: white !important;
        }
        .invoice-modal-header,
        .invoice-modal-footer {
            display: none !important;
        }
        .invoice-modal-body {
            padding: 0 !important;
            background: white !important;
            overflow: visible !important;
        }
        .invoice-sheet {
            border: none !important;
            box-shadow: none !important;
            padding: 10px !important;
            border-radius: 0 !important;
        }
    }

    /* ============================================================== */
    /* WEB-APP MATCHING CHECKOUT & CART DESIGN (SCREENSHOT 2 REPLICA) */
    /* ============================================================== */

    .web-review-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 16px;
        margin-bottom: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .web-review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 10px;
        margin-bottom: 12px;
    }
    .web-review-title-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .web-review-icon-sq {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: #fee2e2;
        color: #e11d48;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    .web-review-title {
        font-size: 0.94rem;
        font-weight: 800;
        color: #0f172a;
    }
    .web-varieties-badge {
        font-size: 0.70rem;
        font-weight: 700;
        color: #64748b;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 2px 8px;
        border-radius: 8px;
    }

    /* Cart Items in Review (NO +/- STEPPERS, JUST CLEAN ITEM + DELETE) */
    .web-cart-item-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 9px 0;
        border-bottom: 1px solid #f8fafc;
        gap: 10px;
    }
    .web-cart-item-row:last-child {
        border-bottom: none;
    }
    .web-cart-item-info {
        flex: 1;
        min-width: 0;
    }
    .web-cart-item-name {
        font-size: 0.88rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.3;
    }
    .web-tamil-tag {
        color: #e11d48;
        font-weight: 700;
        font-size: 0.82rem;
        margin-left: 4px;
    }
    .web-unit-tag {
        display: inline-block;
        font-size: 0.68rem;
        font-weight: 700;
        color: #475569;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 1px 6px;
        border-radius: 6px;
        margin-left: 6px;
    }
    .web-cart-item-rate-calc {
        font-size: 0.74rem;
        color: #64748b;
        margin-top: 3px;
        font-weight: 600;
    }
    .web-cart-item-price-col {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }
    .web-cart-item-total {
        font-weight: 800;
        color: #be123c;
        font-size: 0.94rem;
    }
    .web-cart-trash-btn {
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 13px;
        cursor: pointer;
        padding: 3px;
        transition: color 0.15s;
    }
    .web-cart-trash-btn:hover {
        color: #dc2626;
    }

    /* Price Breakdown Rows */
    .web-summary-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 12px 0 10px 0;
    }
    .web-summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.82rem;
        color: #475569;
        margin-bottom: 6px;
    }
    .web-summary-row-val {
        font-weight: 700;
        color: #0f172a;
    }
    .web-discount-pill-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: 8px;
        padding: 6px 10px;
        margin: 8px 0;
        color: #047857;
        font-size: 0.80rem;
        font-weight: 700;
    }
    .web-payable-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-top: 10px;
        padding-top: 8px;
        border-top: 1px solid #f1f5f9;
    }
    .web-payable-label {
        font-size: 0.92rem;
        font-weight: 800;
        color: #0f172a;
    }
    .web-payable-value {
        font-size: 1.25rem;
        font-weight: 900;
        color: #be123c;
    }

    /* Direct From Sivakasi Info Box */
    .web-sivakasi-guarantee {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 12px;
        padding: 10px 12px;
        margin-top: 12px;
        font-size: 0.74rem;
        color: #78350f;
        line-height: 1.45;
    }
    .web-sivakasi-title {
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 3px;
        color: #92400e;
    }

    /* Delivery & Contact Details Card */
    .web-delivery-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .web-delivery-header {
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 12px;
        margin-bottom: 14px;
    }
    .web-truck-icon-badge {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #fef3c7;
        color: #b45309;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .web-delivery-title {
        font-size: 0.96rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }
    .web-delivery-sub {
        font-size: 0.72rem;
        color: #64748b;
        margin: 2px 0 0 0;
    }

    /* Form Inputs matching Website Screenshot 2 */
    .web-form-group {
        margin-bottom: 12px;
    }
    .web-form-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 5px;
        display: block;
    }
    .web-form-label .req {
        color: #e11d48;
    }
    .web-input-wrap {
        position: relative;
        width: 100%;
    }
    .web-input-icon {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        color: #94a3b8;
        pointer-events: none;
    }
    .web-input {
        width: 100%;
        padding: 9px 12px 9px 32px;
        font-size: 0.82rem;
        font-weight: 600;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        outline: none;
        transition: all 0.2s;
    }
    .web-input:focus {
        border-color: #e11d48;
        background: white;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.12);
    }
    .web-input.is-invalid {
        border-color: #dc2626 !important;
        background: #fff5f5;
    }
    .web-textarea {
        width: 100%;
        padding: 9px 12px 9px 32px;
        font-size: 0.82rem;
        font-weight: 600;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        outline: none;
        transition: all 0.2s;
        resize: none;
    }
    .web-textarea:focus {
        border-color: #e11d48;
        background: white;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.12);
    }
    .web-textarea.is-invalid {
        border-color: #dc2626 !important;
        background: #fff5f5;
    }

    /* Phone group with Prefix */
    .web-phone-group {
        display: flex;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.2s;
    }
    .web-phone-group:focus-within {
        border-color: #e11d48;
        background: white;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.12);
    }
    .web-phone-group.is-invalid {
        border-color: #dc2626 !important;
        background: #fff5f5;
    }
    .web-phone-flag {
        background: #f1f5f9;
        padding: 8px 10px;
        font-size: 0.78rem;
        font-weight: 800;
        color: #334155;
        border-right: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        user-select: none;
    }
    .web-phone-group input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 8px 10px;
        font-size: 0.84rem;
        font-weight: 600;
        outline: none;
    }
    .web-phone-subtext {
        font-size: 0.70rem;
        color: #64748b;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .web-field-error {
        display: none;
        font-size: 0.70rem;
        color: #dc2626;
        font-weight: 700;
        margin-top: 3px;
        align-items: center;
        gap: 4px;
    }

    /* Select Dropdown */
    .web-select {
        width: 100%;
        padding: 9px 10px 9px 30px;
        font-size: 0.80rem;
        font-weight: 700;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        outline: none;
        transition: all 0.2s;
        appearance: none;
        -webkit-appearance: none;
    }
    .web-select:focus {
        border-color: #e11d48;
        background: white;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.12);
    }

    /* Submit Button & UPI Footer */
    .web-submit-btn {
        width: 100%;
        padding: 13px;
        background: linear-gradient(135deg, #e11d48 0%, #be123c 45%, #d97706 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.98rem;
        box-shadow: 0 4px 16px rgba(225, 29, 72, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: transform 0.1s;
    }
    .web-submit-btn:active {
        transform: scale(0.98);
    }
    .web-btn-total-badge {
        background: rgba(255, 255, 255, 0.22);
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.86rem;
        letter-spacing: 0.3px;
    }

    /* Floating Back to Top Button */
    .back-to-top-btn {
        position: fixed;
        bottom: calc(75px + var(--safe-bottom));
        right: 16px;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: white;
        color: #0f172a;
        box-shadow: 0 4px 16px rgba(0,0,0,0.18);
        border: 1px solid #e2e8f0;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        z-index: 980;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .back-to-top-btn:active {
        transform: scale(0.92);
    }

    /* ============================================================== */
    /* PULL TO REFRESH & TOP REFRESH BAR STYLING                      */
    /* ============================================================== */
    .pull-to-refresh-indicator {
        position: relative;
        width: 100%;
        height: 0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: height 0.25s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
        opacity: 0;
        pointer-events: none;
        z-index: 50;
    }
    .pull-to-refresh-indicator.visible {
        opacity: 1;
    }
    .pull-to-refresh-indicator.refreshing {
        height: 54px !important;
        opacity: 1;
    }
    .ptr-inner {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #ffffff;
        padding: 7px 16px;
        border-radius: 24px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        border: 1px solid #fee2e2;
        margin-top: 4px;
        margin-bottom: 4px;
    }
    .ptr-icon-wrap {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        transition: transform 0.15s ease;
    }
    .ptr-msg {
        font-size: 0.78rem;
        font-weight: 700;
        color: #334155;
    }
</style>
@endpush

@section('content')
    <!-- ============================================================== -->
    <!-- COMPONENT 1: CATALOG SCREEN VIEW (FAST SPA) -->
    <!-- ============================================================== -->
    <div id="view-catalog" class="app-view active">
        <!-- App Header -->
        <header class="app-header">
            <div class="header-content">
                <div class="brand-info">
                    <div class="brand-icon" id="headerLogoWrap">
                        <img id="headerLogoImg" src="{{ asset('images/logo.png') }}" alt="Guru Crackers" onerror="this.src='{{ $shop['logo_url'] ?? '' }}'">
                    </div>
                    <div>
                        <h1 class="brand-title">{{ $shop['name'] ?? 'Guru Crackers' }}</h1>
                        <span class="brand-subtitle"><i class="fa-solid fa-shield-halved"></i> Sivakasi Factory Direct Rates</span>
                    </div>
                </div>
                <div class="header-actions">
                    <button type="button" class="header-btn" id="refreshCatalogBtn" onclick="triggerManualRefresh()" title="Refresh Catalog" style="cursor: pointer; padding: 0;">
                        <i class="fa-solid fa-rotate-right" id="refreshBtnIcon"></i>
                    </button>
                    <a href="tel:{{ $shop['phone'] ?? '9789874381' }}" class="header-btn" title="Call Store">
                        <i class="fa-solid fa-phone"></i>
                    </a>
                    <a href="https://wa.me/91{{ $shop['phone'] ?? '9789874381' }}?text=Hello%20Guru%20Crackers,%20I%20want%20to%20place%20an%20order" target="_blank" class="header-btn" title="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </header>

        <!-- Pull-to-Refresh Indicator -->
        <div id="pullToRefresh" class="pull-to-refresh-indicator">
            <div class="ptr-inner">
                <div class="ptr-icon-wrap" id="ptrIconWrap">
                    <i class="fa-solid fa-arrow-down" id="ptrIcon"></i>
                </div>
                <span class="ptr-msg" id="ptrMsg">Pull down to refresh</span>
            </div>
        </div>

        <!-- Skeleton Loader Component (Smooth Initial Load Shimmer) -->
        <div id="catalogSkeleton" class="catalog-skeleton-wrap" style="display: none;">
            <div class="skeleton-shimmer sk-banner-box"></div>
            <div class="skeleton-shimmer sk-search-bar"></div>
            <div class="sk-pills-row">
                <div class="skeleton-shimmer sk-pill-item" style="width: 85px;"></div>
                <div class="skeleton-shimmer sk-pill-item" style="width: 110px;"></div>
                <div class="skeleton-shimmer sk-pill-item" style="width: 95px;"></div>
                <div class="skeleton-shimmer sk-pill-item" style="width: 120px;"></div>
                <div class="skeleton-shimmer sk-pill-item" style="width: 90px;"></div>
            </div>
            <div class="sk-grid">
                @for($i = 0; $i < 4; $i++)
                    <div class="sk-grid-card">
                        <div class="skeleton-shimmer sk-grid-thumb"></div>
                        <div class="skeleton-shimmer sk-grid-title"></div>
                        <div class="skeleton-shimmer sk-grid-price"></div>
                        <div class="skeleton-shimmer sk-grid-btn"></div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Real Catalog Content -->
        <div id="catalogRealContent">
            <!-- Festival Banner Carousel (Placed on top for modern eCommerce UX) -->
            @if(!empty($banners) && count($banners) > 0)
                <div class="banner-carousel-wrapper" style="margin-top: 6px;">
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

            <!-- Sticky Navigation Section (Search + Category Filter Pills - Below Banner) -->
            <div class="sticky-nav-section">
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
                    <a href="javascript:void(0)" onclick="clearSearch()" style="color: var(--primary); text-decoration: none;">Show All</a>
                </div>

                <!-- Category Horizontal Filter Pills (Scroll illa ma - 1-tap Filter) -->
                <div class="category-scroll" id="categoryScroll">
                    <a href="javascript:void(0)" class="cat-pill active" onclick="selectCategory(null, this)">
                        <span>✨ All Crackers</span>
                        <span class="pill-count" id="pill-count-all">
                            {{ collect($categories)->sum(fn($c) => count($c['products'] ?? [])) }}
                        </span>
                    </a>
                    @foreach($categories as $cat)
                        <a href="javascript:void(0)" class="cat-pill" onclick="selectCategory({{ $cat['id'] }}, this)" data-cat-id="{{ $cat['id'] }}">
                            <span>💥 {{ $cat['name'] }}</span>
                            <span class="pill-count">{{ count($cat['products'] ?? []) }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Product Catalog List (2-Column Modern eCommerce Grid) -->
            <main id="catalogContent" style="padding-bottom: 24px;">
                @forelse($categories as $category)
                    @continue(empty($category['products']))
                    <div class="category-group" data-cat-id="{{ $category['id'] }}" id="cat-group-{{ $category['id'] }}">
                        <h2 class="category-title">
                            <div class="category-title-left">
                                <i class="fa-solid fa-burst" style="color: #dc2626;"></i>
                                <span>{{ $category['name'] }}</span>
                            </div>
                            <span class="category-badge-count">{{ count($category['products']) }} Items</span>
                        </h2>

                        <div class="products-grid">
                            @foreach($category['products'] as $prod)
                                @php
                                    $discountPercent = 0;
                                    if (($prod['actual_rate'] ?? 0) > $prod['net_rate']) {
                                        $discountPercent = round((($prod['actual_rate'] - $prod['net_rate']) / $prod['actual_rate']) * 100);
                                    }
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
                                    
                                    <div class="prod-img-box">
                                        @if($discountPercent > 0)
                                            <span class="prod-discount-badge">{{ $discountPercent }}% OFF</span>
                                        @endif
                                        @if(!empty($prod['image_url']))
                                            <img src="{{ $prod['image_url'] }}" alt="{{ $prod['name'] }}" loading="lazy" class="prod-img" onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}'; this.classList.add('prod-img-fallback');">
                                        @else
                                            <img src="{{ asset('images/logo.png') }}" alt="{{ $prod['name'] }}" loading="lazy" class="prod-img prod-img-fallback">
                                        @endif
                                    </div>

                                    <div class="prod-info-block">
                                        <div class="prod-title">{{ $prod['name'] }}</div>
                                        @if(!empty($prod['tamil_name']))
                                            <div class="prod-tamil-title">{{ $prod['tamil_name'] }}</div>
                                        @else
                                            <div style="height: 16px;"></div>
                                        @endif
                                        
                                        <div class="prod-price-row">
                                            <span class="prod-price-net">₹{{ number_format($prod['net_rate'], 0) }}</span>
                                            @if($discountPercent > 0)
                                                <span class="prod-price-mrp">₹{{ number_format($prod['actual_rate'], 0) }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="prod-action-bar">
                                        <div class="prod-total-row">
                                            <span class="prod-total-label">Total</span>
                                            <span class="line-total-display" id="line-total-{{ $prod['id'] }}">₹0.00</span>
                                        </div>
                                        <div class="prod-stepper-ctrl">
                                            <button type="button" class="stepper-ctrl-btn" onclick="stepQuantity({{ $prod['id'] }}, -1)" title="Decrease quantity">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <input type="number" min="0" max="20"
                                                value="0"
                                                id="qty-input-{{ $prod['id'] }}"
                                                class="qty-input stepper-val"
                                                data-id="{{ $prod['id'] }}"
                                                data-name="{{ $prod['name'] }}"
                                                data-tamil="{{ $prod['tamil_name'] ?? '' }}"
                                                data-rate="{{ $prod['net_rate'] }}"
                                                data-actual-rate="{{ $prod['actual_rate'] ?? $prod['net_rate'] }}"
                                                oninput="handleQtyInputChange(this)"
                                                onchange="handleQtyInputChange(this)"
                                                onfocus="if (this.value === '0') this.select();"
                                                placeholder="0"
                                                inputmode="numeric">
                                            <button type="button" class="stepper-ctrl-btn" onclick="stepQuantity({{ $prod['id'] }}, 1)" title="Increase quantity">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
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

    <!-- Floating Back to Top Button -->
    <button type="button" id="backToTopBtn" class="back-to-top-btn" onclick="scrollToTop()">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- Floating Cart Bar -->
    <div id="floatingCart" class="floating-cart-bar" style="display: none;">
        <div class="cart-summary-text">
            <div class="cart-summary-qty">
                <span id="cartBarQty">0 Items</span>
                <span id="cartBarSave" class="cart-save-badge">Save ₹0</span>
            </div>
            <div class="cart-summary-prices">
                <span class="cart-summary-total" id="cartBarTotal">₹0.00</span>
                <span class="cart-summary-mrp" id="cartBarMrp">₹0.00</span>
            </div>
        </div>
        <button type="button" class="cart-btn-action" onclick="switchTab('cart')">
            <span>View Cart</span>
            <i class="fa-solid fa-arrow-right"></i>
        </button>
    </div>
    </div><!-- End #catalogRealContent -->
    </div><!-- End #view-catalog -->

    <!-- ============================================================== -->
    <!-- COMPONENT 2: CART & CHECKOUT SCREEN VIEW (DEDICATED FULL PAGE) -->
    <!-- ============================================================== -->
    <div id="view-cart" class="app-view">
        <!-- Top App Header for Cart -->
        <div class="view-top-header">
            <div class="view-header-left">
                <button type="button" class="view-back-btn" onclick="switchTab('catalog')" title="Back to Catalog">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <div class="view-title-wrap">
                    <h2>Your Cart & Checkout</h2>
                    <p><i class="fa-solid fa-shield-halved"></i> Direct Sivakasi Factory Wholesale Price</p>
                </div>
            </div>
            <button type="button" class="view-header-action" onclick="clearCart()">
                <i class="fa-solid fa-trash-can"></i>
                <span>Clear</span>
            </button>
        </div>

        <!-- Empty Cart State (Vertically & Horizontally Centered) -->
        <div id="cartEmptyState" class="empty-cart-wrapper" style="display: none;">
            <div class="empty-cart-card">
                <div class="empty-cart-icon-circle">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Your Cart is Empty</h3>
                <p style="font-size: 0.84rem; color: #64748b; line-height: 1.5; max-width: 290px; margin: 0 auto;">
                    You haven't selected any fireworks yet. Browse our Sivakasi factory direct catalog and add your favorites.
                </p>
                <button type="button" class="empty-cart-explore-btn" onclick="switchTab('catalog')">
                    <i class="fa-solid fa-fire"></i>
                    <span>Explore Fireworks Catalog</span>
                </button>
            </div>
        </div>

        <!-- Filled Cart Content & Checkout Form -->
        <div id="cartFilledState" style="padding: 14px 14px;">
            <!-- CARD 1: Selected Items Review (Screenshot 2 left side) -->
            <div class="web-review-card">
                <div class="web-review-header">
                    <div class="web-review-title-left">
                        <span class="web-review-icon-sq">
                            <i class="fa-solid fa-file-lines"></i>
                        </span>
                        <h4 class="web-review-title">Selected Items Review</h4>
                    </div>
                    <span class="web-varieties-badge" id="varietiesCountBadge">0 Varieties</span>
                </div>

                <!-- Itemized Cart List (WITHOUT quantity increase/decrease buttons, just clean item row + delete trash icon) -->
                <div id="drawerCartItems" style="margin-bottom: 10px; max-height: 280px; overflow-y: auto;">
                    <!-- Populated via JS -->
                </div>

                <div class="web-summary-divider"></div>

                <!-- Price Breakdown Rows -->
                <div class="web-summary-row">
                    <span>Actual Value (MRP):</span>
                    <span class="web-summary-row-val" id="drawerTotalMrp">₹0.00</span>
                </div>
                <div class="web-discount-pill-row">
                    <span><i class="fa-solid fa-tag"></i> Festival Discount Savings:</span>
                    <span id="drawerTotalDiscount">- ₹0.00</span>
                </div>
                <div class="web-payable-row" style="flex-direction: column; align-items: flex-start; gap: 4px;">
                    <div style="display: flex; justify-content: space-between; width: 100%; align-items: baseline;">
                        <div>
                            <span class="web-payable-label">Net Payable Amount:</span>
                            <div style="font-size: 0.68rem; font-weight: 800; color: #92400e; background: #fef3c7; border: 1px solid #fde68a; padding: 2px 6px; border-radius: 6px; margin-top: 2px; display: inline-block;">
                                Without Delivery Charges (டெலிவரி கட்டணம் தனி)
                            </div>
                        </div>
                        <span class="web-payable-value" id="drawerGrandTotal">₹0.00</span>
                    </div>
                </div>

                <!-- Delivery Charges Notice Card -->
                <div style="margin-top: 10px; padding: 10px 12px; border-radius: 12px; background: #fffbeb; border: 1px solid #fde68a; display: flex; gap: 10px; align-items: flex-start;">
                    <i class="fa-solid fa-truck-fast" style="color: #d97706; font-size: 14px; margin-top: 2px; flex-shrink: 0;"></i>
                    <div style="font-size: 0.72rem; line-height: 1.4;">
                        <div style="font-weight: 800; color: #78350f; display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                            <span>Delivery Charges (டெலிவரி கட்டணம்):</span>
                            <span style="font-size: 0.62rem; font-weight: 800; background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; padding: 1px 5px; border-radius: 4px;">Extra / To Pay at Hub</span>
                        </div>
                        <p style="margin: 0; color: #92400e;">
                            Delivery charges may differ depending on the transport partner (டிரான்ஸ்போர்ட் நிறுவனத்தைப் பொறுத்து டெலிவரி கட்டணம் மாறுபடும்). பார்சல் உங்கள் ஊர் கிளைக்கு வந்ததும் இந்த கட்டணத்தைச் செலுத்தி பெற்றுக்கொள்ளலாம்.
                        </p>
                    </div>
                </div>

                <!-- Minimum Order Value Alert & Live Progress -->
                @php
                    $minOrderAmt = $shop['min_order_amount'] ?? 2500;
                @endphp
                <div id="minOrderAlertBox" style="margin-top: 10px; padding: 12px; border-radius: 12px; background: #fff1f2; border: 1px solid #fecdd3; color: #881337; font-size: 0.8rem; transition: all 0.3s ease;">
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 8px;">
                        <div style="display: flex; align-items: center; gap: 6px; font-weight: 800;">
                            <i class="fa-solid fa-circle-exclamation" id="minOrderIcon" style="color: #e11d48;"></i>
                            <span id="minOrderTitle">Minimum Order: ₹{{ number_format($minOrderAmt, 0) }}</span>
                        </div>
                        <span id="minOrderBadge" style="font-size: 0.65rem; font-weight: 900; padding: 2px 8px; border-radius: 9999px; background: #ffe4e6; color: #9f1239;">
                            குறைந்தபட்ச ஆர்டர்
                        </span>
                    </div>
                    <p id="minOrderText" style="margin: 6px 0 0 0; font-size: 0.74rem; color: #475569; line-height: 1.4;">
                        குறைந்தபட்ச ஆர்டர் தொகை <strong>₹{{ number_format($minOrderAmt, 0) }}</strong> ஆகும். ஆர்டர் செய்ய கார்ட்டில் மேலும் பட்டாசுகளைச் சேர்க்கவும்.
                    </p>
                    <div style="width: 100%; background: #fecdd3; border-radius: 9999px; height: 6px; margin-top: 8px; overflow: hidden;">
                        <div id="minOrderProgressBar" style="background: #e11d48; height: 6px; border-radius: 9999px; width: 0%; transition: width 0.3s ease;"></div>
                    </div>
                </div>

                <!-- Direct From Sivakasi Info Box -->
                <div class="web-sivakasi-guarantee">
                    <div class="web-sivakasi-title">
                        <i class="fa-solid fa-shield-halved text-amber-600"></i> Direct From Sivakasi
                    </div>
                    <p style="margin: 0; color: #92400e; line-height: 1.4;">
                        We dispatch top brand fireworks directly from Sivakasi factory. Our representative will contact you for transport hub delivery confirmation before dispatch.
                    </p>
                </div>
            </div>

            <!-- CARD 2: Delivery & Contact Details Form (Screenshot 2 right side) -->
            <div class="web-delivery-card">
                <div class="web-delivery-header">
                    <span class="web-truck-icon-badge">
                        <i class="fa-solid fa-truck"></i>
                    </span>
                    <div>
                        <h4 class="web-delivery-title">Delivery & Contact Details</h4>
                        <p class="web-delivery-sub">Please provide accurate contact details for dispatch confirmation</p>
                    </div>
                </div>

                <form id="checkoutForm" onsubmit="handleCheckout(event)" novalidate>
                    <!-- Customer Full Name -->
                    <div class="web-form-group">
                        <label class="web-form-label" for="nameInput">
                            Customer Full Name <span class="req">*</span>
                        </label>
                        <div class="web-input-wrap">
                            <i class="fa-solid fa-user web-input-icon"></i>
                            <input type="text" id="nameInput" name="name" class="web-input" placeholder="e.g. Ramesh Kumar" required minlength="3" maxlength="60">
                        </div>
                        <p id="err-name" class="web-field-error"><i class="fa-solid fa-circle-exclamation"></i> <span>Customer full name is required</span></p>
                    </div>

                    <!-- WhatsApp Mobile No -->
                    <div class="web-form-group">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <label class="web-form-label" for="phone1Input" style="margin-bottom: 0;">
                                <i class="fa-brands fa-whatsapp" style="color: #16a34a;"></i> WhatsApp Mobile No <span class="req">*</span>
                            </label>
                            <span style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-size: 0.65rem; font-weight: 800; padding: 1px 6px; border-radius: 6px;">Active WhatsApp</span>
                        </div>
                        <div class="web-phone-group" id="phone1Group">
                            <span class="web-phone-flag">🇮🇳 +91</span>
                            <input type="tel" id="phone1Input" name="phone1" placeholder="10-digit mobile number" maxlength="10" inputmode="numeric" required>
                        </div>
                        <div class="web-phone-subtext">
                            <i class="fa-solid fa-circle-info" style="color: #059669; font-size: 10px;"></i> Invoice & parcel updates will be sent to this WhatsApp.
                        </div>
                        <p id="err-phone1" class="web-field-error"><i class="fa-solid fa-circle-exclamation"></i> <span></span></p>
                    </div>

                    <!-- Alternate Mobile No -->
                    <div class="web-form-group">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <label class="web-form-label" for="phone2Input" style="margin-bottom: 0;">
                                <i class="fa-solid fa-phone" style="color: #64748b; font-size: 11px;"></i> Alternate Mobile No (Optional)
                            </label>
                            <span style="font-size: 0.68rem; color: #64748b; font-weight: 600;">For Voice Call</span>
                        </div>
                        <div class="web-phone-group" id="phone2Group">
                            <span class="web-phone-flag" style="color: #64748b;">+91</span>
                            <input type="tel" id="phone2Input" name="phone2" placeholder="Secondary 10 digits" maxlength="10" inputmode="numeric">
                        </div>
                        <div class="web-phone-subtext">
                            <i class="fa-solid fa-circle-info" style="color: #64748b; font-size: 10px;"></i> To call if your WhatsApp number is unreachable.
                        </div>
                        <p id="err-phone2" class="web-field-error"><i class="fa-solid fa-circle-exclamation"></i> <span></span></p>
                    </div>

                    <!-- Delivery Address / Nearest Transport Hub -->
                    <div class="web-form-group">
                        <label class="web-form-label" for="deliveryAddressInput">
                            Delivery Address / Nearest Transport Hub <span class="req">*</span>
                        </label>
                        <div class="web-input-wrap">
                            <i class="fa-solid fa-location-dot web-input-icon" style="top: 14px;"></i>
                            <textarea id="deliveryAddressInput" name="delivery_address" class="web-textarea" rows="2" placeholder="Door No, Street Name, Area / Landmark..." required minlength="5"></textarea>
                        </div>
                        <p id="err-delivery_address" class="web-field-error"><i class="fa-solid fa-circle-exclamation"></i> <span>Delivery address or transport hub is required</span></p>
                    </div>

                    <!-- Pincode (First for Auto-Lookup), City & State (Locked to TN) -->
                    <div class="web-form-group">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <label class="web-form-label" for="pincodeInput" style="margin-bottom: 0;">
                                Pincode <span class="req">*</span>
                            </label>
                            <span style="font-size: 0.65rem; font-weight: 800; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 1px 6px; border-radius: 6px;">
                                Inside Tamil Nadu Only (60xxxx - 64xxxx)
                            </span>
                        </div>
                        <div class="web-input-wrap">
                            <i class="fa-solid fa-envelope web-input-icon"></i>
                            <input type="tel" id="pincodeInput" name="pincode" class="web-input" placeholder="TN 6-digit pincode (60xxxx - 64xxxx)" maxlength="6" inputmode="numeric" required>
                            <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); display: flex; align-items: center; gap: 6px;">
                                <i id="pincodeSpinner" class="fa-solid fa-circle-notch fa-spin" style="display: none; color: #e11d48; font-size: 14px;"></i>
                                <i id="pincodeSuccessIcon" class="fa-solid fa-circle-check" style="display: none; color: #059669; font-size: 16px;"></i>
                            </div>
                        </div>
                        <p id="err-pincode" class="web-field-error"><i class="fa-solid fa-circle-exclamation"></i> <span></span></p>
                        <p id="pincodeSuccessMsg" style="display: none; font-size: 0.72rem; color: #059669; font-weight: 700; margin: 4px 0 0 0; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-circle-check"></i> <span id="pincodeSuccessText"></span>
                        </p>
                    </div>

                    <div style="display: flex; gap: 8px;">
                        <div class="web-form-group" style="flex: 1.2;">
                            <label class="web-form-label" for="cityInput">City / Town <span class="req">*</span></label>
                            <div class="web-input-wrap">
                                <i class="fa-solid fa-building web-input-icon"></i>
                                <input type="text" id="cityInput" name="city" class="web-input" placeholder="Auto-detected / Enter city" required minlength="2">
                            </div>
                            <p id="err-city" class="web-field-error"><i class="fa-solid fa-circle-exclamation"></i> <span></span></p>
                        </div>

                        <div class="web-form-group" style="flex: 0.8;">
                            <label class="web-form-label" for="stateInput">State <span class="req">*</span></label>
                            <div class="web-input-wrap">
                                <i class="fa-solid fa-map-location-dot web-input-icon"></i>
                                <select name="state" id="stateInput" class="web-select" style="pointer-events: none; background: #f8fafc; font-weight: 700;" tabindex="-1">
                                    <option value="Tamil Nadu" selected>Tamil Nadu</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="checkoutError" style="display: none; padding: 10px 12px; background: #fee2e2; color: #dc2626; border-radius: 10px; font-size: 0.80rem; font-weight: 700; margin-bottom: 12px; border: 1px solid #fca5a5;"></div>

                    <!-- Submit Button -->
                    <div style="margin-top: 10px;">
                        <button type="submit" id="submitOrderBtn" class="web-submit-btn">
                            <span>🎆 Submit Order</span>
                            <span class="web-btn-total-badge" id="btnTotalText">₹0.00</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        <p style="font-size: 0.69rem; color: #64748b; text-align: center; margin-top: 8px;">
                            🔒 Safe booking. No immediate online payment required. Pay upon transport confirmation.
                        </p>
                        <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #f1f5f9; display: flex; flex-direction: column; align-items: center; gap: 6px;">
                            <span style="font-size: 0.65rem; font-weight: 800; letter-spacing: 0.5px; color: #94a3b8; display: flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-shield-halved" style="color: #059669;"></i> PAYMENT ACCEPTED VIA UPI
                            </span>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <img src="{{ asset('images/paytm-circle.svg') }}" alt="Paytm" style="width: 28px; height: 28px; border-radius: 50%;">
                                <img src="{{ asset('images/phonepe-circle.svg') }}" alt="PhonePe" style="width: 28px; height: 28px; border-radius: 50%;">
                                <img src="{{ asset('images/gpay-circle.svg') }}" alt="Google Pay" style="width: 28px; height: 28px; border-radius: 50%;">
                                <img src="{{ asset('images/bhim-circle.svg') }}" alt="BHIM UPI" style="width: 28px; height: 28px; border-radius: 50%;">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End #view-cart -->

    <!-- ============================================================== -->
    <!-- COMPONENT 3: TRACK ORDER SCREEN VIEW (DEDICATED FULL PAGE) -->
    <!-- ============================================================== -->
    <div id="view-track" class="app-view">
        <!-- Top App Header for Track -->
        <div class="view-top-header">
            <div class="view-header-left">
                <button type="button" class="view-back-btn" onclick="switchTab('catalog')" title="Back to Catalog">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <div class="view-title-wrap">
                    <h2>Track Your Order</h2>
                    <p><i class="fa-solid fa-truck-fast"></i> Live Sivakasi Dispatch Status</p>
                </div>
            </div>
        </div>

        <!-- Track Search Card -->
        <div class="track-search-card">
            <!-- Search Mode Tabs -->
            <div class="track-tabs-bar">
                <button type="button" class="track-tab-btn active" id="tabMobile" onclick="switchTrackTab('mobile')">
                    <i class="fa-solid fa-phone"></i> Mobile Number
                </button>
                <button type="button" class="track-tab-btn" id="tabOrderId" onclick="switchTrackTab('order')">
                    <i class="fa-solid fa-receipt"></i> Order ID
                </button>
            </div>

            <form id="trackForm" onsubmit="handleTrack(event)">
                <div class="track-input-wrap">
                    <input type="tel" id="trackQuery" class="track-input-box" placeholder="Enter 10-digit mobile number" maxlength="10" required>
                    <button type="button" id="trackClearBtn" class="track-clear-btn" onclick="clearTrackInput()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div id="searchTip" style="font-size: 0.74rem; color: #64748b; margin-bottom: 12px;">
                    <i class="fa-solid fa-circle-info"></i> Enter the phone number used during checkout to view all your booked orders.
                </div>

                <button type="submit" id="trackSubmitBtn" class="track-submit-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span id="trackBtnText">Search & Track Order</span>
                </button>
            </form>
        </div>

        <!-- Tracking Results Container -->
        <div id="trackResults">
            <div id="trackPlaceholder" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                <div style="width: 70px; height: 70px; border-radius: 50%; background: #fef2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px auto; font-size: 28px;">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <p style="font-weight: 800; color: #1e293b; font-size: 1rem;">Track Sivakasi Dispatch Status</p>
                <p style="font-size: 0.82rem; color: #64748b; margin-top: 4px; max-width: 320px; margin-left: auto; margin-right: auto;">
                    Instant updates on packing, transport parcel booking, LR copy, and doorstep delivery.
                </p>
            </div>
        </div>
    </div><!-- End #view-track -->

    <!-- ============================================================== -->
    <!-- IN-APP INVOICE VIEW & FAST DOWNLOAD MODAL                      -->
    <!-- ============================================================== -->
    <div id="invoiceModal" class="invoice-modal-overlay" onclick="handleInvoiceOverlayClick(event)">
        <div class="invoice-modal-container">
            <!-- Modal Header Bar -->
            <div class="invoice-modal-header">
                <button type="button" class="invoice-modal-back-btn" onclick="closeInvoiceModal()" title="Back">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <div class="invoice-modal-title-wrap">
                    <h3 id="invoiceModalTitle">Order Invoice</h3>
                    <span id="invoiceModalSub">Guru Crackers, Sivakasi</span>
                </div>
                <div class="invoice-modal-header-actions">
                    <button type="button" class="invoice-header-action-btn" onclick="printInvoice()" title="Print / Save PDF">
                        <i class="fa-solid fa-print"></i>
                    </button>
                    <button type="button" class="invoice-header-action-btn" onclick="closeInvoiceModal()" title="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body: Printable Invoice Document Sheet -->
            <div class="invoice-modal-body">
                <div id="invoicePrintableArea" class="invoice-sheet">
                    <!-- Populated dynamically by renderInvoiceContent(order) -->
                </div>
            </div>

            <!-- Modal Footer Action Bar -->
            <div class="invoice-modal-footer">
                <button type="button" class="invoice-footer-btn invoice-btn-download" id="modalDownloadBtn" onclick="downloadCurrentInvoicePdf()">
                    <i class="fa-solid fa-file-arrow-down"></i>
                    <span id="modalDownloadBtnText">Download PDF</span>
                </button>
                <button type="button" class="invoice-footer-btn invoice-btn-whatsapp" id="modalWhatsAppBtn" onclick="shareCurrentInvoiceWhatsApp()">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>Share</span>
                </button>
                <button type="button" class="invoice-footer-btn invoice-btn-close" onclick="closeInvoiceModal()">
                    <span>Close</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile WhatsApp OTP Modal -->
    <div id="mobileOtpModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 16px;">
        <div style="background: #ffffff; border-radius: 20px; width: 100%; max-width: 380px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden; position: relative;">
            <!-- Modal Header -->
            <div style="background: linear-gradient(135deg, #059669 0%, #0d9488 100%); padding: 20px 16px; text-align: center; position: relative;">
                <button type="button" onclick="closeMobileOtpModal()" style="position: absolute; top: 12px; right: 12px; width: 30px; height: 30px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); border: none; color: #ffffff; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div style="width: 52px; height: 52px; margin: 0 auto 10px; border-radius: 16px; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; font-size: 26px; color: #a7f3d0;">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 900; color: #ffffff; margin: 0;">WhatsApp Verification</h3>
                <p style="font-size: 0.76rem; color: #ecfdf5; margin: 4px 0 0 0; font-weight: 600;">ஆர்டரை உறுதி செய்ய வாட்ஸ்அப் OTP உள்ளிடவும்</p>
            </div>

            <!-- Modal Body -->
            <div style="padding: 20px 16px;">
                <!-- Phone info banner -->
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 10px 12px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="width: 28px; height: 28px; border-radius: 8px; background: #059669; color: white; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                            <i class="fa-solid fa-mobile-screen"></i>
                        </span>
                        <div>
                            <div style="font-size: 9px; font-weight: 800; text-transform: uppercase; color: #64748b;">Sent to WhatsApp</div>
                            <div id="mobileOtpDisplayPhone" style="font-size: 0.85rem; font-weight: 900; color: #0f172a; font-family: monospace;">+91 ----------</div>
                        </div>
                    </div>
                    <button type="button" onclick="editPhoneFromMobileOtp()" style="background: white; border: 1px solid #a7f3d0; color: #059669; padding: 4px 8px; border-radius: 8px; font-size: 0.72rem; font-weight: 800; cursor: pointer;">
                        <i class="fa-solid fa-pen" style="font-size: 10px;"></i> Edit
                    </button>
                </div>

                <!-- 4-digit Inputs -->
                <div style="margin-bottom: 14px;">
                    <label style="display: block; text-align: center; font-size: 0.75rem; font-weight: 800; color: #334155; margin-bottom: 10px;">
                        Enter 4-Digit Verification Code
                    </label>
                    <div style="display: flex; justify-content: center; gap: 10px;" id="mobileOtpInputsContainer">
                        <input type="tel" maxlength="1" class="mobile-otp-digit" data-idx="0" inputmode="numeric" style="width: 48px; height: 56px; text-align: center; font-size: 1.5rem; font-weight: 900; font-family: monospace; border: 2px solid #cbd5e1; border-radius: 12px; background: #f8fafc; outline: none;">
                        <input type="tel" maxlength="1" class="mobile-otp-digit" data-idx="1" inputmode="numeric" style="width: 48px; height: 56px; text-align: center; font-size: 1.5rem; font-weight: 900; font-family: monospace; border: 2px solid #cbd5e1; border-radius: 12px; background: #f8fafc; outline: none;">
                        <input type="tel" maxlength="1" class="mobile-otp-digit" data-idx="2" inputmode="numeric" style="width: 48px; height: 56px; text-align: center; font-size: 1.5rem; font-weight: 900; font-family: monospace; border: 2px solid #cbd5e1; border-radius: 12px; background: #f8fafc; outline: none;">
                        <input type="tel" maxlength="1" class="mobile-otp-digit" data-idx="3" inputmode="numeric" style="width: 48px; height: 56px; text-align: center; font-size: 1.5rem; font-weight: 900; font-family: monospace; border: 2px solid #cbd5e1; border-radius: 12px; background: #f8fafc; outline: none;">
                    </div>
                </div>

                <!-- Status msg -->
                <div id="mobileOtpStatusMsg" style="display: none; padding: 8px 10px; border-radius: 10px; font-size: 0.74rem; font-weight: 700; text-align: center; margin-bottom: 12px;"></div>

                <!-- Verify Button -->
                <button type="button" id="mobileVerifyOtpBtn" onclick="submitMobileOtpVerification()" style="width: 100%; padding: 13px; border-radius: 12px; background: linear-gradient(135deg, #059669 0%, #0d9488 100%); color: white; border: none; font-weight: 900; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);">
                    <span id="mobileVerifyOtpBtnText">✅ Confirm & Place Order</span>
                    <i id="mobileVerifyOtpSpinner" class="fa-solid fa-spinner fa-spin" style="display: none;"></i>
                </button>

                <!-- Resend Timer -->
                <div style="text-align: center; margin-top: 12px; font-size: 0.72rem; color: #64748b;">
                    <div id="mobileOtpTimerBox">
                        Didn't receive code? Resend in <span id="mobileOtpCountdown" style="font-weight: 800; color: #0f172a;">30s</span>
                    </div>
                    <button type="button" id="mobileResendOtpBtn" onclick="requestMobileOtp(true)" style="display: none; background: none; border: none; color: #059669; font-weight: 800; text-decoration: underline; cursor: pointer; font-size: 0.72rem;">
                        <i class="fa-solid fa-rotate-right" style="font-size: 11px;"></i> Resend OTP on WhatsApp
                    </button>
                </div>

                <p style="font-size: 0.68rem; color: #94a3b8; text-align: center; margin: 12px 0 0 0;">
                    🔒 100% Secure Diwali Crackers Booking. We only deliver inside Tamil Nadu.
                </p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const MIN_ORDER_AMOUNT = {{ (float) ($shop['min_order_amount'] ?? 2500) }};

    function updateMinOrderUI(totalPayable) {
        const percent = Math.min(100, Math.round((totalPayable / MIN_ORDER_AMOUNT) * 100));
        const progressBar = document.getElementById('minOrderProgressBar');
        const alertBox = document.getElementById('minOrderAlertBox');
        const icon = document.getElementById('minOrderIcon');
        const title = document.getElementById('minOrderTitle');
        const badge = document.getElementById('minOrderBadge');
        const text = document.getElementById('minOrderText');

        if (progressBar) progressBar.style.width = percent + '%';

        if (totalPayable >= MIN_ORDER_AMOUNT) {
            if (alertBox) {
                alertBox.style.background = '#f0fdf4';
                alertBox.style.borderColor = '#bbf7d0';
                alertBox.style.color = '#14532d';
            }
            if (icon) {
                icon.className = 'fa-solid fa-circle-check';
                icon.style.color = '#16a34a';
            }
            if (title) title.textContent = 'Minimum Order Met (₹' + Number(MIN_ORDER_AMOUNT).toLocaleString('en-IN') + '+)';
            if (badge) {
                badge.style.background = '#dcfce7';
                badge.style.color = '#15803d';
                badge.textContent = 'தகுதி பெறப்பட்டது ✅';
            }
            if (text) {
                text.textContent = 'சூப்பர்! உங்கள் கார்ட் குறைந்தபட்ச ஆர்டர் தகுதியை எட்டியுள்ளது (₹' + totalPayable.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '). நீங்கள் ஆர்டர் சமர்ப்பிக்கலாம்!';
            }
            if (progressBar) progressBar.style.background = '#16a34a';
        } else {
            const diff = Math.max(0, MIN_ORDER_AMOUNT - totalPayable);
            const diffFmt = '₹' + diff.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            if (alertBox) {
                alertBox.style.background = '#fff1f2';
                alertBox.style.borderColor = '#fecdd3';
                alertBox.style.color = '#881337';
            }
            if (icon) {
                icon.className = 'fa-solid fa-circle-exclamation';
                icon.style.color = '#e11d48';
            }
            if (title) title.textContent = 'Minimum Order: ₹' + Number(MIN_ORDER_AMOUNT).toLocaleString('en-IN');
            if (badge) {
                badge.style.background = '#ffe4e6';
                badge.style.color = '#9f1239';
                badge.textContent = '₹' + Number(diff).toLocaleString('en-IN') + ' தேவை';
            }
            if (text) {
                text.innerHTML = 'குறைந்தபட்ச ஆர்டர் தொகை <strong>₹' + Number(MIN_ORDER_AMOUNT).toLocaleString('en-IN') + '</strong>. உங்கள் ஆர்டரை உறுதி செய்ய இன்னும் <strong>' + diffFmt + '</strong> மதிப்புள்ள பட்டாசுகளை Cart-ல் சேர்க்க வேண்டும்.';
            }
            if (progressBar) progressBar.style.background = '#e11d48';
        }
    }

    // Cart storage state
    let cart = JSON.parse(localStorage.getItem('guru_cracker_cart') || '{}');
    // Enforce maximum 20 units per item
    for (const k in cart) {
        if (cart[k] && cart[k].qty > 20) {
            cart[k].qty = 20;
        }
    }

    function saveCart() {
        localStorage.setItem('guru_cracker_cart', JSON.stringify(cart));
        renderCartUI();
    }

    async function clearCart() {
        if (!cart || Object.keys(cart).length === 0) return;
        const confirmed = await window.showAppConfirm({
            title: 'Clear Cart?',
            message: 'Are you sure you want to remove all items from your cart?',
            icon: 'fa-solid fa-trash-can',
            type: 'danger',
            confirmText: 'Yes, Clear All',
            cancelText: 'Keep Items'
        });
        if (confirmed) {
            cart = {};
            saveCart();
            renderCartUI();
            if (window.showToast) window.showToast('Cart cleared', 'info');
        }
    }

    window.stepQuantity = function(productId, delta) {
        const input = document.getElementById('qty-input-' + productId);
        const card = document.getElementById('prod-card-' + productId);
        const name = (card ? card.getAttribute('data-name-clean') : (input ? input.getAttribute('data-name') : '')) || '';
        const rate = parseFloat(card ? card.getAttribute('data-rate') : (input ? input.getAttribute('data-rate') : 0)) || 0;
        const actualRate = parseFloat((card ? card.getAttribute('data-actual-rate') : (input ? input.getAttribute('data-actual-rate') : rate)) || rate);
        const tamil = (card ? card.getAttribute('data-tamil-clean') : (input ? input.getAttribute('data-tamil') : '')) || '';

        let current = parseInt(input ? input.value : (cart[productId]?.qty || 0)) || 0;
        if (delta > 0 && current >= 20) {
            if (window.showToast) {
                window.showToast('⚠️ Maximum 20 units allowed per item', 'warning');
            }
            return;
        }
        let next = Math.max(0, Math.min(20, current + delta));
        setProductQuantity(productId, next, rate, name, actualRate, tamil);
    };

    window.setProductQuantity = function(id, qty, rate, name, actualRate = 0, tamilName = '') {
        actualRate = actualRate || rate;
        qty = parseInt(qty) || 0;
        if (qty < 0) qty = 0;
        if (qty > 20) {
            qty = 20;
            if (window.showToast) {
                window.showToast('⚠️ Maximum 20 units allowed per item', 'warning');
            }
        }

        const isNew = (!cart[id] || cart[id].qty === 0) && qty > 0;

        if (qty === 0) {
            delete cart[id];
        } else {
            cart[id] = {
                id: id,
                qty: qty,
                rate: rate,
                actualRate: actualRate,
                name: name,
                tamilName: tamilName
            };
        }
        saveCart();
        if (isNew && window.showToast) {
            window.showToast('💥 Added ' + name + ' to cart', 'success');
        }
    };

    window.handleQtyInputChange = function(input) {
        const id = input.getAttribute('data-id');
        const card = document.getElementById('prod-card-' + id);
        const name = input.getAttribute('data-name') || (card ? card.getAttribute('data-name-clean') : '');
        const rate = parseFloat(input.getAttribute('data-rate') || (card ? card.getAttribute('data-rate') : 0)) || 0;
        const actualRate = parseFloat(input.getAttribute('data-actual-rate') || (card ? card.getAttribute('data-actual-rate') : rate) || rate);
        const tamil = input.getAttribute('data-tamil') || (card ? card.getAttribute('data-tamil-clean') : '');

        let val = parseInt(input.value);
        if (isNaN(val) || val < 0) {
            input.value = 0;
            val = 0;
        } else if (val > 20) {
            input.value = 20;
            val = 20;
            if (window.showToast) {
                window.showToast('⚠️ Maximum 20 units allowed per item', 'warning');
            }
        }
        setProductQuantity(id, val, rate, name, actualRate, tamil);
    };

    function handleStepperClick(btn, delta) {
        const card = btn.closest('.product-card');
        if (!card) return;
        const id = card.getAttribute('data-prod-id');
        stepQuantity(id, delta);
    }

    function updateQty(id, delta, rate, name, actualRate = 0, tamilName = '') {
        stepQuantity(id, delta);
    }

    function removeCartItem(id) {
        if (cart[id]) {
            const itemName = cart[id].name || 'Item';
            delete cart[id];
            saveCart();
            renderCartUI();
            if (window.showToast) window.showToast(itemName + ' removed', 'info');
        }
    }

    function renderCartUI() {
        let totalItems = 0;
        let totalPrice = 0;
        let totalMrp = 0;
        let totalVarieties = 0;

        // Reset all card steppers & line totals & in-cart classes
        document.querySelectorAll('.qty-input').forEach(input => {
            if (document.activeElement !== input) {
                input.value = 0;
            }
        });
        document.querySelectorAll('.line-total-display').forEach(el => {
            el.textContent = '₹0.00';
            el.classList.remove('active');
        });
        document.querySelectorAll('.product-card').forEach(card => card.classList.remove('in-cart'));

        for (const [id, item] of Object.entries(cart)) {
            const input = document.getElementById(`qty-input-${id}`);
            if (input && document.activeElement !== input) {
                input.value = item.qty;
            }

            const lineTotalEl = document.getElementById(`line-total-${id}`);
            const lineTotal = item.qty * item.rate;
            if (lineTotalEl) {
                lineTotalEl.textContent = `₹${lineTotal.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                if (item.qty > 0) lineTotalEl.classList.add('active');
            }

            const card = document.getElementById(`prod-card-${id}`);
            if (card && item.qty > 0) {
                card.classList.add('in-cart');
            }

            totalItems += item.qty;
            totalPrice += item.qty * item.rate;
            totalMrp += item.qty * (item.actualRate || item.rate);
            totalVarieties++;
        }

        const totalSavings = Math.max(0, totalMrp - totalPrice);

        // Update Bottom Nav Badge
        const navBadge = document.getElementById('nav-cart-badge');
        if (navBadge) {
            navBadge.textContent = totalItems;
            navBadge.style.display = totalItems > 0 ? 'flex' : 'none';
        }

        // Update Varieties Count Badge in Review Header
        const varBadge = document.getElementById('varietiesCountBadge');
        if (varBadge) {
            varBadge.textContent = `${totalVarieties} ${totalVarieties === 1 ? 'Variety' : 'Varieties'}`;
        }

        // Update Floating Cart Bar
        const bar = document.getElementById('floatingCart');
        if (bar) {
            if (totalItems > 0) {
                bar.style.display = 'flex';
                document.getElementById('cartBarQty').textContent = `${totalItems} ${totalItems === 1 ? 'Item' : 'Items'} Added`;
                document.getElementById('cartBarTotal').textContent = `₹${totalPrice.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                
                const mrpEl = document.getElementById('cartBarMrp');
                const saveEl = document.getElementById('cartBarSave');
                if (totalSavings > 0) {
                    mrpEl.style.display = 'inline';
                    mrpEl.textContent = `₹${totalMrp.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                    saveEl.style.display = 'inline-block';
                    saveEl.textContent = `Save ₹${totalSavings.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                } else {
                    mrpEl.style.display = 'none';
                    saveEl.style.display = 'none';
                }
            } else {
                bar.style.display = 'none';
            }
        }

        // Cart Empty State vs Filled State toggling
        const emptyState = document.getElementById('cartEmptyState');
        const filledState = document.getElementById('cartFilledState');
        if (totalItems === 0) {
            if (emptyState) emptyState.style.display = 'flex';
            if (filledState) filledState.style.display = 'none';
        } else {
            if (emptyState) emptyState.style.display = 'none';
            if (filledState) filledState.style.display = 'block';
        }

        // Populate Review Items List (SCREENSHOT 2 REPLICA: NO STEPPERS, JUST ITEM + CALC + TRASH)
        const drawerContainer = document.getElementById('drawerCartItems');
        if (drawerContainer && totalItems > 0) {
            let html = '';
            for (const [id, item] of Object.entries(cart)) {
                const displayName = (item.name || '').replace(/\\'/g, "'").replace(/\\"/g, '"');
                const displayTamil = (item.tamilName || '').replace(/\\'/g, "'").replace(/\\"/g, '"');
                const tamilHtml = displayTamil ? `<span class="web-tamil-tag">(${displayTamil})</span>` : '';
                const lineTotalFormatted = (item.rate * item.qty).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                const rateFormatted = item.rate.toFixed(2);
                html += `
                    <div class="web-cart-item-row">
                        <div class="web-cart-item-info">
                            <div class="web-cart-item-name">
                                ${displayName} ${tamilHtml} <span class="web-unit-tag">${item.qty} ${item.qty === 1 ? 'Box' : 'Boxes'}</span>
                            </div>
                            <div class="web-cart-item-rate-calc">₹${rateFormatted} × ${item.qty}</div>
                        </div>
                        <div class="web-cart-item-price-col">
                            <span class="web-cart-item-total">₹${lineTotalFormatted}</span>
                            <button type="button" class="web-cart-trash-btn" onclick="removeCartItem(${item.id})" title="Remove item">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                `;
            }
            drawerContainer.innerHTML = html;
        }

        const mrpFormatted = `₹${totalMrp.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        const discountFormatted = `- ₹${totalSavings.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        const totalFormatted = `₹${totalPrice.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

        if (document.getElementById('drawerTotalMrp')) document.getElementById('drawerTotalMrp').textContent = mrpFormatted;
        if (document.getElementById('drawerTotalDiscount')) document.getElementById('drawerTotalDiscount').textContent = discountFormatted;
        if (document.getElementById('drawerGrandTotal')) document.getElementById('drawerGrandTotal').textContent = totalFormatted;
        if (document.getElementById('btnTotalText')) document.getElementById('btnTotalText').textContent = totalFormatted;
        updateMinOrderUI(totalPrice);
    }

    // SPA Single-Page View Switcher (Instant 0ms Screen Switching)
    window.switchTab = function(tabName, pushState = true) {
        const validTabs = ['catalog', 'cart', 'track'];
        if (!validTabs.includes(tabName)) tabName = 'catalog';

        // Hide all views & show target view
        document.querySelectorAll('.app-view').forEach(v => v.classList.remove('active'));
        const targetView = document.getElementById('view-' + tabName);
        if (targetView) targetView.classList.add('active');

        // Update bottom navigation bar active state
        document.querySelectorAll('.bottom-nav .nav-item').forEach(v => v.classList.remove('active'));
        const targetNav = document.getElementById('nav-item-' + tabName);
        if (targetNav) targetNav.classList.add('active');

        // Tab-specific hooks
        if (tabName === 'cart') {
            renderCartUI();
        } else if (tabName === 'track') {
            const trackInput = document.getElementById('trackQuery');
            if (trackInput && !trackInput.value) {
                setTimeout(() => trackInput.focus(), 150);
            }
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });

        if (pushState) {
            history.pushState({ tab: tabName }, '', '#' + tabName);
        }
    };

    function openCartDrawer() {
        window.switchTab('cart');
    }

    function closeCartDrawer() {
        window.switchTab('catalog');
    }

    // Category Filter Pills logic ("scroll illa ma" - Instant Category Filter)
    function selectCategory(catId, btn) {
        document.querySelectorAll('.cat-pill').forEach(el => el.classList.remove('active'));
        if (btn) {
            btn.classList.add('active');
            btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }

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

        // Smooth scroll to top of catalog content
        const catalogEl = document.getElementById('catalogContent');
        if (catalogEl) {
            window.scrollTo({ top: catalogEl.offsetTop - 110, behavior: 'smooth' });
        }
    }

    // Product Search Filter
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
        filterProducts();
    }

    // Back to top floating button
    window.addEventListener('scroll', () => {
        const btn = document.getElementById('backToTopBtn');
        if (btn) {
            if (window.scrollY > 300) {
                btn.style.display = 'flex';
            } else {
                btn.style.display = 'none';
            }
        }
    });

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Banner carousel auto scroll (SAFE: Scrolls ONLY the horizontal carousel container, NEVER the window!)
    function scrollToBanner(index) {
        const container = document.getElementById('bannerContainer');
        if (!container) return;
        const slides = container.querySelectorAll('.banner-slide');
        if (slides[index]) {
            const targetLeft = slides[index].offsetLeft - container.offsetLeft;
            container.scrollTo({ left: targetLeft, behavior: 'smooth' });
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

        let bannerIdx = 0;
        let bannerTimer = null;

        function startBannerTimer() {
            if (bannerTimer) clearInterval(bannerTimer);
            bannerTimer = setInterval(() => {
                // If user has scrolled down into products, PAUSE carousel so it doesn't disturb user
                const rect = bannerContainer.getBoundingClientRect();
                if (rect.bottom < 20 || rect.top > window.innerHeight) {
                    return; // Skip when banner is off-screen
                }
                const slides = bannerContainer.querySelectorAll('.banner-slide');
                if (slides.length <= 1) return;
                bannerIdx = (bannerIdx + 1) % slides.length;
                scrollToBanner(bannerIdx);
            }, 5000);
        }

        startBannerTimer();

        // Pause on touch interaction and resume afterwards
        bannerContainer.addEventListener('touchstart', () => {
            if (bannerTimer) clearInterval(bannerTimer);
        }, { passive: true });

        bannerContainer.addEventListener('touchend', () => {
            startBannerTimer();
        }, { passive: true });
    }

    // Input sanitizers matching web application
    const nameInp = document.getElementById('nameInput');
    if (nameInp) {
        nameInp.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-Z\s.]/g, '');
            if (this.value.trim().length >= 3) {
                clearWebError('name');
            }
        });
    }

    const phone1Inp = document.getElementById('phone1Input');
    if (phone1Inp) {
        phone1Inp.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            // Invalidate OTP verification if mobile is edited
            verifiedOtpToken = '';
            if (this.value.length === 10 && /^[6-9]/.test(this.value)) {
                clearWebError('phone1');
            }
        });
    }

    // ==========================================
    // Mobile WhatsApp OTP Verification Logic
    // ==========================================
    let verifiedOtpToken = '';
    let mobileOtpInterval = null;
    let lastOtpSentPhone = '';
    let lastOtpSentTimestamp = 0;

    window.openMobileOtpModal = function() {
        const modal = document.getElementById('mobileOtpModal');
        const phone = document.getElementById('phone1Input')?.value.trim() || '';
        const displayPhone = document.getElementById('mobileOtpDisplayPhone');
        const digitInputs = document.querySelectorAll('.mobile-otp-digit');

        if (displayPhone) {
            displayPhone.textContent = phone ? `+91 ${phone}` : '+91 ----------';
        }
        if (modal) {
            modal.style.display = 'flex';
        }
        digitInputs.forEach(i => i.value = '');
        if (digitInputs.length > 0) {
            setTimeout(() => digitInputs[0].focus(), 150);
        }
    };

    window.closeMobileOtpModal = function() {
        const modal = document.getElementById('mobileOtpModal');
        if (modal) modal.style.display = 'none';
    };

    window.editPhoneFromMobileOtp = function() {
        closeMobileOtpModal();
        const p1 = document.getElementById('phone1Input');
        if (p1) {
            p1.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => p1.focus(), 300);
        }
    };

    function showMobileOtpStatus(type, msg) {
        const statusBox = document.getElementById('mobileOtpStatusMsg');
        if (!statusBox) return;
        statusBox.style.display = 'block';
        if (type === 'error') {
            statusBox.style.background = '#fef2f2';
            statusBox.style.color = '#dc2626';
            statusBox.style.border = '1px solid #fecaca';
            statusBox.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> ${msg}`;
        } else if (type === 'success') {
            statusBox.style.background = '#f0fdf4';
            statusBox.style.color = '#16a34a';
            statusBox.style.border = '1px solid #bbf7d0';
            statusBox.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${msg}`;
        } else {
            statusBox.style.background = '#f8fafc';
            statusBox.style.color = '#475569';
            statusBox.style.border = '1px solid #e2e8f0';
            statusBox.innerHTML = msg;
        }
    }

    function clearMobileOtpStatus() {
        const statusBox = document.getElementById('mobileOtpStatusMsg');
        if (statusBox) statusBox.style.display = 'none';
    }

    function startMobileOtpCountdown(sec = 30) {
        clearInterval(mobileOtpInterval);
        const timerBox = document.getElementById('mobileOtpTimerBox');
        const resendBtn = document.getElementById('mobileResendOtpBtn');
        const countdownEl = document.getElementById('mobileOtpCountdown');

        if (timerBox) timerBox.style.display = 'block';
        if (resendBtn) resendBtn.style.display = 'none';

        let remaining = sec;
        if (countdownEl) countdownEl.textContent = `${remaining}s`;

        mobileOtpInterval = setInterval(() => {
            remaining--;
            if (countdownEl) countdownEl.textContent = `${remaining}s`;
            if (remaining <= 0) {
                clearInterval(mobileOtpInterval);
                if (timerBox) timerBox.style.display = 'none';
                if (resendBtn) {
                    resendBtn.style.display = 'inline-block';
                    resendBtn.disabled = false;
                }
            }
        }, 1000);
    }

    window.requestMobileOtp = async function(isResend = false) {
        const phone = document.getElementById('phone1Input')?.value.trim() || '';
        const name = document.getElementById('nameInput')?.value.trim() || '';
        const resendBtn = document.getElementById('mobileResendOtpBtn');

        if (!phone || !/^[6-9][0-9]{9}$/.test(phone)) {
            showMobileOtpStatus('error', 'Please enter a valid 10-digit WhatsApp number.');
            return;
        }

        const now = Date.now();
        if (!isResend && phone === lastOtpSentPhone && (now - lastOtpSentTimestamp < 30000)) {
            const rem = Math.ceil((30000 - (now - lastOtpSentTimestamp)) / 1000);
            showMobileOtpStatus('success', 'Verification code already sent. Please enter the 4 digits.');
            startMobileOtpCountdown(rem);
            return;
        }

        if (isResend && resendBtn) {
            resendBtn.disabled = true;
            resendBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Resending...';
        }

        clearMobileOtpStatus();
        const digitInputs = document.querySelectorAll('.mobile-otp-digit');
        digitInputs.forEach(i => i.value = '');
        if (digitInputs.length > 0) digitInputs[0].focus();

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch('{{ route("mobile.send_otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ phone1: phone, name: name })
            });

            const data = await res.json();
            if (data.success) {
                lastOtpSentPhone = phone;
                lastOtpSentTimestamp = Date.now();
                showMobileOtpStatus('success', data.message || 'OTP sent to your WhatsApp number!');
                startMobileOtpCountdown(data.cooldown || 30);
                if (data.masked_phone) {
                    const disp = document.getElementById('mobileOtpDisplayPhone');
                    if (disp) disp.textContent = data.masked_phone;
                }
            } else {
                showMobileOtpStatus('error', data.message || 'Failed to send OTP. Please try again.');
                if (data.cooldown) {
                    startMobileOtpCountdown(30);
                } else if (resendBtn) {
                    resendBtn.style.display = 'inline-block';
                    resendBtn.disabled = false;
                }
            }
        } catch (e) {
            showMobileOtpStatus('error', 'Network error. Please check your internet connection.');
            if (resendBtn) {
                resendBtn.style.display = 'inline-block';
                resendBtn.disabled = false;
            }
        } finally {
            if (isResend && resendBtn) {
                resendBtn.innerHTML = '<i class="fa-solid fa-rotate-right" style="font-size: 11px;"></i> Resend OTP on WhatsApp';
            }
        }
    };

    let isMobileVerifyingOtp = false;
    window.submitMobileOtpVerification = async function() {
        if (isMobileVerifyingOtp) return;
        const phone = document.getElementById('phone1Input')?.value.trim() || '';
        const digitInputs = document.querySelectorAll('.mobile-otp-digit');
        const otp = Array.from(digitInputs).map(i => i.value.trim()).join('');
        const btn = document.getElementById('mobileVerifyOtpBtn');
        const spinner = document.getElementById('mobileVerifyOtpSpinner');
        const btnText = document.getElementById('mobileVerifyOtpBtnText');

        if (otp.length !== 4) {
            showMobileOtpStatus('error', 'Please enter all 4 digits sent to your WhatsApp.');
            const empty = Array.from(digitInputs).find(i => !i.value.trim());
            if (empty) empty.focus();
            return;
        }

        if (btn) btn.disabled = true;
        if (spinner) spinner.style.display = 'inline-block';
        if (btnText) btnText.textContent = 'Verifying...';
        clearMobileOtpStatus();
        isMobileVerifyingOtp = true;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch('{{ route("mobile.verify_otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ phone1: phone, otp: otp })
            });

            const data = await res.json();
            if (data.success && data.token) {
                verifiedOtpToken = data.token;
                showMobileOtpStatus('success', 'Verified successfully! Placing order...');
                setTimeout(() => {
                    closeMobileOtpModal();
                    // Proceed with checkout with verified token
                    handleCheckout(null);
                }, 400);
            } else {
                showMobileOtpStatus('error', data.message || 'Incorrect OTP code. Please try again.');
                digitInputs.forEach(i => {
                    i.style.borderColor = '#f87171';
                    i.value = '';
                });
                setTimeout(() => {
                    digitInputs.forEach(i => i.style.borderColor = '#cbd5e1');
                }, 1500);
                if (digitInputs.length > 0) digitInputs[0].focus();
                if (btn) btn.disabled = false;
                if (spinner) spinner.style.display = 'none';
                if (btnText) btnText.textContent = '✅ Confirm & Place Order';
                isMobileVerifyingOtp = false;
            }
        } catch (e) {
            showMobileOtpStatus('error', 'Network error. Please try again.');
            if (btn) btn.disabled = false;
            if (spinner) spinner.style.display = 'none';
            if (btnText) btnText.textContent = '✅ Confirm & Place Order';
        }
    };

    // Attach digit inputs events
    document.querySelectorAll('.mobile-otp-digit').forEach((input, idx, all) => {
        input.addEventListener('input', (e) => {
            const val = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = val ? val.slice(-1) : '';
            if (e.target.value && idx < all.length - 1) {
                all[idx + 1].focus();
                all[idx + 1].select();
            }
            const full = Array.from(all).map(i => i.value.trim()).join('');
            if (full.length === 4) {
                submitMobileOtpVerification();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && idx > 0) {
                all[idx - 1].focus();
                all[idx - 1].select();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                submitMobileOtpVerification();
            }
        });

        input.addEventListener('focus', function() {
            this.select();
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text') || '';
            const digits = pasted.replace(/[^0-9]/g, '').slice(0, 4);
            if (digits) {
                digits.split('').forEach((d, i) => {
                    if (all[i]) all[i].value = d;
                });
                const next = Math.min(digits.length, all.length - 1);
                all[next].focus();
                if (digits.length === 4) {
                    submitMobileOtpVerification();
                }
            }
        });
    });

    const phone2Inp = document.getElementById('phone2Input');
    if (phone2Inp) {
        phone2Inp.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            if (this.value.length === 10 && /^[6-9]/.test(this.value)) {
                clearWebError('phone2');
            }
        });
    }

    const cityInp = document.getElementById('cityInput');
    if (cityInp) {
        cityInp.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-Z\s.-]/g, '');
            if (this.value.trim().length >= 2) {
                clearWebError('city');
            }
        });
    }

    let lastFetchedPincode = '';
    let pincodeTimer = null;
    function autoLookupPincode(pin) {
        const cleanPin = pin.replace(/[^0-9]/g, '');
        const spinner = document.getElementById('pincodeSpinner');
        const successIcon = document.getElementById('pincodeSuccessIcon');
        const successMsg = document.getElementById('pincodeSuccessMsg');
        const successText = document.getElementById('pincodeSuccessText');
        const cityInput = document.getElementById('cityInput');

        if (cleanPin.length !== 6) {
            if (spinner) spinner.style.display = 'none';
            if (successIcon) successIcon.style.display = 'none';
            if (successMsg) successMsg.style.display = 'none';
            return;
        }

        if (!/^6[0-4][0-9]{4}$/.test(cleanPin)) {
            if (spinner) spinner.style.display = 'none';
            if (successIcon) successIcon.style.display = 'none';
            if (successMsg) successMsg.style.display = 'none';
            showWebError('pincode', 'Delivery is available inside Tamil Nadu only. (Pincode: 60xxxx - 64xxxx)');
            return;
        }

        clearWebError('pincode');
        if (cleanPin === lastFetchedPincode) return;

        if (spinner) spinner.style.display = 'inline-block';
        if (successIcon) successIcon.style.display = 'none';
        if (successMsg) successMsg.style.display = 'none';

        fetch('/pincode/' + cleanPin)
            .then(res => res.json())
            .then(data => {
                if (spinner) spinner.style.display = 'none';
                if (data.success && (data.city || data.district)) {
                    lastFetchedPincode = cleanPin;
                    const cityName = data.city || data.district;
                    if (cityInput && (!cityInput.value.trim() || cityInput.value === 'Tamil Nadu')) {
                        cityInput.value = cityName;
                        clearWebError('city');
                    }
                    if (successIcon) successIcon.style.display = 'inline-block';
                    if (successMsg && successText) {
                        successText.textContent = `Auto-detected: ${cityName}, Tamil Nadu`;
                        successMsg.style.display = 'flex';
                    }
                } else if (!data.is_serviceable && data.message) {
                    showWebError('pincode', data.message);
                }
            })
            .catch(err => {
                if (spinner) spinner.style.display = 'none';
                console.warn('Pincode lookup error:', err);
            });
    }

    const pincodeInp = document.getElementById('pincodeInput');
    if (pincodeInp) {
        pincodeInp.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
            clearTimeout(pincodeTimer);
            if (this.value.length === 6) {
                pincodeTimer = setTimeout(() => autoLookupPincode(this.value), 250);
            } else {
                lastFetchedPincode = '';
                const sc = document.getElementById('pincodeSuccessIcon');
                const sm = document.getElementById('pincodeSuccessMsg');
                if (sc) sc.style.display = 'none';
                if (sm) sm.style.display = 'none';
            }
        });
    }

    function showWebError(field, msg) {
        const errEl = document.getElementById('err-' + field);
        if (errEl) {
            const span = errEl.querySelector('span');
            if (span) span.textContent = msg;
            errEl.style.display = 'flex';
        }
        if (field === 'phone1') {
            document.getElementById('phone1Group')?.classList.add('is-invalid');
        } else if (field === 'phone2') {
            document.getElementById('phone2Group')?.classList.add('is-invalid');
        } else {
            const input = document.getElementById(field === 'delivery_address' ? 'deliveryAddressInput' : field + 'Input');
            input?.classList.add('is-invalid');
        }
    }

    function clearWebError(field) {
        const errEl = document.getElementById('err-' + field);
        if (errEl) {
            errEl.style.display = 'none';
        }
        if (field === 'phone1') {
            document.getElementById('phone1Group')?.classList.remove('is-invalid');
        } else if (field === 'phone2') {
            document.getElementById('phone2Group')?.classList.remove('is-invalid');
        } else {
            const input = document.getElementById(field === 'delivery_address' ? 'deliveryAddressInput' : field + 'Input');
            input?.classList.remove('is-invalid');
        }
    }

    // Client-side Checkout with Strict Validation Matching Web Application
    async function handleCheckout(event) {
        if (event && event.preventDefault) event.preventDefault();
        const errEl = document.getElementById('checkoutError');
        if (errEl) errEl.style.display = 'none';

        if (Object.keys(cart).length === 0) {
            if (errEl) {
                errEl.textContent = 'Please select at least one product with quantity.';
                errEl.style.display = 'block';
            }
            return;
        }

        // Calculate current total cart value
        let currentTotal = 0;
        for (const [id, item] of Object.entries(cart)) {
            currentTotal += (item.qty || 0) * (item.rate || 0);
        }

        // 1. Minimum Order Amount Check (₹2,500)
        if (currentTotal < MIN_ORDER_AMOUNT) {
            const diff = Math.max(0, MIN_ORDER_AMOUNT - currentTotal);
            const diffFmt = '₹' + diff.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            const totalFmt = '₹' + currentTotal.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            const minFmt = '₹' + Number(MIN_ORDER_AMOUNT).toLocaleString('en-IN');
            const warnMsg = `எங்கள் இணையதளத்தில் குறைந்தபட்ச ஆர்டர் தொகை ${minFmt} ஆகும். உங்கள் தற்போதைய கார்ட் மதிப்பு ${totalFmt} மட்டுமே உள்ளது. தயவுசெய்து மேலும் ${diffFmt} மதிப்புள்ள பட்டாசுகளை Cart-ல் சேர்த்து சமர்ப்பிக்கவும்.`;

            if (errEl) {
                errEl.innerHTML = `<strong>⚠️ குறைந்தபட்ச ஆர்டர் ${minFmt}!</strong><br>${warnMsg}`;
                errEl.style.display = 'block';
                errEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            if (window.showAppAlert) {
                window.showAppAlert({
                    title: `குறைந்தபட்ச ஆர்டர் ${minFmt}! ⚠️`,
                    message: warnMsg,
                    icon: 'fa-solid fa-triangle-exclamation',
                    type: 'warning',
                    btnText: 'பட்டாசுகளைச் சேர்க்கவும்'
                });
            } else {
                alert(`⚠️ குறைந்தபட்ச ஆர்டர் ${minFmt}!

${warnMsg}`);
            }
            return;
        }

        // Validate customer form fields
        let hasError = false;
        const nameVal = document.getElementById('nameInput')?.value.trim() || '';
        const phone1Val = document.getElementById('phone1Input')?.value.trim() || '';
        const phone2Val = document.getElementById('phone2Input')?.value.trim() || '';
        const addressVal = document.getElementById('deliveryAddressInput')?.value.trim() || '';
        const cityVal = document.getElementById('cityInput')?.value.trim() || '';
        const stateVal = 'Tamil Nadu';
        const pincodeVal = document.getElementById('pincodeInput')?.value.trim() || '';

        if (!nameVal || nameVal.length < 3) {
            showWebError('name', 'Customer full name is required (minimum 3 letters)');
            hasError = true;
        } else {
            clearWebError('name');
        }

        if (!phone1Val || !/^[6-9][0-9]{9}$/.test(phone1Val)) {
            showWebError('phone1', 'WhatsApp mobile number must be 10 digits starting with 6, 7, 8, or 9');
            hasError = true;
        } else {
            clearWebError('phone1');
        }

        if (phone2Val) {
            if (!/^[6-9][0-9]{9}$/.test(phone2Val)) {
                showWebError('phone2', 'Alternate mobile number must be 10 digits starting with 6, 7, 8, or 9');
                hasError = true;
            } else if (phone2Val === phone1Val) {
                showWebError('phone2', 'Alternate mobile cannot be the same as WhatsApp number');
                hasError = true;
            } else {
                clearWebError('phone2');
            }
        } else {
            clearWebError('phone2');
        }

        if (!addressVal || addressVal.length < 5) {
            showWebError('delivery_address', 'Delivery address / nearest transport hub is required');
            hasError = true;
        } else {
            clearWebError('delivery_address');
        }

        if (!cityVal || cityVal.length < 2) {
            showWebError('city', 'City / Town name is required');
            hasError = true;
        } else {
            clearWebError('city');
        }

        if (!pincodeVal || !/^6[0-4][0-9]{4}$/.test(pincodeVal)) {
            showWebError('pincode', 'Delivery is available inside Tamil Nadu only. (Pincode: 60xxxx - 64xxxx)');
            hasError = true;
        } else {
            clearWebError('pincode');
        }

        if (hasError) {
            if (window.showToast) window.showToast('⚠️ Please complete all required delivery details', 'warning');
            const firstErr = document.querySelector('.web-field-error[style*="display: block"], .web-field-error[style*="display: flex"]');
            if (firstErr) {
                firstErr.closest('.web-form-group')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        // 2. WhatsApp OTP Verification Requirement
        if (!verifiedOtpToken) {
            openMobileOtpModal();
            requestMobileOtp(false);
            return;
        }

        const btn = document.getElementById('submitOrderBtn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting Order...';
        }

        if (window.showPageLoader) {
            window.showPageLoader('Submitting Order...', 'Direct booking to Sivakasi factory');
        }

        const payload = {
            name: nameVal,
            phone1: phone1Val,
            phone2: phone2Val || null,
            delivery_address: addressVal,
            city: cityVal,
            state: stateVal,
            pincode: pincodeVal,
            otp_token: verifiedOtpToken,
            products: {}
        };

        for (const [id, item] of Object.entries(cart)) {
            if (item.qty > 20) {
                if (window.showToast) window.showToast('⚠️ Maximum 20 units allowed per item', 'warning');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<span>🎆 Submit Order</span> <span class="web-btn-total-badge">' + document.getElementById('drawerGrandTotal').textContent + '</span> <i class="fa-solid fa-arrow-right"></i>';
                }
                if (window.hidePageLoader) window.hidePageLoader();
                return;
            }
            payload.products[id] = { qty: Math.min(20, item.qty) };
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
                localStorage.removeItem('guru_cracker_cart');
                cart = {};
                window.location.href = `/order-success/${data.order_number}`;
            } else {
                if (window.hidePageLoader) window.hidePageLoader();
                if (errEl) {
                    errEl.textContent = data.message || 'Validation failed. Please verify the entered details.';
                    errEl.style.display = 'block';
                }
                if (window.showAppAlert) {
                    window.showAppAlert({
                        title: 'Booking Notice',
                        message: data.message || 'Validation failed. Please verify the entered details.',
                        icon: 'fa-solid fa-triangle-exclamation',
                        type: 'warning',
                        btnText: 'Review Details'
                    });
                }
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<span>🎆 Submit Order</span> <span class="web-btn-total-badge">' + document.getElementById('drawerGrandTotal').textContent + '</span> <i class="fa-solid fa-arrow-right"></i>';
                }
            }
        } catch (e) {
            if (window.hidePageLoader) window.hidePageLoader();
            console.error('Checkout error:', e);
            if (errEl) {
                errEl.textContent = 'Network error connecting to store server. Please check your internet connection.';
                errEl.style.display = 'block';
            }
            if (window.showAppAlert) {
                window.showAppAlert({
                    title: 'Connection Issue',
                    message: 'Network error connecting to store server. Please check your internet connection and try again.',
                    icon: 'fa-solid fa-wifi',
                    type: 'error',
                    btnText: 'OK'
                });
            }
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<span>🎆 Submit Order</span> <span class="web-btn-total-badge">' + document.getElementById('drawerGrandTotal').textContent + '</span> <i class="fa-solid fa-arrow-right"></i>';
            }
        }
    }

    // Dynamic Live Catalog Loader Fallback & Skeleton Transitions
    async function checkAndLoadLiveCatalog() {
        const existingProducts = document.querySelectorAll('.product-card');
        const skeleton = document.getElementById('catalogSkeleton');
        const realContent = document.getElementById('catalogRealContent');

        if (existingProducts.length > 0) {
            // Server-side rendered: smooth skeleton transition
            if (skeleton) {
                skeleton.style.display = 'block';
                skeleton.style.opacity = '1';
                if (realContent) realContent.style.opacity = '0';

                setTimeout(() => {
                    skeleton.style.transition = 'opacity 0.25s ease';
                    skeleton.style.opacity = '0';
                    setTimeout(() => {
                        skeleton.style.display = 'none';
                        if (realContent) {
                            realContent.style.transition = 'opacity 0.25s ease';
                            realContent.style.opacity = '1';
                        }
                    }, 250);
                }, 350);
            }
            return;
        }

        // Show skeleton while fetching dynamically
        if (skeleton) {
            skeleton.style.display = 'block';
            skeleton.style.opacity = '1';
        }
        if (realContent) realContent.style.opacity = '0';

        try {
            const apiBase = "{{ $backendUrl ?? 'https://gurucrackers.onrender.com' }}";
            const res = await fetch(apiBase + '/api/v1/catalog', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();

            if (data.success && data.categories && data.categories.length > 0) {
                renderCategoriesAndProducts(data.categories);
                if (skeleton) {
                    skeleton.style.transition = 'opacity 0.25s ease';
                    skeleton.style.opacity = '0';
                    setTimeout(() => {
                        skeleton.style.display = 'none';
                        if (realContent) {
                            realContent.style.transition = 'opacity 0.25s ease';
                            realContent.style.opacity = '1';
                        }
                    }, 250);
                }
            } else {
                if (skeleton) skeleton.style.display = 'none';
                if (realContent) realContent.style.opacity = '1';
                showRetryUI('No products found in store catalog.');
            }
        } catch (err) {
            console.error('Client fetch failed:', err);
            if (skeleton) skeleton.style.display = 'none';
            if (realContent) realContent.style.opacity = '1';
            showRetryUI('Could not connect to store server. Please verify internet connection.');
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
        // Update Pills
        const catScroll = document.getElementById('categoryScroll');
        if (catScroll) {
            let totalProds = 0;
            categories.forEach(c => totalProds += (c.products ? c.products.length : 0));

            let pillsHtml = `
                <a href="javascript:void(0)" class="cat-pill active" onclick="selectCategory(null, this)">
                    <span>✨ All Crackers</span>
                    <span class="pill-count">${totalProds}</span>
                </a>
            `;
            categories.forEach(cat => {
                const count = cat.products ? cat.products.length : 0;
                pillsHtml += `
                    <a href="javascript:void(0)" class="cat-pill" onclick="selectCategory(${cat.id}, this)" data-cat-id="${cat.id}">
                        <span>💥 ${cat.name}</span>
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
                <div class="category-group" data-cat-id="${cat.id}" id="cat-group-${cat.id}">
                    <h2 class="category-title">
                        <div class="category-title-left">
                            <i class="fa-solid fa-burst" style="color: #dc2626;"></i>
                            <span>${cat.name}</span>
                        </div>
                        <span class="category-badge-count">${cat.products.length} Items</span>
                    </h2>
                    <div class="products-grid">
            `;

            cat.products.forEach(prod => {
                const defaultLogoUrl = "{{ asset('images/logo.png') }}";
                const imgTag = prod.image_url 
                    ? `<img src="${prod.image_url}" alt="${prod.name}" loading="lazy" class="prod-img" onerror="this.onerror=null; this.src='${defaultLogoUrl}'; this.classList.add('prod-img-fallback');">` 
                    : `<img src="${defaultLogoUrl}" alt="${prod.name}" loading="lazy" class="prod-img prod-img-fallback">`;

                const discountPercent = (prod.actual_rate && prod.actual_rate > prod.net_rate) 
                    ? Math.round(((prod.actual_rate - prod.net_rate) / prod.actual_rate) * 100) 
                    : 0;

                const discountBadge = discountPercent > 0 
                    ? `<span class="prod-discount-badge">${discountPercent}% OFF</span>` 
                    : '';

                const mrpRow = discountPercent > 0 
                    ? `<span class="prod-price-mrp">₹${Math.round(prod.actual_rate)}</span>` 
                    : '';

                const tamilHtml = prod.tamil_name 
                    ? `<div class="prod-tamil-title">${prod.tamil_name}</div>` 
                    : `<div style="height: 16px;"></div>`;

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
                        
                        <div class="prod-img-box">
                            ${discountBadge}
                            ${imgTag}
                        </div>

                        <div class="prod-info-block">
                            <div class="prod-title">${prod.name}</div>
                            ${tamilHtml}
                            <div class="prod-price-row">
                                <span class="prod-price-net">₹${Math.round(prod.net_rate)}</span>
                                ${mrpRow}
                            </div>
                        </div>

                        <div class="prod-action-bar">
                            <div class="prod-total-row">
                                <span class="prod-total-label">Total</span>
                                <span class="line-total-display" id="line-total-${prod.id}">₹0.00</span>
                            </div>
                            <div class="prod-stepper-ctrl">
                                <button type="button" class="stepper-ctrl-btn" onclick="stepQuantity(${prod.id}, -1)" title="Decrease quantity">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input type="number" min="0" max="20"
                                    value="0"
                                    id="qty-input-${prod.id}"
                                    class="qty-input stepper-val"
                                    data-id="${prod.id}"
                                    data-name="${safeName}"
                                    data-tamil="${safeTamil}"
                                    data-rate="${prod.net_rate}"
                                    data-actual-rate="${prod.actual_rate || prod.net_rate}"
                                    oninput="handleQtyInputChange(this)"
                                    onchange="handleQtyInputChange(this)"
                                    onfocus="if (this.value === '0') this.select();"
                                    placeholder="0"
                                    inputmode="numeric">
                                <button type="button" class="stepper-ctrl-btn" onclick="stepQuantity(${prod.id}, 1)" title="Increase quantity">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            contentHtml += `</div></div>`;
        });

        mainContent.innerHTML = contentHtml;
        renderCartUI();
    }

    // ==============================================================
    // COMPONENT 3: ORDER TRACKING LOGIC
    // ==============================================================
    let currentTrackTab = 'mobile';

    function switchTrackTab(tab) {
        currentTrackTab = tab;
        const input = document.getElementById('trackQuery');
        const tabMobile = document.getElementById('tabMobile');
        const tabOrder = document.getElementById('tabOrderId');
        const tip = document.getElementById('searchTip');

        if (tab === 'mobile') {
            tabMobile.classList.add('active');
            tabOrder.classList.remove('active');
            input.placeholder = 'Enter 10-digit mobile number';
            input.type = 'tel';
            input.maxLength = 10;
            tip.innerHTML = '<i class="fa-solid fa-circle-info"></i> Enter the phone number used during checkout to view all your booked orders.';
        } else {
            tabOrder.classList.add('active');
            tabMobile.classList.remove('active');
            input.placeholder = 'e.g. GC-20260925-XXXXX';
            input.type = 'text';
            input.removeAttribute('maxlength');
            tip.innerHTML = '<i class="fa-solid fa-circle-info"></i> Order ID is sent via SMS / WhatsApp confirmation.';
        }
        clearTrackInput();
        input.focus();
    }

    const defaultTrackPlaceholderHtml = `
        <div id="trackPlaceholder" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
            <div style="width: 70px; height: 70px; border-radius: 50%; background: #fef2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px auto; font-size: 28px;">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <p style="font-weight: 800; color: #1e293b; font-size: 1rem;">Track Sivakasi Dispatch Status</p>
            <p style="font-size: 0.82rem; color: #64748b; margin-top: 4px; max-width: 320px; margin-left: auto; margin-right: auto;">
                Instant updates on packing, transport parcel booking, LR copy, and doorstep delivery.
            </p>
        </div>
    `;

    const trackInputEl = document.getElementById('trackQuery');
    const trackClearBtn = document.getElementById('trackClearBtn');
    if (trackInputEl) {
        trackInputEl.addEventListener('input', function() {
            if (this.value.trim().length > 0) {
                trackClearBtn.style.display = 'flex';
            } else {
                trackClearBtn.style.display = 'none';
                const container = document.getElementById('trackResults');
                if (container) {
                    container.innerHTML = defaultTrackPlaceholderHtml;
                }
            }
        });
    }

    function clearTrackInput() {
        if (trackInputEl) {
            trackInputEl.value = '';
            if (trackClearBtn) trackClearBtn.style.display = 'none';
            const container = document.getElementById('trackResults');
            if (container) {
                container.innerHTML = defaultTrackPlaceholderHtml;
            }
            trackInputEl.focus();
        }
    }

    function copyToClipboard(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const original = btn.textContent;
            btn.textContent = 'Copied!';
            btn.style.background = '#16a34a';
            btn.style.color = '#ffffff';
            if (window.showToast) window.showToast('Order number copied: ' + text, 'success');
            setTimeout(() => {
                btn.textContent = original;
                btn.style.background = '#e2e8f0';
                btn.style.color = '#475569';
            }, 1800);
        }).catch(() => {
            if (window.showToast) window.showToast('Order number: ' + text, 'info');
        });
    }

    async function handleTrack(event) {
        if (event) event.preventDefault();
        const query = trackInputEl ? trackInputEl.value.trim() : '';
        if (!query) return;

        const btn = document.getElementById('trackSubmitBtn');
        const btnText = document.getElementById('trackBtnText');
        const container = document.getElementById('trackResults');

        btn.disabled = true;
        btnText.textContent = 'Searching Orders...';
        if (window.showPageLoader) {
            window.showPageLoader('Tracking Order...', 'Checking store records');
        }

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('{{ route("mobile.track") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ query: query, mode: currentTrackTab })
            });

            const data = await response.json();

            if (data.success && data.orders && data.orders.length > 0) {
                currentTrackedOrders = data.orders;
                let html = '';
                const backendUrl = "{{ $backendUrl ?? 'https://gurucrackers.onrender.com' }}";

                data.orders.forEach((order, index) => {
                    const paymentStatus = (order.payment_status || '').toLowerCase();
                    const orderStatus = (order.status || 'pending').toLowerCase();

                    // Resolve effective status strictly from orderStatus column
                    // Status lifecycle: pending -> confirmed (when paid) -> packed -> dispatched
                    // payment_status: only 'pending' or 'paid'
                    let status = orderStatus;
                    if (orderStatus === 'dispatched' || order.lr_number || order.parcel_service_name) {
                        status = 'dispatched';
                    } else if (orderStatus === 'packed') {
                        status = 'packed';
                    } else if (orderStatus === 'confirmed') {
                        status = 'confirmed';
                    } else if (orderStatus === 'cancelled') {
                        status = 'cancelled';
                    } else {
                        status = 'pending';
                    }

                    let statusLabel = 'Order Placed';
                    let statusClass = 'status-pending';
                    let statusIcon = 'fa-clock';

                    if (status === 'confirmed') {
                        statusLabel = 'Paid & Confirmed';
                        statusClass = 'status-processing';
                        statusIcon = 'fa-circle-check';
                    } else if (status === 'packed') {
                        statusLabel = 'Packed & Ready';
                        statusClass = 'status-processing';
                        statusIcon = 'fa-boxes-packing';
                    } else if (status === 'dispatched') {
                        const parcelLabel = order.parcel_service_name ? ` (${order.parcel_service_name})` : '';
                        statusLabel = `Dispatched${parcelLabel}`;
                        statusClass = 'status-dispatched';
                        statusIcon = 'fa-truck-fast';
                    } else if (status === 'cancelled') {
                        statusLabel = 'Cancelled';
                        statusClass = 'status-cancelled';
                        statusIcon = 'fa-ban';
                    }

                    // 4-step stepper: Placed -> Confirmed -> Packed -> Dispatched (no Delivered)
                    const step1 = true; // always: order is placed
                    const step2 = ['confirmed', 'packed', 'dispatched'].includes(status); // Paid & Confirmed
                    const step3 = ['packed', 'dispatched'].includes(status); // Packed
                    const step4 = status === 'dispatched'; // Dispatched

                    const isPaid = paymentStatus === 'paid';
                    const paymentBadgeHtml = isPaid
                        ? `<span style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; background: #dcfce7; color: #15803d; border-radius: 8px; font-weight: 700; font-size: 0.72rem;"><i class="fa-solid fa-check-double"></i> Paid & Verified</span>`
                        : `<span style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; background: #fef3c7; color: #b45309; border-radius: 8px; font-weight: 700; font-size: 0.72rem;"><i class="fa-solid fa-clock"></i> Payment Verification Pending</span>`;

                    const customerName = order.name || order.customer_name || 'Valued Customer';
                    const rawPhone = order.phone1 || order.phone || order.customer_phone || '';
                    const customerPhone = rawPhone ? `+91 ${rawPhone}` : 'Registered Contact';
                    
                    const hubName = order.destination_hub || order.city || 'Nearest Transport Hub';
                    const deliveryDisplay = order.delivery_address 
                        ? `${order.delivery_address}${order.city ? ', ' + order.city : ''}` 
                        : `Transport Hub, ${hubName}`;

                    // Transport & LR Details card
                    let transportHtml = '';
                    if (order.parcel_service_name || order.lr_number || status === 'dispatched') {
                        transportHtml = `
                            <div style="margin: 12px 14px; padding: 14px; background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%); border: 1.5px solid #d8b4fe; border-radius: 14px; box-shadow: 0 2px 10px rgba(126, 34, 206, 0.08);">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-size: 0.76rem; font-weight: 800; color: #6b21a8; text-transform: uppercase; display: flex; align-items: center; gap: 6px;">
                                        <i class="fa-solid fa-truck-fast"></i> Parcel Booking & LR Details
                                    </span>
                                    <span style="font-size: 0.70rem; font-weight: 800; padding: 3px 8px; background: #7e22ce; color: white; border-radius: 6px;">
                                        Dispatched & In Transit
                                    </span>
                                </div>
                                <div style="font-size: 0.82rem; color: #1e1b4b; line-height: 1.5;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                        <span style="color: #6b21a8; font-weight: 600;">Parcel Service:</span>
                                        <span style="font-weight: 800;">${order.parcel_service_name || 'A1 / MSS Transport'}</span>
                                    </div>
                                    ${order.lr_number ? `
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                        <span style="color: #6b21a8; font-weight: 600;">LR Slip Number:</span>
                                        <span style="font-family: monospace; font-size: 0.90rem; font-weight: 900; color: #581c87; letter-spacing: 0.5px;">${order.lr_number}</span>
                                    </div>` : ''}
                                    ${order.dispatch_date ? `
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                        <span style="color: #6b21a8; font-weight: 600;">Dispatched Date:</span>
                                        <span style="font-weight: 700;">${order.dispatch_date}</span>
                                    </div>` : ''}
                                    ${order.destination_hub ? `
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #6b21a8; font-weight: 600;">Delivery Hub:</span>
                                        <span style="font-weight: 700;">${order.destination_hub}</span>
                                    </div>` : ''}
                                </div>
                            </div>
                        `;
                    }

                    let itemsHtml = '';
                    if (order.items && order.items.length > 0) {
                        itemsHtml += `<div class="items-box">
                            <div class="items-box-title">
                                <span><i class="fa-solid fa-boxes-stacked"></i> Ordered Crackers (${order.items.length} ${order.items.length === 1 ? 'item' : 'items'})</span>
                            </div>`;
                        order.items.forEach(it => {
                            const itemName = it.product_name || (it.product ? it.product.name : 'Cracker Item');
                            const itemQty = it.quantity || it.qty || 1;
                            const itemRate = it.unit_price || it.rate || 0;
                            const itemTotal = it.line_total || (itemQty * itemRate);
                            itemsHtml += `
                                <div class="item-row">
                                    <div>
                                        <div class="item-name">${itemName}</div>
                                        <div class="item-meta">₹${itemRate} × ${itemQty}</div>
                                    </div>
                                    <div style="font-weight: 800; color: #0f172a;">₹${Number(itemTotal).toLocaleString('en-IN')}</div>
                                </div>
                            `;
                        });
                        itemsHtml += `</div>`;
                    }

                    const waText = encodeURIComponent(`Hi Guru Crackers, regarding my order #${order.order_number}: `);

                    html += `
                        <div class="track-order-card">
                            <div class="track-order-header">
                                <div>
                                    <div class="track-order-num">
                                        <span>#${order.order_number}</span>
                                        <span class="track-copy-chip" onclick="copyToClipboard('${order.order_number}', this)">Copy</span>
                                    </div>
                                    <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px;">
                                        <i class="fa-regular fa-calendar"></i> Booked on ${order.created_at ? new Date(order.created_at).toLocaleDateString('en-IN', {day: 'numeric', month: 'short', year: 'numeric'}) : 'Recent'}
                                    </div>
                                </div>
                                <span class="track-status-pill ${statusClass}">
                                    <i class="fa-solid ${statusIcon}"></i> ${statusLabel}
                                </span>
                            </div>

                            <div class="track-timeline-wrap">
                                <div class="track-steps-bar">
                                    <div class="track-step-node ${step1 ? 'completed' : ''}">
                                        <div class="track-step-circle"><i class="fa-solid fa-check"></i></div>
                                        <div class="track-step-label">Placed</div>
                                    </div>
                                    <div class="track-step-node ${step2 ? (step3 ? 'completed' : 'active') : ''}">
                                        <div class="track-step-circle"><i class="fa-solid ${step2 && !step3 ? 'fa-indian-rupee-sign' : 'fa-check'}"></i></div>
                                        <div class="track-step-label">Confirmed</div>
                                    </div>
                                    <div class="track-step-node ${step3 ? (step4 ? 'completed' : 'active') : ''}">
                                        <div class="track-step-circle"><i class="fa-solid ${step3 && !step4 ? 'fa-boxes-packing' : 'fa-check'}"></i></div>
                                        <div class="track-step-label">Packed</div>
                                    </div>
                                    <div class="track-step-node ${step4 ? 'completed active' : ''}">
                                        <div class="track-step-circle"><i class="fa-solid fa-truck-fast"></i></div>
                                        <div class="track-step-label">Dispatched</div>
                                    </div>
                                </div>
                            </div>

                            ${transportHtml}

                            <div class="track-details-grid">
                                <div class="track-detail-row">
                                    <span class="track-detail-label">Customer:</span>
                                    <span class="track-detail-value">${customerName}</span>
                                </div>
                                <div class="track-detail-row">
                                    <span class="track-detail-label">Contact:</span>
                                    <span class="track-detail-value">${customerPhone}</span>
                                </div>
                                <div class="track-detail-row">
                                    <span class="track-detail-label">Delivery Hub:</span>
                                    <span class="track-detail-value">${deliveryDisplay}</span>
                                </div>
                                <div class="track-detail-row">
                                    <span class="track-detail-label">Payment:</span>
                                    <span class="track-detail-value">${paymentBadgeHtml}</span>
                                </div>
                                <div class="track-detail-row" style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #f1f5f9;">
                                    <span class="track-detail-label" style="font-weight: 800; font-size: 0.90rem; color: #0f172a;">Total Payable:</span>
                                    <span class="track-detail-value" style="font-size: 1.05rem; font-weight: 800; color: #be123c;">₹${Number(order.total_amount || 0).toLocaleString('en-IN')}</span>
                                </div>
                            </div>

                            ${itemsHtml}

                            <div class="order-actions-bar">
                                <button type="button" onclick="openInvoiceModal(${index})" class="btn-action btn-action-primary" style="flex: 1.2;">
                                    <i class="fa-solid fa-file-lines"></i> View Invoice
                                </button>
                                <button type="button" onclick="downloadOrderPdfByIndex(${index}, this)" class="btn-action btn-action-outline">
                                    <i class="fa-solid fa-file-arrow-down"></i> Download
                                </button>
                                <a href="https://wa.me/91{{ $shop['phone'] ?? '9789874381' }}?text=${waText}" target="_blank" class="btn-action btn-action-whatsapp">
                                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;
            } else {
                container.innerHTML = `
                    <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 20px; margin: 0 14px; border: 1px solid #e2e8f0;">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px auto; font-size: 24px;">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </div>
                        <h3 style="font-size: 1rem; font-weight: 800; color: #0f172a;">No Orders Found</h3>
                        <p style="font-size: 0.80rem; color: #64748b; margin-top: 4px;">
                            No matching bookings found for "${query}". Please check the phone number or Order ID.
                        </p>
                    </div>
                `;
            }
        } catch (err) {
            console.error('Tracking failed:', err);
            container.innerHTML = `
                <div style="text-align: center; padding: 30px 20px; color: #dc2626; background: white; border-radius: 20px; margin: 0 14px;">
                    <i class="fa-solid fa-wifi" style="font-size: 30px; margin-bottom: 8px; color: #cbd5e1;"></i>
                    <p style="font-weight: 700;">Connection Error</p>
                    <p style="font-size: 0.78rem; color: #64748b;">Could not reach store server. Please check your internet.</p>
                </div>
            `;
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Search & Track Order';
            if (window.hidePageLoader) window.hidePageLoader();
        }
    }

    // =========================================================================
    // IN-APP INVOICE VIEW & INSTANT CLIENT-SIDE PDF DOWNLOAD SYSTEM
    // =========================================================================
    let currentTrackedOrders = [];
    let activeInvoiceOrder = null;

    function numberToIndianWords(num) {
        if (!num || isNaN(num)) return '';
        const a = ['', 'One ', 'Two ', 'Three ', 'Four ', 'Five ', 'Six ', 'Seven ', 'Eight ', 'Nine ', 'Ten ', 'Eleven ', 'Twelve ', 'Thirteen ', 'Fourteen ', 'Fifteen ', 'Sixteen ', 'Seventeen ', 'Eighteen ', 'Nineteen '];
        const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        num = Math.round(Number(num));
        if (num === 0) return 'Zero Rupees Only';

        function inWords(n) {
            if (n < 20) return a[n];
            const digit = n % 10;
            return b[Math.floor(n / 10)] + (digit ? ' ' + a[digit] : ' ');
        }

        let str = '';
        const crore = Math.floor(num / 10000000);
        num %= 10000000;
        const lakh = Math.floor(num / 100000);
        num %= 100000;
        const thousand = Math.floor(num / 1000);
        num %= 1000;
        const hundred = Math.floor(num / 100);
        num %= 100;

        if (crore > 0) str += inWords(crore) + 'Crore ';
        if (lakh > 0) str += inWords(lakh) + 'Lakh ';
        if (thousand > 0) str += inWords(thousand) + 'Thousand ';
        if (hundred > 0) str += inWords(hundred) + 'Hundred ';
        if (num > 0) {
            if (str !== '') str += 'and ';
            str += inWords(num);
        }

        return 'Rupees ' + str.trim() + ' Only';
    }

    function renderInvoiceContent(order) {
        if (!order) return '';
        activeInvoiceOrder = order;

        const paymentStatus = (order.payment_status || '').toLowerCase();
        const orderStatus = (order.status || 'pending').toLowerCase();
        const isPaid = paymentStatus === 'paid';
        const isDispatched = orderStatus === 'dispatched' || !!order.lr_number || !!order.parcel_service_name;

        let statusBadgeText = 'Order Placed';
        let statusBadgeBg = '#fef3c7';
        let statusBadgeColor = '#b45309';

        if (isDispatched) {
            statusBadgeText = 'Dispatched & In Transit';
            statusBadgeBg = '#f3e8ff';
            statusBadgeColor = '#7e22ce';
        } else if (orderStatus === 'packed') {
            statusBadgeText = 'Packed & Ready';
            statusBadgeBg = '#f3e8ff';
            statusBadgeColor = '#7e22ce';
        } else if (orderStatus === 'confirmed') {
            statusBadgeText = 'Paid & Confirmed';
            statusBadgeBg = '#dcfce7';
            statusBadgeColor = '#15803d';
        }

        const customerName = order.name || order.customer_name || 'Valued Customer';
        const rawPhone = order.phone1 || order.phone || order.customer_phone || '';
        const customerPhone = rawPhone ? `+91 ${rawPhone}` : 'Registered Contact';
        const deliveryCity = order.city || 'Tamil Nadu';
        const deliveryAddress = order.delivery_address || `Transport Hub, ${order.destination_hub || deliveryCity}`;

        // Item rows
        let itemRows = '';
        let subtotal = 0;
        if (order.items && order.items.length > 0) {
            order.items.forEach((it, idx) => {
                const name = it.product_name || (it.product ? it.product.name : 'Cracker Item');
                const qty = it.quantity || it.qty || 1;
                const rate = Number(it.unit_price || it.rate || 0);
                const total = Number(it.line_total || (qty * rate));
                subtotal += total;

                itemRows += `
                    <tr>
                        <td class="text-center" style="width: 28px; color: #64748b;">${idx + 1}</td>
                        <td>
                            <div class="inv-item-name">${name}</div>
                        </td>
                        <td class="text-center" style="font-weight: 700; width: 44px;">${qty}</td>
                        <td style="text-align: right; width: 64px;">₹${rate.toFixed(2)}</td>
                        <td style="text-align: right; font-weight: 800; width: 78px;">₹${total.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    </tr>
                `;
            });
        }

        const totalAmount = Number(order.total_amount || subtotal || 0);
        const amountInWords = numberToIndianWords(totalAmount);

        let transportSection = '';
        if (order.parcel_service_name || order.lr_number || isDispatched) {
            transportSection = `
                <div class="inv-transport-box">
                    <div class="inv-transport-title">
                        <i class="fa-solid fa-truck-fast"></i> Transport & LR Parcel Booking
                    </div>
                    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 8px;">
                        <div><strong>Service:</strong> ${order.parcel_service_name || 'A1 / MSS Transport'}</div>
                        ${order.lr_number ? `<div><strong>LR Slip No:</strong> <span style="font-family: monospace; font-weight: 900; color: #581c87;">${order.lr_number}</span></div>` : ''}
                        ${order.dispatch_date ? `<div><strong>Date:</strong> ${order.dispatch_date}</div>` : ''}
                        <div><strong>Delivery Hub:</strong> ${order.destination_hub || deliveryCity}</div>
                    </div>
                </div>
            `;
        }

        return `
            <div class="inv-header">
                <div class="inv-brand-left">
                    <div class="inv-brand-title">
                        <i class="fa-solid fa-fire-flame-curved"></i> GURU CRACKERS
                    </div>
                    <div class="inv-brand-tagline">Sivakasi Standard Fireworks & Sparklers</div>
                    <div class="inv-brand-meta">
                        124, Sivakasi Main Road, Sivakasi - 626123<br>
                        Phone: +91 {{ $shop['phone'] ?? '9789874381' }} | WhatsApp Support<br>
                        Email: {{ $shop['email'] ?? 'gurucrackerssivakasi@gmail.com' }}
                    </div>
                </div>
                <div class="inv-badge-wrap">
                    <div class="inv-doc-type">Tax Invoice</div>
                    <span class="inv-status-chip" style="background: ${statusBadgeBg}; color: ${statusBadgeColor};">
                        ${statusBadgeText}
                    </span>
                </div>
            </div>

            <div class="inv-grid-2">
                <div>
                    <div class="inv-box-title">Billed & Shipped To:</div>
                    <div class="inv-box-name">${customerName}</div>
                    <div class="inv-box-detail">
                        <i class="fa-solid fa-phone" style="font-size: 10px; color: #dc2626;"></i> ${customerPhone}<br>
                        <i class="fa-solid fa-location-dot" style="font-size: 10px; color: #dc2626;"></i> ${deliveryAddress}<br>
                        ${order.state || 'Tamil Nadu'} - ${order.pincode || ''}
                    </div>
                </div>
                <div>
                    <div class="inv-box-title">Invoice Details:</div>
                    <div class="inv-box-detail">
                        <strong>Invoice No:</strong> <span style="color: #dc2626; font-weight: 800;">#${order.order_number}</span><br>
                        <strong>Order Date:</strong> ${order.created_at || 'Recent'}<br>
                        <strong>Payment Mode:</strong> ${isPaid ? 'Paid Online / UPI (Verified)' : 'Pending Verification'}<br>
                        <strong>Delivery Mode:</strong> Transport Hub Parcel
                    </div>
                </div>
            </div>

            ${transportSection}

            <table class="inv-table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Cracker Description</th>
                        <th class="text-center">Qty</th>
                        <th style="text-align: right;">Rate</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${itemRows}
                </tbody>
            </table>

            <div class="inv-summary-wrap">
                <div class="inv-words-box">
                    <div class="inv-words-title">Amount in Words:</div>
                    <div class="inv-words-text">${amountInWords}</div>
                </div>
                <div class="inv-totals-box">
                    <div class="inv-total-row">
                        <span>Items Total:</span>
                        <span>₹${Number(subtotal || totalAmount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                    </div>
                    <div class="inv-total-row">
                        <span>Packing & Forwarding:</span>
                        <span style="color: #16a34a; font-weight: 700;">FREE</span>
                    </div>
                    <div class="inv-total-row grand-total">
                        <span>Grand Total:</span>
                        <span>₹${Number(totalAmount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                    </div>
                </div>
            </div>

            <div class="inv-bottom-section">
                <div class="inv-terms">
                    <strong>Terms & Safety Notes:</strong><br>
                    1. Burst crackers under adult supervision in open ground.<br>
                    2. Keep parcel away from heat & fire; store in a dry place.<br>
                    3. Collect transport parcel from nearest hub by showing this bill.<br>
                    4. Computer generated bill for transport transit from Sivakasi.
                </div>
                <div class="inv-signature-box">
                    <div class="inv-seal">GURU CRACKERS</div>
                    <div class="inv-sign-label">Authorized Signatory</div>
                </div>
            </div>
        `;
    }

    function openInvoiceModal(index) {
        const order = currentTrackedOrders[index];
        if (!order) return;

        const printableArea = document.getElementById('invoicePrintableArea');
        if (!printableArea) return;

        printableArea.innerHTML = renderInvoiceContent(order);

        const titleEl = document.getElementById('invoiceModalTitle');
        if (titleEl) titleEl.textContent = `Invoice #${order.order_number}`;

        const modal = document.getElementById('invoiceModal');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeInvoiceModal() {
        const modal = document.getElementById('invoiceModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function handleInvoiceOverlayClick(event) {
        if (event.target && event.target.id === 'invoiceModal') {
            closeInvoiceModal();
        }
    }

    async function downloadOrderPdfByIndex(index, btn) {
        const order = currentTrackedOrders[index];
        if (!order) return;

        // Render invoice content into the printable container first
        const printableArea = document.getElementById('invoicePrintableArea');
        if (printableArea) {
            printableArea.innerHTML = renderInvoiceContent(order);
        }

        let origHtml = '';
        if (btn) {
            origHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Downloading...';
        }

        try {
            await executePdfDownload(order);
        } catch (err) {
            console.error('Download error:', err);
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = origHtml;
            }
        }
    }

    async function downloadCurrentInvoicePdf() {
        if (!activeInvoiceOrder) return;
        const btn = document.getElementById('modalDownloadBtn');
        const btnText = document.getElementById('modalDownloadBtnText');
        let origText = 'Download PDF';

        if (btnText) {
            origText = btnText.textContent;
            btnText.textContent = 'Generating PDF...';
        }
        if (btn) btn.disabled = true;

        try {
            await executePdfDownload(activeInvoiceOrder);
        } catch (err) {
            console.error('Download error:', err);
        } finally {
            if (btnText) btnText.textContent = origText;
            if (btn) btn.disabled = false;
        }
    }

    async function executePdfDownload(order) {
        const orderNum = order.order_number || 'GC-Invoice';
        const printableArea = document.getElementById('invoicePrintableArea');

        if (typeof html2pdf !== 'undefined' && printableArea) {
            const opt = {
                margin:       [6, 6, 6, 6],
                filename:     `GuruCrackers_Invoice_${orderNum}.pdf`,
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true, logging: false },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            if (window.showToast) window.showToast('⚡ Generating PDF instantly...', 'info', 1500);

            try {
                await html2pdf().set(opt).from(printableArea).save();
                if (window.showToast) window.showToast('✅ Invoice downloaded successfully!', 'success');
                return;
            } catch (pdfErr) {
                console.warn('html2pdf generation error, falling back to direct download:', pdfErr);
            }
        }

        // Direct fallback if html2pdf is unavailable
        const backendUrl = "{{ $backendUrl ?? 'https://gurucrackers.onrender.com' }}";
        const fallbackUrl = order.download_pdf_url || `${backendUrl}/order/invoice/${orderNum}/download`;
        const tempLink = document.createElement('a');
        tempLink.href = fallbackUrl;
        tempLink.target = '_blank';
        tempLink.download = `GuruCrackers_Invoice_${orderNum}.pdf`;
        document.body.appendChild(tempLink);
        tempLink.click();
        document.body.removeChild(tempLink);
        if (window.showToast) window.showToast('Invoice download started', 'success');
    }

    function shareCurrentInvoiceWhatsApp() {
        if (!activeInvoiceOrder) return;
        const o = activeInvoiceOrder;
        const backendUrl = "{{ $backendUrl ?? 'https://gurucrackers.onrender.com' }}";
        const invoiceUrl = o.invoice_url || `${backendUrl}/order/invoice/${o.order_number}`;
        const msg = `🧾 *Guru Crackers Tax Invoice*\nOrder No: *#${o.order_number}*\nCustomer: ${o.name || o.customer_name || 'Customer'}\nTotal: *₹${Number(o.total_amount).toLocaleString('en-IN')}*\nStatus: ${o.payment_status || o.status || 'Booked'}\nView Bill: ${invoiceUrl}`;
        window.open(`https://wa.me/?text=${encodeURIComponent(msg)}`, '_blank');
    }

    function printInvoice() {
        window.print();
    }

    // Hash and PopState Listener for Instant Tab Navigation & Android Back Button
    window.addEventListener('popstate', function(e) {
        // If invoice modal is open, back button closes it
        const invoiceModal = document.getElementById('invoiceModal');
        if (invoiceModal && invoiceModal.classList.contains('active')) {
            closeInvoiceModal();
            return;
        }

        const hash = window.location.hash.replace('#', '') || 'catalog';
        window.switchTab(hash, false);
    });

    // =========================================================================
    // PULL TO REFRESH & MANUAL CATALOG REFRESH ENGINE
    // =========================================================================
    let isRefreshingCatalog = false;

    async function triggerManualRefresh() {
        if (isRefreshingCatalog) return;
        isRefreshingCatalog = true;

        const btnIcon = document.getElementById('refreshBtnIcon');
        if (btnIcon) btnIcon.classList.add('fa-spin');

        const ptrEl = document.getElementById('pullToRefresh');
        const ptrIcon = document.getElementById('ptrIcon');
        const ptrIconWrap = document.getElementById('ptrIconWrap');
        const ptrMsg = document.getElementById('ptrMsg');

        if (ptrEl) {
            ptrEl.classList.add('visible', 'refreshing');
            ptrEl.style.height = '54px';
            if (ptrIcon) ptrIcon.className = 'fa-solid fa-rotate-right fa-spin';
            if (ptrIconWrap) ptrIconWrap.style.transform = 'none';
            if (ptrMsg) ptrMsg.textContent = 'Refreshing catalog...';
        }

        try {
            const apiBase = "{{ $backendUrl ?? 'https://gurucrackers.onrender.com' }}";
            const res = await fetch(apiBase + '/api/v1/catalog?_t=' + Date.now(), {
                headers: { 'Accept': 'application/json' },
                cache: 'no-store'
            });
            const data = await res.json();

            if (data.success && data.categories && data.categories.length > 0) {
                renderCategoriesAndProducts(data.categories);
                renderCartUI();
                if (window.showToast) window.showToast('✨ Catalog refreshed successfully!', 'success', 2000);
            } else {
                window.location.reload();
                return;
            }
        } catch (err) {
            console.warn('Manual refresh error, reloading page:', err);
            window.location.reload();
            return;
        } finally {
            setTimeout(() => {
                if (ptrEl) {
                    ptrEl.style.height = '0px';
                    ptrEl.classList.remove('refreshing', 'visible');
                    setTimeout(() => {
                        if (ptrIcon) ptrIcon.className = 'fa-solid fa-arrow-down';
                        if (ptrMsg) ptrMsg.textContent = 'Pull down to refresh';
                    }, 250);
                }
                if (btnIcon) btnIcon.classList.remove('fa-spin');
                isRefreshingCatalog = false;
            }, 500);
        }
    }

    function initPullToRefresh() {
        let touchStartY = 0;
        let touchCurrentY = 0;
        let isTrackingTouch = false;
        let pullDistance = 0;
        const maxPull = 85;
        const triggerThreshold = 60;

        const ptrEl = document.getElementById('pullToRefresh');
        const ptrIcon = document.getElementById('ptrIcon');
        const ptrIconWrap = document.getElementById('ptrIconWrap');
        const ptrMsg = document.getElementById('ptrMsg');

        window.addEventListener('touchstart', function(e) {
            if (isRefreshingCatalog) return;
            const catalogView = document.getElementById('view-catalog');
            if (!catalogView || !catalogView.classList.contains('active')) return;

            // Check if page is at the very top
            const scrollTop = window.scrollY || document.documentElement.scrollTop || 0;
            if (scrollTop <= 1) {
                touchStartY = e.touches[0].clientY;
                isTrackingTouch = true;
                pullDistance = 0;
            }
        }, { passive: true });

        window.addEventListener('touchmove', function(e) {
            if (!isTrackingTouch || isRefreshingCatalog) return;

            const scrollTop = window.scrollY || document.documentElement.scrollTop || 0;
            if (scrollTop > 1) {
                isTrackingTouch = false;
                if (ptrEl && !ptrEl.classList.contains('refreshing')) {
                    ptrEl.style.height = '0px';
                    ptrEl.classList.remove('visible');
                }
                return;
            }

            touchCurrentY = e.touches[0].clientY;
            const diffY = touchCurrentY - touchStartY;

            if (diffY > 0) {
                // Apply rubber-band drag resistance
                pullDistance = Math.min(diffY * 0.45, maxPull);

                if (ptrEl) {
                    ptrEl.classList.add('visible');
                    ptrEl.style.height = pullDistance + 'px';

                    if (pullDistance >= triggerThreshold) {
                        if (ptrIcon) ptrIcon.className = 'fa-solid fa-arrow-up';
                        if (ptrIconWrap) ptrIconWrap.style.transform = 'rotate(180deg)';
                        if (ptrMsg) ptrMsg.textContent = 'Release to refresh';
                    } else {
                        if (ptrIcon) ptrIcon.className = 'fa-solid fa-arrow-down';
                        if (ptrIconWrap) ptrIconWrap.style.transform = 'rotate(' + (pullDistance * 2.5) + 'deg)';
                        if (ptrMsg) ptrMsg.textContent = 'Pull down to refresh';
                    }
                }
            }
        }, { passive: true });

        window.addEventListener('touchend', function() {
            if (!isTrackingTouch) return;
            isTrackingTouch = false;

            if (pullDistance >= triggerThreshold && !isRefreshingCatalog) {
                triggerManualRefresh();
            } else if (ptrEl && !isRefreshingCatalog) {
                ptrEl.style.height = '0px';
                ptrEl.classList.remove('visible');
                if (ptrIcon) ptrIcon.className = 'fa-solid fa-arrow-down';
                if (ptrIconWrap) ptrIconWrap.style.transform = 'none';
                if (ptrMsg) ptrMsg.textContent = 'Pull down to refresh';
            }
            pullDistance = 0;
        }, { passive: true });
    }

    // Initialize UI on load
    document.addEventListener('DOMContentLoaded', () => {
        renderCartUI();
        checkAndLoadLiveCatalog();
        initPullToRefresh();

        // Check if opened with #cart or #track hash
        const initialHash = window.location.hash.replace('#', '');
        if (initialHash === 'cart' || initialHash === 'track') {
            window.switchTab(initialHash, false);
        }

        // Auto-handle query parameter from URL (e.g., ?query=GC-20260922-JLUGB)
        const urlParams = new URLSearchParams(window.location.search);
        const queryParam = urlParams.get('query');
        if (queryParam) {
            window.switchTab('track', false);
            const input = document.getElementById('trackQuery');
            if (input) {
                input.value = queryParam;
                if (/^[0-9]{10}$/.test(queryParam)) {
                    switchTrackTab('mobile');
                } else {
                    switchTrackTab('order');
                }
                const clearBtn = document.getElementById('trackClearBtn');
                if (clearBtn) clearBtn.style.display = 'flex';
                handleTrack();
            }
        }
    });
</script>
@endpush
