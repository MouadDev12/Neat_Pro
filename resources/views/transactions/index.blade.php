@extends('layouts.app')
@section('title', __('messages.transactions'))
@section('page-title', __('messages.transactions'))

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">Transactions</span>
    </div>
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:16px;">
            <select name="type" class="form-control form-select" style="max-width:140px;">
                <option value="">All types</option>
                @foreach(['credit','debit','refund'] as $t)
                    <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
            <select name="status" class="form-control form-select" style="max-width:140px;">
                <option value="">All statuses</option>
                @foreach(['pending','completed','failed','refunded'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">Reset</a>
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Reference</th><th>Customer</th><th>Amount</th><th>Type</th><th>Method</th><th>Status</th><th>Date</th></tr>
            </thead>
            <tbody>
                @forelse($transactions as $txn)
                <tr>
                    <td class="fw-600">{{ $txn->reference }}</td>
                    <td>{{ $txn->customer?->name ?? '—' }}</td>
                    <td class="fw-600" style="color:{{ $txn->type === 'credit' ? 'var(--success)' : 'var(--danger)' }};">
                        {{ $txn->type === 'credit' ? '+' : '-' }}${{ number_format($txn->amount, 2) }}
                    </td>
                    <td><span class="badge badge-{{ $txn->type === 'credit' ? 'success' : ($txn->type === 'refund' ? 'warning' : 'danger') }}">{{ $txn->type }}</span></td>
                    <td>{{ ucfirst($txn->method) }}</td>
                    <td><span class="badge badge-{{ $txn->status === 'completed' ? 'success' : ($txn->status === 'failed' ? 'danger' : ($txn->status === 'refunded' ? 'warning' : 'secondary')) }}">{{ $txn->status }}</span></td>
                    <td class="text-muted text-sm">{{ $txn->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:32px;">No transactions found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:0 20px;">{{ $transactions->withQueryString()->links() }}</div>
</div>
@endsection
