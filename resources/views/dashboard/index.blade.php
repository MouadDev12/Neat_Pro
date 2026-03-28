@extends('layouts.app')
@section('title', __('messages.dashboard'))
@section('page-title', __('messages.dashboard'))

@section('content')
<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-dollar-sign"></i></div>
        <div class="stat-info">
            <div class="stat-value">${{ number_format($stats['total_revenue'], 0) }}</div>
            <div class="stat-label">{{ __('messages.total_revenue') }}</div>
            <div class="stat-change {{ $stats['revenue_growth'] >= 0 ? 'up' : 'down' }}">
                <i class="fas fa-arrow-{{ $stats['revenue_growth'] >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($stats['revenue_growth']) }}% {{ __('messages.vs_last_month') }}
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-shopping-cart"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ number_format($stats['total_orders']) }}</div>
            <div class="stat-label">{{ __('messages.total_orders') }}</div>
            <div class="stat-change up"><i class="fas fa-clock"></i> {{ $stats['pending_orders'] }} pending</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ number_format($stats['total_customers']) }}</div>
            <div class="stat-label">{{ __('messages.total_customers') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-user-shield"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
            <div class="stat-label">{{ __('messages.total_users') }}</div>
        </div>
    </div>
</div>

<!-- Charts row -->
<div class="grid-2" style="margin-bottom:24px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">{{ __('messages.revenue_overview') }}</span>
            <span class="badge badge-success">12 months</span>
        </div>
        <div class="card-body">
            <canvas id="revenueChart" height="120"></canvas>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <span class="card-title">{{ __('messages.orders_by_status') }}</span>
        </div>
        <div class="card-body" style="display:flex;align-items:center;justify-content:center;">
            <canvas id="statusChart" height="160" style="max-width:260px;"></canvas>
        </div>
    </div>
</div>

<!-- Recent orders + Top customers -->
<div class="grid-2">
    <div class="card">
        <div class="card-header">
            <span class="card-title">{{ __('messages.recent_orders') }}</span>
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline">View all</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Order</th><th>Customer</th><th>Total</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td><a href="{{ route('orders.show', $order) }}" style="color:var(--primary);font-weight:600;">{{ $order->order_number }}</a></td>
                        <td>{{ $order->customer->name }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>
                            @php
                                $map = ['pending'=>'warning','processing'=>'info','shipped'=>'purple','delivered'=>'success','cancelled'=>'danger'];
                            @endphp
                            <span class="badge badge-{{ $map[$order->status] ?? 'secondary' }}">{{ $order->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:24px;">No orders yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">{{ __('messages.top_customers') }}</span>
            <a href="{{ route('crm.index') }}" class="btn btn-sm btn-outline">View all</a>
        </div>
        <div class="card-body" style="padding:0;">
            @forelse($topCustomers as $customer)
            <div style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid var(--border);">
                <div style="width:38px;height:38px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--primary);font-size:14px;flex-shrink:0;">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:14px;">{{ $customer->name }}</div>
                    <div style="font-size:12px;color:var(--text-muted);">{{ $customer->company }}</div>
                </div>
                <div style="font-weight:700;color:var(--success);">${{ number_format($customer->total_spent, 0) }}</div>
            </div>
            @empty
            <div style="text-align:center;color:var(--text-muted);padding:24px;">No customers yet</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const revenueData = @json($revenueChart);
const statusData  = @json($ordersByStatus);

// Revenue chart
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: revenueData.map(d => d.month),
        datasets: [{
            label: 'Revenue',
            data: revenueData.map(d => d.revenue),
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99,102,241,.08)',
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#6366f1',
            pointRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { callback: v => '$' + v.toLocaleString() } },
            x: { grid: { display: false } }
        }
    }
});

// Status donut
const statusColors = { pending:'#f59e0b', processing:'#3b82f6', shipped:'#8b5cf6', delivered:'#10b981', cancelled:'#ef4444' };
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData),
        datasets: [{
            data: Object.values(statusData),
            backgroundColor: Object.keys(statusData).map(k => statusColors[k] || '#94a3b8'),
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        cutout: '70%',
        plugins: { legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 } } } }
    }
});
</script>
@endpush
