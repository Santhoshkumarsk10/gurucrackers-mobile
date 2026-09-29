@extends('layouts.mobile')

@section('title', 'Track Order - Guru Crackers')

@push('styles')
<style>
    .track-header {
        background: white;
        padding: 20px 16px;
        border-bottom: 1px solid var(--border-light);
        text-align: center;
    }

    .track-search-box {
        background: white;
        border-radius: 16px;
        padding: 16px;
        margin: 16px 14px;
        border: 1px solid var(--border-light);
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }

    .order-track-card {
        background: white;
        border-radius: 16px;
        padding: 16px;
        margin: 0 14px 14px 14px;
        border: 1px solid var(--border-light);
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .badge-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-pending { background: #fef3c7; color: #b45309; }
    .badge-processing { background: #e0f2fe; color: #0369a1; }
    .badge-dispatched { background: #f3e8ff; color: #6b21a8; }
    .badge-delivered { background: #dcfce7; color: #15803d; }

    /* Timeline */
    .timeline {
        position: relative;
        margin: 18px 0 10px 10px;
        padding-left: 24px;
        border-left: 2px solid #e2e8f0;
    }
    .timeline-step {
        position: relative;
        margin-bottom: 16px;
    }
    .timeline-step:last-child {
        margin-bottom: 0;
    }
    .timeline-dot {
        position: absolute;
        left: -31px;
        top: 2px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #cbd5e1;
        border: 2px solid white;
    }
    .timeline-step.done .timeline-dot {
        background: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.2);
    }
    .timeline-step.active .timeline-dot {
        background: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
    }
</style>
@endpush

@section('content')
    <div class="track-header">
        <h1 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Track Your Cracker Order</h1>
        <p style="font-size: 0.8rem; color: #64748b;">Enter your 10-digit mobile number or Order ID</p>
    </div>

    <div class="track-search-box">
        <form onsubmit="handleTrack(event)">
            <div style="position: relative;">
                <input type="text" id="trackQuery" class="form-input" placeholder="e.g. 9876543210 or GC-..." required style="padding-right: 90px;">
                <button type="submit" id="trackBtn" style="position: absolute; right: 6px; top: 6px; bottom: 6px; background: var(--primary); color: white; border: none; border-radius: 10px; padding: 0 16px; font-weight: 700; font-size: 0.85rem;">
                    Track
                </button>
            </div>
        </form>
    </div>

    <div id="trackResults" style="padding-bottom: 20px;">
        <div id="trackPlaceholder" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
            <i class="fa-solid fa-truck-ramp-box" style="font-size: 44px; margin-bottom: 12px; color: #cbd5e1;"></i>
            <p style="font-size: 0.9rem;">Your order status, LR copy, and dispatch updates will appear here.</p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    async function handleTrack(event) {
        event.preventDefault();
        const query = document.getElementById('trackQuery').value.trim();
        if (!query) return;

        const btn = document.getElementById('trackBtn');
        const container = document.getElementById('trackResults');
        btn.disabled = true;
        btn.textContent = '...';

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
                data.orders.forEach(order => {
                    const statusClass = `badge-${order.status || 'pending'}`;
                    html += `
                        <div class="order-track-card">
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 12px;">
                                <div>
                                    <div style="font-size: 0.72rem; color: #64748b; font-weight: 700;">ORDER NUMBER</div>
                                    <div style="font-size: 1.05rem; font-weight: 800; color: #dc2626;">#${order.order_number}</div>
                                </div>
                                <span class="badge-status ${statusClass}">${order.status}</span>
                            </div>

                            <div style="font-size: 0.85rem; color: #475569; margin-bottom: 6px;">
                                <strong>Customer:</strong> ${order.name} (${order.city})
                            </div>
                            <div style="font-size: 0.85rem; color: #475569; margin-bottom: 12px;">
                                <strong>Total:</strong> <span style="color: #16a34a; font-weight: 800;">₹${order.total_amount}</span> | <strong>Booked on:</strong> ${order.created_at}
                            </div>

                            <!-- Timeline -->
                            <div class="timeline">
                                <div class="timeline-step done">
                                    <div class="timeline-dot"></div>
                                    <div style="font-weight: 700; font-size: 0.82rem; color: #0f172a;">Order Placed</div>
                                    <div style="font-size: 0.72rem; color: #64748b;">Order details received successfully</div>
                                </div>
                                <div class="timeline-step ${order.status !== 'pending' ? 'done' : 'active'}">
                                    <div class="timeline-dot"></div>
                                    <div style="font-weight: 700; font-size: 0.82rem; color: #0f172a;">Order Processing</div>
                                    <div style="font-size: 0.72rem; color: #64748b;">Packing items in Sivakasi warehouse</div>
                                </div>
                                <div class="timeline-step ${order.status === 'dispatched' || order.status === 'delivered' ? 'done' : ''}">
                                    <div class="timeline-dot"></div>
                                    <div style="font-weight: 700; font-size: 0.82rem; color: #0f172a;">Dispatched via Transport</div>
                                    <div style="font-size: 0.72rem; color: #64748b;">Parcel handed over to parcel service</div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                container.innerHTML = html;
            } else {
                container.innerHTML = `
                    <div style="text-align: center; padding: 40px 20px; color: #dc2626;">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 36px; margin-bottom: 10px;"></i>
                        <p style="font-weight: 700;">No orders found matching "${query}"</p>
                        <p style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">Please check the mobile number or order reference.</p>
                    </div>
                `;
            }
        } catch (e) {
            container.innerHTML = `
                <div style="text-align: center; padding: 40px 20px; color: #dc2626;">
                    <p style="font-weight: 700;">Error retrieving tracking data. Please try again.</p>
                </div>
            `;
        } finally {
            btn.disabled = false;
            btn.textContent = 'Track';
        }
    }
</script>
@endpush
