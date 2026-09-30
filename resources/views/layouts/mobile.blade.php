<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>@yield('title', 'Guru Crackers - Sivakasi')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#b91c1c">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Mukta+Malar:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome / Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Fast Client-side PDF Generator -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        :root {
            --primary: #dc2626;
            --primary-dark: #991b1b;
            --accent: #f59e0b;
            --accent-gold: #fbbf24;
            --bg-body: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
            --success: #16a34a;
            --safe-bottom: env(safe-area-inset-bottom, 16px);
            --safe-top: env(safe-area-inset-top, 16px);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            padding-bottom: calc(75px + var(--safe-bottom));
            min-height: 100vh;
            overflow-x: hidden;
            user-select: none;
        }

        .tamil-text {
            font-family: 'Mukta Malar', sans-serif;
        }

        /* Top App Bar */
        .app-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: linear-gradient(135deg, #b91c1c 0%, #881337 50%, #7f1d1d 100%);
            color: white;
            padding: calc(var(--safe-top) + 6px) 14px 10px 14px;
            box-shadow: 0 4px 20px rgba(185, 28, 28, 0.28);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #b91c1c;
            font-size: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.18);
            overflow: hidden;
            flex-shrink: 0;
            border: 2px solid rgba(255, 255, 255, 0.9);
        }

        .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-title {
            font-size: 1.18rem;
            font-weight: 800;
            letter-spacing: -0.3px;
            line-height: 1.2;
            text-shadow: 0 1px 2px rgba(0,0,0,0.15);
        }

        .brand-subtitle {
            font-size: 0.72rem;
            color: #fef08a;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 1px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 15px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .header-btn:active {
            transform: scale(0.90);
            background: rgba(255, 255, 255, 0.35);
        }

        /* Bottom Navigation Bar */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid rgba(226, 232, 240, 0.9);
            display: flex;
            justify-content: space-around;
            padding: 8px 12px calc(8px + var(--safe-bottom)) 12px;
            box-shadow: 0 -6px 25px rgba(0, 0, 0, 0.08);
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 700;
            gap: 3px;
            position: relative;
            padding: 4px 14px;
            border-radius: 12px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-item i {
            font-size: 19px;
            transition: all 0.2s;
        }

        .nav-item.active {
            color: var(--primary);
        }

        .nav-item.active i {
            transform: scale(1.15) translateY(-2px);
            color: var(--primary);
        }

        .nav-badge {
            position: absolute;
            top: 0px;
            right: 8px;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            min-width: 19px;
            height: 19px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 2px solid white;
            box-shadow: 0 2px 6px rgba(220, 38, 38, 0.35);
            animation: pulseBadge 1.5s infinite;
        }

        @keyframes pulseBadge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Container helper */
        .page-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 10px 14px;
        }

        /* Tap active feedback */
        button, a, .clickable {
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        /* Top Loading Progress Bar */
        .page-top-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3.5px;
            width: 0%;
            background: linear-gradient(90deg, #fbbf24 0%, #dc2626 50%, #f59e0b 100%);
            z-index: 9999;
            transition: width 0.3s ease, opacity 0.3s ease;
            opacity: 0;
            box-shadow: 0 0 10px rgba(245, 158, 11, 0.7);
        }
        .page-top-progress.active {
            opacity: 1;
            width: 75%;
        }
        .page-top-progress.done {
            width: 100%;
            opacity: 0;
        }

        /* Global Fullscreen Page Transition Loader */
        .global-page-loader {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.78);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 9998;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }
        .global-page-loader.active {
            opacity: 1;
            visibility: visible;
        }
        .loader-card {
            background: white;
            border-radius: 24px;
            padding: 24px 28px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
            max-width: 260px;
            text-align: center;
            animation: loaderPop 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes loaderPop {
            0% { transform: scale(0.85); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .loader-logo-wrap {
            position: relative;
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .loader-logo-wrap img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            border-radius: 14px;
        }
        .loader-spinner-ring {
            position: absolute;
            inset: -4px;
            border: 3.5px solid transparent;
            border-top-color: #dc2626;
            border-right-color: #f59e0b;
            border-radius: 50%;
            animation: spinRing 0.8s linear infinite;
        }
        @keyframes spinRing {
            to { transform: rotate(360deg); }
        }
        .loader-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: #0f172a;
        }
        .loader-sub {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
        }

        /* ============================================================== */
        /* CUSTOM APP MODAL & TOAST NOTIFICATION SYSTEM */
        /* ============================================================== */
        .app-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .app-modal-overlay.active {
            display: flex;
            opacity: 1;
        }
        .app-modal-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 26px 22px;
            width: 100%;
            max-width: 330px;
            text-align: center;
            box-shadow: 0 24px 50px rgba(0, 0, 0, 0.28);
            transform: scale(0.9);
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1.5px solid rgba(226, 232, 240, 0.85);
        }
        .app-modal-overlay.active .app-modal-card {
            transform: scale(1);
        }
        .app-modal-icon {
            width: 66px;
            height: 66px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px auto;
            font-size: 28px;
        }
        .app-modal-icon.danger {
            background: #fee2e2;
            color: #dc2626;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.2);
        }
        .app-modal-icon.warning {
            background: #fef3c7;
            color: #d97706;
            box-shadow: 0 4px 14px rgba(217, 119, 6, 0.2);
        }
        .app-modal-icon.success {
            background: #dcfce7;
            color: #16a34a;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.2);
        }
        .app-modal-icon.info {
            background: #e0f2fe;
            color: #0284c7;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.2);
        }
        .app-modal-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
            line-height: 1.25;
        }
        .app-modal-msg {
            font-size: 0.86rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 22px;
        }
        .app-modal-actions {
            display: flex;
            gap: 10px;
        }
        .app-modal-btn {
            flex: 1;
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 0.88rem;
            font-weight: 800;
            border: none;
            cursor: pointer;
            transition: transform 0.15s, opacity 0.15s;
        }
        .app-modal-btn:active {
            transform: scale(0.96);
        }
        .app-modal-btn-cancel {
            background: #f1f5f9;
            color: #475569;
        }
        .app-modal-btn-confirm.danger {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
        }
        .app-modal-btn-confirm.primary {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
        }
        .app-modal-btn-confirm.success {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.35);
        }

        /* Floating Toast - Bottom Positioned above Navigation or View Cart bar */
        .app-toast-wrap {
            position: fixed;
            bottom: calc(76px + var(--safe-bottom));
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            z-index: 100000;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.22s ease, transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), bottom 0.22s ease;
            max-width: calc(100% - 28px);
            width: max-content;
        }
        .app-toast-wrap.active {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        .app-toast-wrap.above-cart-bar {
            bottom: calc(136px + var(--safe-bottom));
        }
        .app-toast-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #0f172a;
            color: #ffffff;
            padding: 11px 20px;
            border-radius: 50px;
            font-size: 0.84rem;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .app-toast-box.success {
            border-left: 4px solid #22c55e;
        }
        .app-toast-box.error {
            border-left: 4px solid #ef4444;
        }
        .app-toast-box.warning {
            border-left: 4px solid #f59e0b;
        }
        .app-toast-box.info {
            border-left: 4px solid #38bdf8;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Top Loading Progress Bar -->
    <div id="pageTopProgress" class="page-top-progress"></div>

    <!-- Custom App Alert & Confirm Modal -->
    <div id="appModalOverlay" class="app-modal-overlay">
        <div class="app-modal-card">
            <div id="appModalIcon" class="app-modal-icon danger">
                <i id="appModalIconI" class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 id="appModalTitle" class="app-modal-title">Confirm Action</h3>
            <p id="appModalMsg" class="app-modal-msg">Are you sure you want to proceed?</p>
            <div id="appModalActions" class="app-modal-actions">
                <button type="button" id="appModalCancelBtn" class="app-modal-btn app-modal-btn-cancel">Cancel</button>
                <button type="button" id="appModalConfirmBtn" class="app-modal-btn app-modal-btn-confirm danger">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Custom Floating Toast -->
    <div id="appToast" class="app-toast-wrap">
        <div id="appToastBox" class="app-toast-box success">
            <i id="appToastIcon" class="fa-solid fa-circle-check" style="color: #22c55e;"></i>
            <span id="appToastText">Success notification</span>
        </div>
    </div>

    <!-- Global Page Navigation Loader -->
    <div id="globalPageLoader" class="global-page-loader" aria-hidden="true">
        <div class="loader-card">
            <div class="loader-logo-wrap">
                <div class="loader-spinner-ring"></div>
                <img src="{{ asset('images/logo.png') }}" alt="Guru Crackers Logo" onerror="this.src='{{ $shop['logo_url'] ?? '' }}'">
            </div>
            <div>
                <div id="globalLoaderText" class="loader-title">Connecting to Store...</div>
                <div id="globalLoaderSub" class="loader-sub">Sivakasi Direct Orders</div>
            </div>
        </div>
    </div>

    @yield('content')

    <!-- Sticky Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="javascript:void(0)" onclick="handleNavClick('catalog')" id="nav-item-catalog" class="nav-item active">
            <i class="fa-solid fa-fire-flame-curved"></i>
            <span>Catalog</span>
        </a>
        <a href="javascript:void(0)" onclick="handleNavClick('cart')" id="nav-item-cart" class="nav-item">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Cart</span>
            <span class="nav-badge" id="nav-cart-badge" style="display: none;">0</span>
        </a>
        <a href="javascript:void(0)" onclick="handleNavClick('track')" id="nav-item-track" class="nav-item">
            <i class="fa-solid fa-truck-fast"></i>
            <span>Track</span>
        </a>
        <a href="https://wa.me/91{{ $shop['phone'] ?? '9789874381' }}?text=Hi%20Guru%20Crackers,%20I%20have%20an%20inquiry" target="_blank" class="nav-item">
            <i class="fa-brands fa-whatsapp text-success" style="color: #22c55e;"></i>
            <span>WhatsApp</span>
        </a>
    </nav>

    <script>
        function handleNavClick(tab) {
            if (typeof window.switchTab === 'function') {
                window.switchTab(tab);
            } else {
                window.location.href = "{{ route('mobile.home') }}#" + tab;
            }
        }
        window.openCartDrawer = function() {
            handleNavClick('cart');
        };

        // Global Page Navigation Loader Functions
        window.showPageLoader = function(title = 'Loading...', sub = 'Please wait a moment') {
            const bar = document.getElementById('pageTopProgress');
            const loader = document.getElementById('globalPageLoader');
            const titleEl = document.getElementById('globalLoaderText');
            const subEl = document.getElementById('globalLoaderSub');
            if (titleEl && title) titleEl.textContent = title;
            if (subEl && sub) subEl.textContent = sub;
            if (bar) {
                bar.classList.remove('done');
                bar.classList.add('active');
            }
            if (loader) {
                loader.classList.add('active');
            }
        };

        window.hidePageLoader = function() {
            const bar = document.getElementById('pageTopProgress');
            const loader = document.getElementById('globalPageLoader');
            if (bar) {
                bar.classList.add('done');
                setTimeout(() => {
                    bar.classList.remove('active', 'done');
                }, 300);
            }
            if (loader) {
                loader.classList.remove('active');
            }
        };

        // Automatically show loader when clicking internal links
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;
            const href = link.getAttribute('href');
            if (!href || href === '#' || href.startsWith('javascript:') || href.startsWith('tel:') || href.startsWith('mailto:') || href.startsWith('whatsapp:') || href.includes('wa.me') || link.target === '_blank') {
                return;
            }
            // If navigating to another internal page
            window.showPageLoader('Opening Page...', 'Guru Crackers, Sivakasi');
        });

        // Hide loader when page finishes loading or restored from cache
        window.addEventListener('pageshow', function() {
            window.hidePageLoader();
        });
        // ==============================================================
        // CUSTOM APP MODAL, CONFIRM & TOAST SYSTEM
        // ==============================================================
        let appModalResolver = null;

        window.showAppConfirm = function({
            title = 'Confirm',
            message = 'Are you sure?',
            icon = 'fa-solid fa-triangle-exclamation',
            type = 'danger',
            confirmText = 'Confirm',
            cancelText = 'Cancel'
        }) {
            return new Promise((resolve) => {
                appModalResolver = resolve;
                const overlay = document.getElementById('appModalOverlay');
                const titleEl = document.getElementById('appModalTitle');
                const msgEl = document.getElementById('appModalMsg');
                const iconBox = document.getElementById('appModalIcon');
                const iconI = document.getElementById('appModalIconI');
                const cancelBtn = document.getElementById('appModalCancelBtn');
                const confirmBtn = document.getElementById('appModalConfirmBtn');

                if (titleEl) titleEl.textContent = title;
                if (msgEl) msgEl.textContent = message;
                if (iconBox) iconBox.className = 'app-modal-icon ' + type;
                if (iconI) iconI.className = icon;
                if (cancelBtn) {
                    cancelBtn.style.display = 'block';
                    cancelBtn.textContent = cancelText;
                }
                if (confirmBtn) {
                    confirmBtn.className = 'app-modal-btn app-modal-btn-confirm ' + type;
                    confirmBtn.textContent = confirmText;
                }
                if (overlay) overlay.classList.add('active');
            });
        };

        window.showAppAlert = function({
            title = 'Notice',
            message = '',
            icon = 'fa-solid fa-circle-info',
            type = 'info',
            btnText = 'OK'
        }) {
            return new Promise((resolve) => {
                appModalResolver = resolve;
                const overlay = document.getElementById('appModalOverlay');
                const titleEl = document.getElementById('appModalTitle');
                const msgEl = document.getElementById('appModalMsg');
                const iconBox = document.getElementById('appModalIcon');
                const iconI = document.getElementById('appModalIconI');
                const cancelBtn = document.getElementById('appModalCancelBtn');
                const confirmBtn = document.getElementById('appModalConfirmBtn');

                if (titleEl) titleEl.textContent = title;
                if (msgEl) msgEl.textContent = message;
                if (iconBox) iconBox.className = 'app-modal-icon ' + type;
                if (iconI) iconI.className = icon;
                if (cancelBtn) cancelBtn.style.display = 'none';
                if (confirmBtn) {
                    confirmBtn.className = 'app-modal-btn app-modal-btn-confirm primary';
                    confirmBtn.textContent = btnText;
                }
                if (overlay) overlay.classList.add('active');
            });
        };

        document.getElementById('appModalCancelBtn')?.addEventListener('click', () => {
            document.getElementById('appModalOverlay')?.classList.remove('active');
            if (appModalResolver) {
                appModalResolver(false);
                appModalResolver = null;
            }
        });

        document.getElementById('appModalConfirmBtn')?.addEventListener('click', () => {
            document.getElementById('appModalOverlay')?.classList.remove('active');
            if (appModalResolver) {
                appModalResolver(true);
                appModalResolver = null;
            }
        });

        // Close on backdrop click (acts as cancel)
        document.getElementById('appModalOverlay')?.addEventListener('click', (e) => {
            if (e.target.id === 'appModalOverlay') {
                document.getElementById('appModalOverlay')?.classList.remove('active');
                if (appModalResolver) {
                    appModalResolver(false);
                    appModalResolver = null;
                }
            }
        });

        // Custom Toast Notification System
        let toastTimer = null;
        window.showToast = function(message, type = 'success', duration = 3000) {
            const toast = document.getElementById('appToast');
            const box = document.getElementById('appToastBox');
            const icon = document.getElementById('appToastIcon');
            const text = document.getElementById('appToastText');
            if (!toast || !box || !text) return;

            text.textContent = message;
            box.className = 'app-toast-box ' + type;

            const iconMap = {
                success: { cls: 'fa-solid fa-circle-check', color: '#22c55e' },
                error: { cls: 'fa-solid fa-circle-xmark', color: '#ef4444' },
                warning: { cls: 'fa-solid fa-triangle-exclamation', color: '#f59e0b' },
                info: { cls: 'fa-solid fa-circle-info', color: '#38bdf8' }
            };

            const cfg = iconMap[type] || iconMap.info;
            if (icon) {
                icon.className = cfg.cls;
                icon.style.color = cfg.color;
            }

            // Dynamically adjust position:
            // If in catalog and floating "View Cart" bar is visible, float ABOVE it
            const floatingCart = document.getElementById('floatingCart');
            const catalogView = document.getElementById('view-catalog');
            const isFloatingCartVisible = floatingCart && 
                floatingCart.style.display !== 'none' && 
                (!catalogView || catalogView.classList.contains('active'));

            if (isFloatingCartVisible) {
                toast.classList.add('above-cart-bar');
            } else {
                toast.classList.remove('above-cart-bar');
            }

            toast.classList.add('active');
            if (toastTimer) clearTimeout(toastTimer);
            toastTimer = setTimeout(() => {
                toast.classList.remove('active');
            }, duration);
        };

        // Override native window.alert with beautiful custom modal
        window.alert = function(msg) {
            window.showAppAlert({
                title: 'Guru Crackers',
                message: String(msg),
                type: 'info'
            });
        };
    </script>

    @stack('scripts')
</body>
</html>
