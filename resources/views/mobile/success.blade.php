@extends('layouts.mobile')

@section('title', 'Order Received - Guru Crackers')

@push('styles')
<style>
    .success-container {
        padding: 24px 16px 40px 16px;
        text-align: center;
        max-width: 500px;
        margin: 0 auto;
    }

    .success-icon-wrap {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #16a34a;
        font-size: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px auto;
        box-shadow: 0 0 0 12px rgba(22, 163, 74, 0.12);
        animation: pop 0.45s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes pop {
        0% { transform: scale(0.5); opacity: 0; }
        80% { transform: scale(1.1); }
        100% { transform: scale(1); opacity: 1; }
    }

    .order-id-card {
        background: white;
        border-radius: 20px;
        padding: 18px;
        margin: 20px 0;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        text-align: left;
    }

    .upi-card {
        background: linear-gradient(135deg, #3730a3 0%, #1e1b4b 100%);
        color: white;
        border-radius: 22px;
        padding: 22px 18px;
        margin-bottom: 20px;
        box-shadow: 0 10px 30px rgba(55, 48, 163, 0.35);
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .upi-card::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
    }

    .btn-upi-pay {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: #fbbf24;
        color: #1e1b4b;
        font-weight: 800;
        font-size: 1.02rem;
        padding: 14px;
        border-radius: 14px;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.45);
        margin-top: 14px;
        transition: transform 0.15s;
    }
    .btn-upi-pay:active {
        transform: scale(0.98);
    }

    .upi-copy-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.15);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.76rem;
        font-weight: 700;
        margin-top: 6px;
        cursor: pointer;
    }

    .btn-action-outline {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 13px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 0.92rem;
        text-decoration: none;
        margin-bottom: 10px;
        transition: all 0.2s;
    }
    .btn-whatsapp {
        background: #22c55e;
        color: white;
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
    }
    .btn-invoice {
        background: white;
        color: #0f172a;
        border: 1.5px solid #e2e8f0;
    }
</style>
@endpush

@section('content')
<div class="success-container">
    <div class="success-icon-wrap">
        <i class="fa-solid fa-check"></i>
    </div>

    <h1 style="font-size: 1.45rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Order Placed Successfully!</h1>
    <p style="color: #64748b; font-size: 0.85rem;">Thank you for ordering with Sivakasi Guru Crackers!</p>

    <!-- Order Info Card -->
    <div class="order-id-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; font-weight: 700;">Order ID</span>
            <span style="background: #fef3c7; color: #b45309; font-size: 0.7rem; font-weight: 800; padding: 2px 8px; border-radius: 10px;">Pending Payment</span>
        </div>
        <div style="font-size: 1.4rem; font-weight: 800; color: var(--primary); margin: 6px 0;">#{{ $orderNumber }}</div>
        
        @if(!empty($order))
            <div style="border-top: 1px solid #f1f5f9; padding-top: 10px; margin-top: 10px; font-size: 0.88rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span style="color: #64748b;">Customer:</span>
                    <span style="font-weight: 700; color: #1e293b;">{{ $order['name'] ?? '' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span style="color: #64748b;">Phone:</span>
                    <span style="font-weight: 700; color: #1e293b;">{{ $order['phone1'] ?? '' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span style="color: #64748b;">Delivery City:</span>
                    <span style="font-weight: 700; color: #1e293b;">{{ $order['city'] ?? '' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 6px; border-top: 1px dashed #e2e8f0;">
                    <span style="color: #64748b; font-weight: 700;">Order Amount:</span>
                    <span style="font-weight: 800; color: #16a34a; font-size: 1.15rem;">₹{{ number_format($order['total_amount'] ?? 0, 0) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 4px; font-size: 0.78rem;">
                    <span style="color: #64748b; font-weight: 600;">Delivery Charges:</span>
                    @if(isset($order['delivery_charges']) && $order['delivery_charges'] !== null && $order['delivery_charges'] > 0)
                        <span style="font-weight: 800; color: #d97706;">₹{{ number_format($order['delivery_charges'], 2) }}</span>
                    @else
                        <span style="font-weight: 700; color: #d97706;">To Pay at Delivery (Extra)</span>
                    @endif
                </div>
                <div style="font-size: 0.70rem; color: #92400e; background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 6px 8px; margin-top: 8px;">
                    <i class="fa-solid fa-truck-fast"></i> <strong>Without Delivery Charges:</strong> டெலிவரி கட்டணம் பார்சல் அலுவலகத்தில் பெற்றுக்கொள்ளும்போது செலுத்த வேண்டும்.
                </div>
            </div>
        @endif
    </div>

    <!-- UPI Payment Box -->
    @php
        $upiId = $shop['upi_id'] ?? 'bsanthoshkumar10-1@oksbi';
        $totalAmt = $order['total_amount'] ?? 0;
        $upiIntentUrl = "upi://pay?pa={$upiId}&pn=" . urlencode($shop['name'] ?? 'Guru Crackers') . "&am={$totalAmt}&tr={$orderNumber}&cu=INR";
    @endphp
    <div class="upi-card">
        <div style="font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85;">Pay Total Amount</div>
        <div style="font-size: 2rem; font-weight: 800; margin: 4px 0;">₹{{ number_format($totalAmt, 0) }}</div>
        
        <div class="upi-copy-chip" onclick="copyUpiId('{{ $upiId }}')">
            <span>UPI ID: {{ $upiId }}</span>
            <i class="fa-solid fa-copy"></i>
        </div>
        <div id="copyToast" style="display: none; font-size: 0.72rem; color: #86efac; margin-top: 4px;">UPI ID copied to clipboard!</div>

        <a href="{{ $upiIntentUrl }}" class="btn-upi-pay">
            <i class="fa-solid fa-bolt"></i>
            <span>Pay Now with GPay / PhonePe</span>
        </a>
    </div>

    <!-- Action Buttons -->
    <a href="https://wa.me/91{{ $shop['phone'] ?? '9789874381' }}?text=Hi%20Guru%20Crackers,%20I%20have%20booked%20Order%20%23{{ $orderNumber }}%20for%20Rs.{{ $totalAmt }}" target="_blank" class="btn-action-outline btn-whatsapp">
        <i class="fa-brands fa-whatsapp" style="font-size: 18px;"></i>
        <span>Send WhatsApp Confirmation</span>
    </a>

    <a href="{{ route('mobile.track') }}?query={{ $orderNumber }}" class="btn-action-outline btn-invoice">
        <i class="fa-solid fa-truck-fast" style="color: var(--primary);"></i>
        <span>Track Order Status Live</span>
    </a>

    <a href="{{ route('mobile.home') }}" class="btn-action-outline btn-invoice">
        <i class="fa-solid fa-house"></i>
        <span>Return to Home Catalog</span>
    </a>
</div>

<script>
    function copyUpiId(id) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(id).then(() => {
                const toast = document.getElementById('copyToast');
                toast.style.display = 'block';
                setTimeout(() => toast.style.display = 'none', 3000);
            });
        }
    }
</script>
@endsection
