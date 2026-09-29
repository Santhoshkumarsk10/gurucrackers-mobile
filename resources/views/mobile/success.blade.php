@extends('layouts.mobile')

@section('title', 'Order Received - Guru Crackers')

@push('styles')
<style>
    .success-container {
        padding: 30px 16px;
        text-align: center;
        max-width: 500px;
        margin: 0 auto;
    }

    .success-icon-wrap {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #dcfce7;
        color: #16a34a;
        font-size: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px auto;
        box-shadow: 0 0 0 10px rgba(22, 163, 74, 0.1);
        animation: pop 0.4s ease-out;
    }
    @keyframes pop {
        0% { transform: scale(0.6); opacity: 0; }
        80% { transform: scale(1.1); }
        100% { transform: scale(1); opacity: 1; }
    }

    .order-id-card {
        background: white;
        border-radius: 18px;
        padding: 16px;
        margin: 20px 0;
        border: 1px solid var(--border-light);
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    }

    .upi-card {
        background: linear-gradient(135deg, #4338ca 0%, #312e81 100%);
        color: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(67, 56, 202, 0.3);
        text-align: center;
    }

    .btn-upi-pay {
        display: block;
        width: 100%;
        background: #fbbf24;
        color: #1e1b4b;
        font-weight: 800;
        font-size: 1rem;
        padding: 14px;
        border-radius: 14px;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.4);
        margin-top: 14px;
        transition: transform 0.15s;
    }
    .btn-upi-pay:active {
        transform: scale(0.98);
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
        border: 1.5px solid var(--border-light);
    }
</style>
@endpush

@section('content')
<div class="success-container">
    <div class="success-icon-wrap">
        <i class="fa-solid fa-check"></i>
    </div>

    <h1 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Order Placed Successfully!</h1>
    <p style="color: #64748b; font-size: 0.85rem;">Thank you for your order. We have received your cracker booking.</p>

    <!-- Order Info Card -->
    <div class="order-id-card">
        <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; font-weight: 700;">Order Reference ID</div>
        <div style="font-size: 1.35rem; font-weight: 800; color: var(--primary); margin: 6px 0;">#{{ $orderNumber }}</div>
        
        @if(!empty($order))
            <div style="display: flex; justify-content: space-between; border-top: 1px solid #f1f5f9; padding-top: 12px; margin-top: 12px; font-size: 0.88rem;">
                <span style="color: #64748b;">Customer:</span>
                <span style="font-weight: 700; color: #1e293b;">{{ $order['name'] ?? '' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 6px; font-size: 0.88rem;">
                <span style="color: #64748b;">Registered Phone:</span>
                <span style="font-weight: 700; color: #1e293b;">{{ $order['phone1'] ?? '' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 6px; font-size: 0.88rem;">
                <span style="color: #64748b;">Total Amount:</span>
                <span style="font-weight: 800; color: #16a34a; font-size: 1.05rem;">₹{{ number_format($order['total_amount'] ?? 0, 0) }}</span>
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
        <div style="font-size: 1.8rem; font-weight: 800; margin: 4px 0;">₹{{ number_format($totalAmt, 0) }}</div>
        <div style="font-size: 0.75rem; opacity: 0.8;">UPI ID: <span style="font-weight: 700;">{{ $upiId }}</span></div>

        <a href="{{ $upiIntentUrl }}" class="btn-upi-pay">
            <i class="fa-solid fa-mobile-screen-button"></i> Pay via UPI App (GPay / PhonePe)
        </a>
    </div>

    <!-- Action Buttons -->
    <a href="https://wa.me/91{{ $shop['phone'] ?? '9789874381' }}?text=Hi%20Guru%20Crackers,%20I%20have%20paid%20for%20Order%20%23{{ $orderNumber }}" target="_blank" class="btn-action-outline btn-whatsapp">
        <i class="fa-brands fa-whatsapp" style="font-size: 18px;"></i>
        <span>Send Payment Proof on WhatsApp</span>
    </a>

    @if(!empty($downloadPdfUrl))
        <a href="{{ $downloadPdfUrl }}" target="_blank" class="btn-action-outline btn-invoice">
            <i class="fa-solid fa-file-pdf text-danger"></i>
            <span>Download Invoice PDF</span>
        </a>
    @endif

    <a href="{{ route('mobile.home') }}" class="btn-action-outline btn-invoice" style="margin-top: 10px;">
        <i class="fa-solid fa-house"></i>
        <span>Return to Home Catalog</span>
    </a>
</div>
@endsection
