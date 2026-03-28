@extends('layouts.app')
@section('title', $customer->name)
@section('page-title', $customer->name)

@section('content')
<div style="display:flex;gap:20px;flex-wrap:wrap;">
    <div style="flex:1;min-width:260px;">
        <div class="card">
            <div class="card-body" style="text-align:center;padding:32px;">
                <div style="width:72px;height:72px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--primary);font-size:28px;margin:0 auto 16px;">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <h3 style="font-size:18px;font-weight:700;">{{ $customer->name }}</h3>
                <p class="text-muted text-sm">{{ $customer->email }}</p>
                <span class="badge badge-{{ $customer->status === 'active' ? 'success' : ($customer->status === 'lead' ? 'warning' : 'secondary') }}" style="margin-top:8px;">
                    {{ $customer->status }}
                </span>
            </div>
            <div style="border-top:1px solid var(--border);padding:20px;display:flex;flex-direction:column;gap:12px;">
                <div style="display:flex;justify-content:space-between;"><span class="text-muted text-sm">Phone</span><span>{{ $customer->phone ?: '—' }}</span></div>
                <div style="display:flex;justify-content:space-between;"><span class="text-muted text-sm">Company</span><span>{{ $customer->company ?: '—' }}</span></div>
                <div style="display:flex;justify-content:space-between;"><span class="text-muted text-sm">Country</span><span>{{ $customer->country ?: '—' }}</span></div>
                <div style="display:flex;justify-content:space-between;"><span class="text-muted text-sm">Total Spent</span><strong style="color:var(--success)">${{ number_format($customer->total_spent, 2) }}</strong></div>
                <div style="display:flex;justify-content:space-between;"><span class="text-muted text-sm">Member since</span><span>{{ $customer->created_at->format('M Y') }}</span></div>
            </div>
        </div>
    </div>

    <div style="flex:2;min-width:300px;display:flex;flex-direction:column;gap:20px;">
        <div class="card">
            <div class="card-header"><span class="card-title">Orders</span></div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Order #</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($customer->orders as $order)
                        @php $map = ['pending'=>'warning','processing'=>'info','shipped'=>'purple','delivered'=>'success','cancelled'=>'danger']; @endphp
                        <tr>
                            <td><a href="{{ route('orders.show', $order) }}" style="color:var(--primary);font-weight:600;">{{ $order->order_number }}</a></td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td><span class="badge badge-{{ $map[$order->status] ?? 'secondary' }}">{{ $order->status }}</span></td>
                            <td class="text-muted text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:20px;">No orders</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Transactions</span></div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Reference</th><th>Amount</th><th>Type</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($customer->transactions as $txn)
                        <tr>
                            <td class="fw-600">{{ $txn->reference }}</td>
                            <td>${{ number_format($txn->amount, 2) }}</td>
                            <td><span class="badge badge-{{ $txn->type === 'credit' ? 'success' : 'danger' }}">{{ $txn->type }}</span></td>
                            <td><span class="badge badge-{{ $txn->status === 'completed' ? 'success' : ($txn->status === 'failed' ? 'danger' : 'warning') }}">{{ $txn->status }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:20px;">No transactions</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
