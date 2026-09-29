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
            background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);
            color: white;
            padding: calc(var(--safe-top) + 8px) 16px 12px 16px;
            box-shadow: 0 4px 20px rgba(185, 28, 28, 0.25);
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
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #78350f;
            font-size: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .brand-title {
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 0.72rem;
            opacity: 0.85;
            color: #fef08a;
            font-weight: 600;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }

        .header-btn:active {
            transform: scale(0.92);
            background: rgba(255, 255, 255, 0.3);
        }

        /* Bottom Navigation Bar */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid var(--border-light);
            display: flex;
            justify-content: space-around;
            padding: 8px 12px calc(8px + var(--safe-bottom)) 12px;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.06);
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.72rem;
            font-weight: 600;
            gap: 4px;
            position: relative;
            padding: 4px 12px;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .nav-item i {
            font-size: 18px;
            transition: all 0.2s;
        }

        .nav-item.active {
            color: var(--primary);
        }

        .nav-item.active i {
            transform: translateY(-2px);
        }

        .nav-badge {
            position: absolute;
            top: 2px;
            right: 8px;
            background: var(--primary);
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            min-width: 18px;
            height: 18px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 2px solid white;
        }

        /* Container helper */
        .page-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 12px 14px;
        }

        /* Tap active feedback */
        button, a, .clickable {
            cursor: pointer;
        }
    </style>

    @stack('styles')
</head>
<body>

    @yield('content')

    <!-- Sticky Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('mobile.home') }}" class="nav-item {{ request()->routeIs('mobile.home') ? 'active' : '' }}">
            <i class="fa-solid fa-fire-flame-curved"></i>
            <span>Catalog</span>
        </a>
        <a href="javascript:void(0)" onclick="openCartDrawer()" class="nav-item">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Cart</span>
            <span class="nav-badge" id="nav-cart-badge" style="display: none;">0</span>
        </a>
        <a href="{{ route('mobile.track') }}" class="nav-item {{ request()->routeIs('mobile.track') ? 'active' : '' }}">
            <i class="fa-solid fa-truck-fast"></i>
            <span>Track</span>
        </a>
        <a href="https://wa.me/919789874381?text=Hi%20Guru%20Crackers,%20I%20have%20an%20inquiry" target="_blank" class="nav-item">
            <i class="fa-brands fa-whatsapp text-success"></i>
            <span>WhatsApp</span>
        </a>
    </nav>

    @stack('scripts')
</body>
</html>
