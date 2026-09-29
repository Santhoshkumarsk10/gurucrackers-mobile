@extends('layouts.mobile')

@section('title', ($shop['name'] ?? 'Guru Crackers') . ' - Sivakasi Direct Orders')

@push('styles')
<style>
    /* Search Bar */
    .search-box-wrap {
        margin: 12px 14px 8px 14px;
        position: relative;
    }
    .search-input {
        width: 100%;
        background: white;
        border: 1.5px solid var(--border-light);
        border-radius: 14px;
        padding: 12px 16px 12px 42px;
        font-size: 0.92rem;
        outline: none;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.12);
    }
    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 16px;
    }

    /* Banner Carousel */
    .banner-container {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        gap: 12px;
        padding: 4px 14px 12px 14px;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }
    .banner-container::-webkit-scrollbar {
        display: none;
    }
    .banner-slide {
        flex: 0 0 92%;
        scroll-snap-align: center;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 16/7;
        background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        position: relative;
    }
    .banner-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Category Filter Pills */
    .category-scroll {
        display: flex;
        overflow-x: auto;
        gap: 8px;
        padding: 6px 14px 12px 14px;
        scrollbar-width: none;
        position: sticky;
        top: 58px;
        background: var(--bg-body);
        z-index: 90;
    }
    .category-scroll::-webkit-scrollbar {
        display: none;
    }
    .cat-pill {
        white-space: nowrap;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        background: white;
        border: 1.5px solid var(--border-light);
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.2s;
    }
    .cat-pill.active {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        box-shadow: 0 3px 10px rgba(220, 38, 38, 0.25);
    }

    /* Category Section */
    .category-title {
        font-size: 1.05rem;
        font-weight: 800;
        margin: 18px 14px 10px 14px;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .category-title i {
        color: var(--primary);
        font-size: 14px;
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
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .product-card:active {
        transform: scale(0.99);
    }
    .prod-img-wrap {
        width: 76px;
        height: 76px;
        border-radius: 12px;
        background: #fef2f2;
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #fee2e2;
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
        font-size: 0.9rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
    }
    .prod-tamil {
        font-size: 0.78rem;
        color: #64748b;
        margin-top: 2px;
    }
    .prod-pricing {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-top: 6px;
    }
    .net-rate {
        font-size: 1.05rem;
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
    }

    /* Stepper */
    .stepper {
        display: flex;
        align-items: center;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .stepper-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        color: #0f172a;
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stepper-btn:active {
        background: #e2e8f0;
    }
    .stepper-btn.add-btn {
        background: var(--primary);
        color: white;
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
        bottom: calc(68px + var(--safe-bottom));
        left: 14px;
        right: 14px;
        z-index: 999;
        background: linear-gradient(135deg, #15803d 0%, #166534 100%);
        color: white;
        border-radius: 16px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 25px rgba(21, 128, 61, 0.4);
        animation: slideUp 0.3s ease-out;
    }
    @keyframes slideUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .cart-summary-text {
        display: flex;
        flex-direction: column;
    }
    .cart-summary-qty {
        font-size: 0.75rem;
        opacity: 0.9;
        font-weight: 600;
    }
    .cart-summary-total {
        font-size: 1.15rem;
        font-weight: 800;
    }
    .cart-btn-action {
        background: white;
        color: #15803d;
        font-weight: 800;
        font-size: 0.85rem;
        padding: 9px 16px;
        border-radius: 12px;
        border: none;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    /* Modal / Drawer */
    .drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
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
        border-radius: 24px 24px 0 0;
        z-index: 2001;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(100%);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        padding-bottom: calc(20px + var(--safe-bottom));
    }
    .drawer-sheet.active {
        transform: translateY(0);
    }
    .drawer-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
    }
    .drawer-close {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f5f9;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #64748b;
    }

    .form-group {
        margin-bottom: 14px;
    }
    .form-label {
        display: block;
        font-size: 0.78rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }
    .form-input {
        width: 100%;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1.5px solid var(--border-light);
        font-size: 0.92rem;
        outline: none;
        box-sizing: border-box;
    }
    .form-input:focus {
        border-color: var(--primary);
    }
</style>
@endpush

@section('content')
    <!-- App Header -->
    <header class="app-header">
        <div class="header-content">
            <div class="brand-info">
                <div class="brand-icon">
                    <i class="fa-solid fa-sparkles"></i>
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
                <a href="https://wa.me/91{{ $shop['phone'] ?? '9789874381' }}?text=Hello%20Guru%20Crackers" target="_blank" class="header-btn" title="WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Search Input -->
    <div class="search-box-wrap">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
        <input type="text" id="productSearch" class="search-input" placeholder="Search crackers by English or தமிழ் name..." oninput="filterProducts()">
    </div>

    <!-- Banner Slides -->
    @if(!empty($banners) && count($banners) > 0)
        <div class="banner-container">
            @foreach($banners as $banner)
                @if(!empty($banner['image_url']))
                    <div class="banner-slide">
                        <img src="{{ $banner['image_url'] }}" alt="Banner" loading="lazy">
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <!-- Category Filter Pills -->
    @if(!empty($categories))
        <div class="category-scroll">
            <a href="javascript:void(0)" class="cat-pill active" onclick="selectCategory(null, this)">All Crackers</a>
            @foreach($categories as $cat)
                <a href="javascript:void(0)" class="cat-pill" onclick="selectCategory({{ $cat['id'] }}, this)">
                    {{ $cat['name'] }}
                </a>
            @endforeach
        </div>
    @endif

    <!-- Product Catalog List -->
    <main class="page-content" id="catalogContent">
        @forelse($categories as $cat)
            <div class="category-group" data-cat-id="{{ $cat['id'] }}">
                <h2 class="category-title">
                    <i class="fa-solid fa-burst"></i> {{ $cat['name'] }}
                </h2>

                <div class="products-list">
                    @foreach($cat['products'] as $prod)
                        <div class="product-card" 
                             data-prod-id="{{ $prod['id'] }}" 
                             data-name="{{ strtolower($prod['name']) }}" 
                             data-tamil="{{ strtolower($prod['tamil_name'] ?? '') }}">
                            
                            <div class="prod-img-wrap">
                                @if(!empty($prod['image_url']))
                                    <img src="{{ $prod['image_url'] }}" alt="{{ $prod['name'] }}" loading="lazy">
                                @else
                                    <i class="fa-solid fa-fire text-danger" style="font-size: 28px; color: #dc2626;"></i>
                                @endif
                            </div>

                            <div class="prod-info">
                                <div class="prod-name">{{ $prod['name'] }}</div>
                                @if(!empty($prod['tamil_name']))
                                    <div class="prod-tamil tamil-text">{{ $prod['tamil_name'] }}</div>
                                @endif
                                
                                <div class="prod-pricing">
                                    <span class="net-rate">₹{{ number_format($prod['net_rate'], 0) }}</span>
                                    @if($prod['actual_rate'] > $prod['net_rate'])
                                        <span class="actual-rate">₹{{ number_format($prod['actual_rate'], 0) }}</span>
                                        <span class="discount-pill">{{ round((($prod['actual_rate'] - $prod['net_rate']) / $prod['actual_rate']) * 100) }}% OFF</span>
                                    @endif
                                </div>
                            </div>

                            <div class="stepper">
                                <button type="button" class="stepper-btn" onclick="updateQty({{ $prod['id'] }}, -1, {{ $prod['net_rate'] }}, '{{ addslashes($prod['name']) }}')">-</button>
                                <span class="stepper-val" id="qty-val-{{ $prod['id'] }}">0</span>
                                <button type="button" class="stepper-btn add-btn" onclick="updateQty({{ $prod['id'] }}, 1, {{ $prod['net_rate'] }}, '{{ addslashes($prod['name']) }}')">+</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px 20px; color: #64748b;">
                <i class="fa-solid fa-box-open" style="font-size: 40px; margin-bottom: 12px; color: #cbd5e1;"></i>
                <p>No products available right now. Please check back later!</p>
            </div>
        @endforelse
    </main>

    <!-- Floating Cart Bar -->
    <div id="floatingCart" class="floating-cart-bar" style="display: none;">
        <div class="cart-summary-text">
            <span class="cart-summary-qty" id="cartBarQty">0 Items Added</span>
            <span class="cart-summary-total" id="cartBarTotal">₹0</span>
        </div>
        <button type="button" class="cart-btn-action" onclick="openCartDrawer()">
            <span>View Cart</span>
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <!-- Cart & Checkout Drawer -->
    <div id="drawerOverlay" class="drawer-overlay" onclick="closeCartDrawer()"></div>
    <div id="drawerSheet" class="drawer-sheet">
        <div class="drawer-header">
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a;">Your Cart & Checkout</h3>
                <span style="font-size: 0.75rem; color: #64748b;">Review items and place order</span>
            </div>
            <button type="button" class="drawer-close" onclick="closeCartDrawer()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div style="padding: 16px 20px;">
            <!-- Cart Items List -->
            <div id="drawerCartItems" style="margin-bottom: 18px; max-height: 220px; overflow-y: auto;">
                <!-- Populated via JS -->
            </div>

            <div style="background: #f8fafc; border-radius: 14px; padding: 12px 16px; margin-bottom: 18px; border: 1px solid var(--border-light);">
                <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 1rem; color: #0f172a;">
                    <span>Grand Total:</span>
                    <span id="drawerGrandTotal" style="color: #16a34a; font-weight: 800;">₹0</span>
                </div>
            </div>

            <!-- Customer Details Form -->
            <form id="checkoutForm" onsubmit="handleCheckout(event)">
                <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" id="cust_name" name="name" class="form-input" placeholder="Enter your full name" required minlength="3">
                </div>

                <div class="form-group">
                    <label class="form-label">Primary Mobile Number (10 Digits) *</label>
                    <input type="tel" id="cust_phone1" name="phone1" class="form-input" placeholder="e.g. 9876543210" pattern="[6-9][0-9]{9}" maxlength="10" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Alternate Mobile Number (Optional)</label>
                    <input type="tel" id="cust_phone2" name="phone2" class="form-input" placeholder="Secondary mobile" pattern="[6-9][0-9]{9}" maxlength="10">
                </div>

                <div class="form-group">
                    <label class="form-label">Delivery Address *</label>
                    <textarea id="cust_address" name="delivery_address" class="form-input" rows="2" placeholder="House no, Street, Landmark" required minlength="5"></textarea>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">City / Town *</label>
                        <input type="text" id="cust_city" name="city" class="form-input" placeholder="City" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Pincode *</label>
                        <input type="tel" id="cust_pincode" name="pincode" class="form-input" placeholder="6 digits" pattern="[0-9]{6}" maxlength="6" required>
                    </div>
                </div>

                <input type="hidden" name="state" value="Tamil Nadu">

                <div id="checkoutError" style="display: none; padding: 10px 14px; background: #fee2e2; color: #dc2626; border-radius: 10px; font-size: 0.82rem; font-weight: 600; margin-bottom: 12px;"></div>

                <button type="submit" id="submitOrderBtn" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; border: none; border-radius: 14px; font-weight: 800; font-size: 1rem; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.35); display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-lock"></i>
                    <span>Confirm & Place Order</span>
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // In-memory & local cart state
    let cart = JSON.parse(localStorage.getItem('guru_cracker_cart') || '{}');

    function saveCart() {
        localStorage.setItem('guru_cracker_cart', JSON.stringify(cart));
        renderCartUI();
    }

    function updateQty(id, delta, rate, name) {
        if (!cart[id]) {
            cart[id] = { id: id, qty: 0, rate: rate, name: name };
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

        // Reset stepper numbers
        document.querySelectorAll('.stepper-val').forEach(el => el.textContent = '0');

        for (const [id, item] of Object.entries(cart)) {
            const valEl = document.getElementById(`qty-val-${id}`);
            if (valEl) valEl.textContent = item.qty;
            totalItems += item.qty;
            totalPrice += item.qty * item.rate;
        }

        // Update Nav Badge
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
                document.getElementById('cartBarQty').textContent = `${totalItems} Items Added`;
                document.getElementById('cartBarTotal').textContent = `₹${totalPrice.toLocaleString('en-IN')}`;
            } else {
                bar.style.display = 'none';
            }
        }

        // Populate Drawer
        const drawerContainer = document.getElementById('drawerCartItems');
        if (drawerContainer) {
            if (totalItems === 0) {
                drawerContainer.innerHTML = '<p style="text-align: center; color: #94a3b8; padding: 20px;">Your cart is empty.</p>';
            } else {
                let html = '';
                for (const [id, item] of Object.entries(cart)) {
                    html += `
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px dashed #e2e8f0;">
                            <div>
                                <div style="font-weight: 700; font-size: 0.88rem; color: #1e293b;">${item.name}</div>
                                <div style="font-size: 0.75rem; color: #64748b;">₹${item.rate} × ${item.qty}</div>
                            </div>
                            <div style="font-weight: 800; color: #16a34a;">₹${(item.rate * item.qty).toLocaleString('en-IN')}</div>
                        </div>
                    `;
                }
                drawerContainer.innerHTML = html;
            }
            document.getElementById('drawerGrandTotal').textContent = `₹${totalPrice.toLocaleString('en-IN')}`;
        }
    }

    function openCartDrawer() {
        document.getElementById('drawerOverlay').classList.add('active');
        document.getElementById('drawerSheet').classList.add('active');
    }

    function closeCartDrawer() {
        document.getElementById('drawerOverlay').classList.remove('active');
        document.getElementById('drawerSheet').classList.remove('active');
    }

    function selectCategory(catId, btn) {
        document.querySelectorAll('.cat-pill').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');

        const groups = document.querySelectorAll('.category-group');
        groups.forEach(group => {
            if (!catId || group.getAttribute('data-cat-id') == catId) {
                group.style.display = 'block';
            } else {
                group.style.display = 'none';
            }
        });
    }

    function filterProducts() {
        const query = document.getElementById('productSearch').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.product-card');

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const tamil = card.getAttribute('data-tamil');
            if (name.includes(query) || tamil.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    async function handleCheckout(event) {
        event.preventDefault();
        const errEl = document.getElementById('checkoutError');
        errEl.style.display = 'none';

        if (Object.keys(cart).length === 0) {
            errEl.textContent = 'Please add at least one product to cart.';
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
                errEl.textContent = data.message || 'Validation failed. Please verify your details.';
                errEl.style.display = 'block';
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-lock"></i> Confirm & Place Order';
            }
        } catch (e) {
            errEl.textContent = 'Network error. Please check your internet connection.';
            errEl.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-lock"></i> Confirm & Place Order';
        }
    }

    // Initialize UI on load
    document.addEventListener('DOMContentLoaded', () => {
        renderCartUI();
    });
</script>
@endpush
