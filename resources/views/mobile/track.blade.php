@extends('layouts.mobile')

@section('title', 'Track Order - Guru Crackers Sivakasi')

@push('styles')
<style>
    .track-top-header {
        position: sticky;
        top: 0;
        z-index: 100;
        background: linear-gradient(135deg, #b91c1c 0%, #881337 50%, #7f1d1d 100%);
        color: white;
        padding: calc(var(--safe-top) + 8px) 16px 14px 16px;
        box-shadow: 0 4px 20px rgba(185, 28, 28, 0.28);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .track-top-brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .track-logo {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: white;
        padding: 3px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        object-fit: contain;
    }
    .track-title {
        font-size: 1.12rem;
        font-weight: 800;
        line-height: 1.2;
    }
    .track-sub {
        font-size: 0.72rem;
        color: #fef08a;
        font-weight: 600;
    }

    .track-card {
        background: white;
        border-radius: 20px;
        padding: 18px;
        margin: 14px;
        border: 1px solid var(--border-light);
        box-shadow: 0 4px 18px rgba(0,0,0,0.04);
    }

    .search-mode-tabs {
        display: flex;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 14px;
        margin-bottom: 14px;
    }
    .search-tab-btn {
        flex: 1;
        text-align: center;
        padding: 8px 10px;
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        border: none;
        background: transparent;
        border-radius: 10px;
        transition: all 0.2s ease;
    }
    .search-tab-btn.active {
        background: white;
        color: var(--primary);
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .track-input-wrap {
        position: relative;
        margin-bottom: 12px;
    }
    .track-input {
        width: 100%;
        padding: 13px 44px 13px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        font-size: 0.95rem;
        font-weight: 600;
        outline: none;
        transition: all 0.2s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }
    .track-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12);
    }
    .track-input-clear {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: #e2e8f0;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        color: #475569;
        cursor: pointer;
    }

    .btn-track-submit {
        width: 100%;
        padding: 13px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 800;
        font-size: 0.96rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.3);
        cursor: pointer;
        transition: transform 0.15s ease;
    }
    .btn-track-submit:active {
        transform: scale(0.98);
    }

    /* Order Result Card */
    .order-box {
        background: white;
        border-radius: 20px;
        margin: 0 14px 16px 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .order-box-header {
        padding: 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-box-num {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .copy-chip {
        font-size: 0.68rem;
        padding: 2px 7px;
        background: #e2e8f0;
        color: #475569;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
    }
    .order-date-text {
        font-size: 0.72rem;
        color: #64748b;
        margin-top: 2px;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.76rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
    .timeline-wrap {
        padding: 18px 16px 14px 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .steps-stepper {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 12px 0 6px 0;
    }
    .steps-stepper::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 20px;
        right: 20px;
        height: 3px;
        background: #e2e8f0;
        z-index: 1;
    }
    .step-node {
        position: relative;
        z-index: 2;
        text-align: center;
        width: 25%;
    }
    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 6px auto;
        font-size: 13px;
        font-weight: 700;
        border: 3px solid white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        transition: all 0.3s;
    }
    .step-node.completed .step-circle {
        background: #16a34a;
        color: white;
    }
    .step-node.active .step-circle {
        background: #dc2626;
        color: white;
        box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.2);
    }
    .step-label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #64748b;
        line-height: 1.2;
    }
    .step-node.completed .step-label { color: #16a34a; }
    .step-node.active .step-label { color: #dc2626; font-weight: 800; }

    /* Order Details Section */
    .order-details-grid {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.84rem;
        margin-bottom: 7px;
        color: #475569;
    }
    .detail-row:last-child { margin-bottom: 0; }
    .detail-label { font-weight: 600; color: #64748b; }
    .detail-value { font-weight: 700; color: #0f172a; text-align: right; }

    /* Items accordion */
    .items-box {
        padding: 12px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
    }
    .items-box-title {
        font-size: 0.8rem;
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

    /* Actions Bar */
    .order-actions-bar {
        padding: 14px 16px;
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
    .btn-action-primary {
        background: var(--primary);
        color: white;
    }
    .btn-action-outline {
        background: #f1f5f9;
        color: #334155;
    }
    .btn-action-whatsapp {
        background: #22c55e;
        color: white;
    }
</style>
@endpush

@section('content')
    <!-- Top Branded Header -->
    <header class="track-top-header">
        <div class="track-top-brand">
            <img src="{{ asset('images/logo.png') }}" class="track-logo" alt="Guru Crackers">
            <div>
                <h1 class="track-title">Track Order</h1>
                <div class="track-sub">
                    <i class="fa-solid fa-truck-ramp-box"></i> Live Dispatch & Delivery Status
                </div>
            </div>
        </div>
        <a href="{{ route('mobile.home') }}" class="header-btn" title="Back to Catalog">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </header>

    <div class="page-content" style="padding-bottom: 20px;">
        <!-- Search Card -->
        <div class="track-card">
            <div class="search-mode-tabs">
                <button type="button" class="search-tab-btn active" id="tabMobile" onclick="switchTrackTab('mobile')">
                    <i class="fa-solid fa-mobile-screen"></i> 10-Digit Mobile No
                </button>
                <button type="button" class="search-tab-btn" id="tabOrderId" onclick="switchTrackTab('order')">
                    <i class="fa-solid fa-receipt"></i> Order Number
                </button>
            </div>

            <form id="trackForm" onsubmit="handleTrack(event)">
                <div class="track-input-wrap">
                    <input type="text" id="trackQuery" class="track-input" placeholder="Enter 10-digit mobile number" required autofocus>
                    <button type="button" id="trackClearBtn" class="track-input-clear" onclick="clearTrackInput()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div id="searchTip" style="font-size: 0.74rem; color: #64748b; margin-bottom: 12px;">
                    <i class="fa-solid fa-circle-info"></i> Enter the phone number used during checkout to view all your booked orders.
                </div>

                <button type="submit" id="trackSubmitBtn" class="btn-track-submit">
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
    </div>
@endsection

@push('scripts')
<script>
    let currentTab = 'mobile';

    function switchTrackTab(tab) {
        currentTab = tab;
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
        input.focus();
    }

    const trackInputEl = document.getElementById('trackQuery');
    const trackClearBtn = document.getElementById('trackClearBtn');
    if (trackInputEl) {
        trackInputEl.addEventListener('input', function() {
            if (this.value.trim().length > 0) {
                trackClearBtn.style.display = 'flex';
            } else {
                trackClearBtn.style.display = 'none';
            }
        });
    }

    function clearTrackInput() {
        trackInputEl.value = '';
        trackClearBtn.style.display = 'none';
        trackInputEl.focus();
    }

    function copyToClipboard(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const original = btn.textContent;
            btn.textContent = 'Copied!';
            btn.style.background = '#16a34a';
            btn.style.color = '#ffffff';
            setTimeout(() => {
                btn.textContent = original;
                btn.style.background = '#e2e8f0';
                btn.style.color = '#475569';
            }, 1800);
        }).catch(() => {});
    }

    async function handleTrack(event) {
        if (event) event.preventDefault();
        const query = trackInputEl.value.trim();
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
                body: JSON.stringify({ query: query })
            });

            const data = await response.json();

            if (data.success && data.orders && data.orders.length > 0) {
                let html = '';
                const backendUrl = "{{ $backendUrl ?? 'https://gurucrackers.onrender.com' }}";

                data.orders.forEach(order => {
                    const status = (order.status || 'pending').toLowerCase();
                    let statusLabel = 'Placed';
                    let statusClass = 'status-pending';
                    let statusIcon = 'fa-clock';

                    if (status === 'processing' || status === 'confirmed') {
                        statusLabel = 'Packing in Progress';
                        statusClass = 'status-processing';
                        statusIcon = 'fa-box-open';
                    } else if (status === 'dispatched' || status === 'shipped') {
                        statusLabel = 'Dispatched (In Transit)';
                        statusClass = 'status-dispatched';
                        statusIcon = 'fa-truck-arrow-right';
                    } else if (status === 'delivered') {
                        statusLabel = 'Delivered';
                        statusClass = 'status-delivered';
                        statusIcon = 'fa-circle-check';
                    } else if (status === 'cancelled') {
                        statusLabel = 'Cancelled';
                        statusClass = 'status-cancelled';
                        statusIcon = 'fa-ban';
                    } else {
                        statusLabel = 'Order Placed';
                    }

                    // Stepper status flags
                    const step1 = true;
                    const step2 = ['processing', 'confirmed', 'dispatched', 'shipped', 'delivered'].includes(status);
                    const step3 = ['dispatched', 'shipped', 'delivered'].includes(status);
                    const step4 = status === 'delivered';

                    // Payment status badge
                    const isPaid = order.payment_status === 'paid';
                    const paymentBadgeHtml = isPaid
                        ? `<span style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; background: #dcfce7; color: #15803d; border-radius: 8px; font-weight: 700; font-size: 0.72rem;"><i class="fa-solid fa-check"></i> Paid</span>`
                        : `<span style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; background: #fef3c7; color: #b45309; border-radius: 8px; font-weight: 700; font-size: 0.72rem;"><i class="fa-solid fa-clock"></i> Payment Verification Pending</span>`;

                    // Items table
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
                                    <div style="font-weight: 800; color: #0f172a;">₹${itemTotal.toLocaleString('en-IN')}</div>
                                </div>
                            `;
                        });
                        itemsHtml += `</div>`;
                    }

                    // Links
                    const invoicePdfUrl = `${backendUrl}/order/invoice/${order.order_number}/download`;
                    const invoiceWebUrl = `${backendUrl}/order/invoice/${order.order_number}`;
                    const whatsappMsg = encodeURIComponent(`Hi Guru Crackers! I would like to know the dispatch & LR status of my Order #${order.order_number} (${order.name})`);
                    const whatsappUrl = `https://wa.me/91{{ $shop['phone'] ?? '9789874381' }}?text=${whatsappMsg}`;

                    html += `
                        <div class="order-box">
                            <div class="order-box-header">
                                <div>
                                    <div class="order-box-num">
                                        <span>#${order.order_number}</span>
                                        <span class="copy-chip" onclick="copyToClipboard('${order.order_number}', this)">Copy</span>
                                    </div>
                                    <div class="order-date-text">
                                        <i class="fa-regular fa-calendar"></i> Booked: ${order.created_at || 'Recently'}
                                    </div>
                                </div>
                                <span class="status-badge ${statusClass}">
                                    <i class="fa-solid ${statusIcon}"></i> ${statusLabel}
                                </span>
                            </div>

                            <!-- 4-Step Visual Tracker -->
                            <div class="timeline-wrap">
                                <div class="steps-stepper">
                                    <div class="step-node ${step1 ? (step2 ? 'completed' : 'active') : ''}">
                                        <div class="step-circle"><i class="fa-solid fa-check"></i></div>
                                        <div class="step-label">Placed</div>
                                    </div>
                                    <div class="step-node ${step2 ? (step3 ? 'completed' : 'active') : ''}">
                                        <div class="step-circle"><i class="fa-solid fa-box"></i></div>
                                        <div class="step-label">Packed</div>
                                    </div>
                                    <div class="step-node ${step3 ? (step4 ? 'completed' : 'active') : ''}">
                                        <div class="step-circle"><i class="fa-solid fa-truck"></i></div>
                                        <div class="step-label">Dispatched</div>
                                    </div>
                                    <div class="step-node ${step4 ? 'completed active' : ''}">
                                        <div class="step-circle"><i class="fa-solid fa-house"></i></div>
                                        <div class="step-label">Delivered</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="order-details-grid">
                                <div class="detail-row">
                                    <span class="detail-label">Customer Name</span>
                                    <span class="detail-value">${order.name}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Delivery Destination</span>
                                    <span class="detail-value">${order.city || 'Tamil Nadu'}</span>
                                </div>
                                ${order.delivery_address ? `
                                <div class="detail-row">
                                    <span class="detail-label">Address</span>
                                    <span class="detail-value" style="font-size: 0.78rem; max-width: 60%;">${order.delivery_address}</span>
                                </div>
                                ` : ''}
                                <div class="detail-row">
                                    <span class="detail-label">Payment Status</span>
                                    <span class="detail-value">${paymentBadgeHtml}</span>
                                </div>
                                <div class="detail-row" style="margin-top: 8px; padding-top: 8px; border-top: 1px dashed #e2e8f0;">
                                    <span class="detail-label" style="font-weight: 800; color: #0f172a; font-size: 0.95rem;">Total Order Amount</span>
                                    <span class="detail-value" style="font-size: 1.1rem; color: #16a34a; font-weight: 800;">₹${Number(order.total_amount).toLocaleString('en-IN')}</span>
                                </div>
                            </div>

                            ${itemsHtml}

                            <!-- Action Buttons -->
                            <div class="order-actions-bar">
                                <a href="${invoicePdfUrl}" target="_blank" class="btn-action btn-action-primary">
                                    <i class="fa-solid fa-file-pdf"></i> Download Invoice
                                </a>
                                <a href="${invoiceWebUrl}" target="_blank" class="btn-action btn-action-outline">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> View Invoice
                                </a>
                                <a href="${whatsappUrl}" target="_blank" class="btn-action btn-action-whatsapp">
                                    <i class="fa-brands fa-whatsapp"></i> Help on WhatsApp
                                </a>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;
            } else {
                container.innerHTML = `
                    <div class="track-card" style="text-align: center; padding: 40px 20px;">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px auto; font-size: 24px;">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </div>
                        <h3 style="font-weight: 800; color: #0f172a; font-size: 1.05rem;">No Orders Found</h3>
                        <p style="font-size: 0.82rem; color: #64748b; margin: 6px auto 16px auto; max-width: 280px;">
                            We couldn't find any orders matching "<strong>${query}</strong>". Please verify your mobile number or Order ID.
                        </p>
                        <a href="https://wa.me/91{{ $shop['phone'] ?? '9789874381' }}?text=Hi%20Guru%20Crackers,%20I%20need%20help%20tracking%20my%20order" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: #22c55e; color: white; border-radius: 12px; font-weight: 700; text-decoration: none; font-size: 0.85rem;">
                            <i class="fa-brands fa-whatsapp"></i> Contact Support on WhatsApp
                        </a>
                    </div>
                `;
            }
        } catch (e) {
            container.innerHTML = `
                <div class="track-card" style="text-align: center; padding: 30px 20px;">
                    <i class="fa-solid fa-wifi" style="font-size: 32px; color: #cbd5e1; margin-bottom: 10px;"></i>
                    <h3 style="font-weight: 800; color: #0f172a;">Connection Issue</h3>
                    <p style="font-size: 0.82rem; color: #64748b; margin: 6px 0 14px 0;">Could not reach store server. Please check your internet connection.</p>
                    <button type="button" onclick="handleTrack()" style="padding: 9px 20px; background: var(--primary); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">
                        Retry
                    </button>
                </div>
            `;
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Search & Track Order';
            if (window.hidePageLoader) window.hidePageLoader();
        }
    }

    // Auto-search if query param present in URL
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const query = urlParams.get('query');
        if (query) {
            trackInputEl.value = query;
            if (trackClearBtn) trackClearBtn.style.display = 'flex';
            handleTrack();
        }
    });
</script>
@endpush
