@extends('layouts.app')
@section('title', __('messages.analytics'))
@section('page-title', __('messages.analytics'))

@section('content')
<!-- KPI row -->
<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-percentage"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $conversionRate }}%</div>
            <div class="stat-label">Conversion Rate</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-chart-bar"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ array_sum(array_column($revenueByMonth, 'orders')) }}</div>
            <div class="stat-label">Orders (6 months)</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-dollar-sign"></i></div>
        <div class="stat-info">
            <div class="stat-value">${{ number_format(array_sum(array_column($revenueByMonth, 'revenue')), 0) }}</div>
            <div class="stat-label">Revenue (6 months)</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-globe"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $topCountries->count() }}</div>
            <div class="stat-label">Countries</div>
        </div>
    </div>
</div>

<div class="grid-2" style="margin-bottom:24px;">
    <div class="card">
        <div class="card-header"><span class="card-title">Revenue & Orders (6 months)</span></div>
        <div class="card-body"><canvas id="barChart" height="140"></canvas></div>
    </div>
    <div class="card">
        <div class="card-header"><span class="card-title">Orders by Status</span></div>
        <div class="card-body" style="display:flex;align-items:center;justify-content:center;">
            <canvas id="pieChart" height="180" style="max-width:280px;"></canvas>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><span class="card-title">Top Countries</span></div>
    <div class="card-body">
        @foreach($topCountries as $c)
        @php $pct = $topCountries->sum('count') > 0 ? round(($c->count / $topCountries->sum('count')) * 100) : 0; @endphp
        <div style="margin-bottom:16px;">
            <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                <span class="fw-600">{{ $c->country ?: 'Unknown' }}</span>
                <span class="text-muted text-sm">{{ $c->count }} customers ({{ $pct }}%)</span>
            </div>
            <div style="height:8px;background:var(--secondary);border-radius:4px;overflow:hidden;">
                <div style="height:100%;width:{{ $pct }}%;background:var(--primary);border-radius:4px;transition:width .6s;"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
const data = @json($revenueByMonth);
const statusData = @json($ordersByStatus);

new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: data.map(d => d.month),
        datasets: [
            { label: 'Revenue ($)', data: data.map(d => d.revenue), backgroundColor: 'rgba(99,102,241,.7)', borderRadius: 6, yAxisID: 'y' },
            { label: 'Orders', data: data.map(d => d.orders), backgroundColor: 'rgba(16,185,129,.7)', borderRadius: 6, yAxisID: 'y1' },
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y: { beginAtZero: true, position: 'left', ticks: { callback: v => '$' + v } },
            y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } },
            x: { grid: { display: false } }
        }
    }
});

const statusColors = { pending:'#f59e0b', processing:'#3b82f6', shipped:'#8b5cf6', delivered:'#10b981', cancelled:'#ef4444' };
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: Object.keys(statusData),
        datasets: [{ data: Object.values(statusData), backgroundColor: Object.keys(statusData).map(k => statusColors[k] || '#94a3b8'), borderWidth: 0 }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endpush
