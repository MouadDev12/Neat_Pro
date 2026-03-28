@extends('layouts.app')
@section('title', 'Order ' . $order->order_number)
@section('page-title', 'Order ' . $order->order_number)

@section('content')
<div style="display:flex;gap:20px;flex-wrap:wrap;">
    <!-- Order details -->
    <div style="flex:2;min-width:300px;">
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <span class="card-title">Order Details</span>
                <div class="d-flex gap-2">
                    @php $map = ['pending'=>'warning','processing'=>'info','shipped'=>'purple','delivered'=>'success','cancelled'=>'danger']; @endphp
                    <span class="badge badge-{{ $map[$order->status] ?? 'secondary' }}" style="font-size:13px;padding:6px 14px;">{{ $order->status }}</span>
                    <a href="{{ route('orders.export-csv', $order) }}" class="btn btn-sm btn-outline"><i class="fas fa-download"></i> CSV</a>
                </div>
            </div>
            <div class="card-body">
                <div class="grid-2">
                    <div>
                        <div class="text-muted text-sm">Order Number</div>
                        <div class="fw-600">{{ $order->order_number }}</div>
                    </div>
                    <div>
                        <div class="text-muted text-sm">Date</div>
                        <div class="fw-600">{{ $order->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div>
                        <div class="text-muted text-sm">Total</div>
                        <div class="fw-600" style="color:var(--success);font-size:20px;">${{ number_format($order->total, 2) }}</div>
                    </div>
                    <div>
                        <div class="text-muted text-sm">Notes</div>
                        <div>{{ $order->notes ?: '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update status -->
        @if(auth()->user()->isManager())
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><span class="card-title">Update Status</span></div>
            <div class="card-body">
                <form method="POST" action="{{ route('orders.status', $order) }}" style="display:flex;gap:12px;align-items:flex-end;">
                    @csrf @method('PATCH')
                    <div class="form-group" style="flex:1;margin:0;">
                        <select name="status" class="form-control form-select">
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
        @endif

        <!-- Transactions -->
        <div class="card">
            <div class="card-header"><span class="card-title">Transactions</span></div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Reference</th><th>Amount</th><th>Method</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($order->transactions as $txn)
                        <tr>
                            <td class="fw-600">{{ $txn->reference }}</td>
                            <td>${{ number_format($txn->amount, 2) }}</td>
                            <td>{{ ucfirst($txn->method) }}</td>
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

    <!-- Customer info -->
    <div style="flex:1;min-width:260px;">
        <div class="card">
            <div class="card-header"><span class="card-title">Customer</span></div>
            <div class="card-body">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                    <div style="width:48px;height:48px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--primary);font-size:18px;">
                        {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-600">{{ $order->customer->name }}</div>
                        <div class="text-muted text-sm">{{ $order->customer->email }}</div>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <div><span class="text-muted text-sm">Phone: </span>{{ $order->customer->phone ?: '—' }}</div>
                    <div><span class="text-muted text-sm">Company: </span>{{ $order->customer->company ?: '—' }}</div>
                    <div><span class="text-muted text-sm">Country: </span>{{ $order->customer->country ?: '—' }}</div>
                    <div><span class="text-muted text-sm">Total spent: </span><strong style="color:var(--success)">${{ number_format($order->customer->total_spent, 2) }}</strong></div>
                </div>
                <div style="margin-top:16px;">
                    <a href="{{ route('crm.show', $order->customer) }}" class="btn btn-outline" style="width:100%;justify-content:center;">
                        <i class="fas fa-user"></i> View Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
