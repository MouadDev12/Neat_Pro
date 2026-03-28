@extends('layouts.app')
@section('title', __('messages.orders'))
@section('page-title', __('messages.orders'))

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">{{ __('messages.orders') }}</span>
        <div class="d-flex gap-2">
            <a href="{{ route('orders.export-pdf', request()->query()) }}" class="btn btn-sm btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:16px;">
            <input type="text" name="search" class="form-control" style="max-width:240px;" placeholder="Search order #..." value="{{ request('search') }}">
            <select name="status" class="form-control form-select" style="max-width:160px;">
                <option value="">All statuses</option>
                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">Reset</a>
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php $map = ['pending'=>'warning','processing'=>'info','shipped'=>'purple','delivered'=>'success','cancelled'=>'danger']; @endphp
                <tr>
                    <td><a href="{{ route('orders.show', $order) }}" style="color:var(--primary);font-weight:600;">{{ $order->order_number }}</a></td>
                    <td>{{ $order->customer->name }}</td>
                    <td style="font-weight:600;">${{ number_format($order->total, 2) }}</td>
                    <td><span class="badge badge-{{ $map[$order->status] ?? 'secondary' }}">{{ $order->status }}</span></td>
                    <td class="text-muted text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('orders.export-csv', $order) }}" class="btn btn-sm btn-outline"><i class="fas fa-download"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:32px;">No orders found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:0 20px;">{{ $orders->withQueryString()->links() }}</div>
</div>
@endsection
