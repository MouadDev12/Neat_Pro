@extends('layouts.app')
@section('title', __('messages.crm'))
@section('page-title', __('messages.crm'))

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">Customers</span>
        @if(auth()->user()->isManager())
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('addModal').style.display='flex'">
            <i class="fas fa-plus"></i> Add Customer
        </button>
        @endif
    </div>
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:16px;">
            <input type="text" name="search" class="form-control" style="max-width:240px;" placeholder="Search name or email..." value="{{ request('search') }}">
            <select name="status" class="form-control form-select" style="max-width:140px;">
                <option value="">All</option>
                @foreach(['active','inactive','lead'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('crm.index') }}" class="btn btn-secondary btn-sm">Reset</a>
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Name</th><th>Email</th><th>Company</th><th>Country</th><th>Status</th><th>Spent</th><th>Orders</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:32px;height:32px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--primary);font-size:12px;flex-shrink:0;">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <span class="fw-600">{{ $customer->name }}</span>
                        </div>
                    </td>
                    <td class="text-muted text-sm">{{ $customer->email }}</td>
                    <td>{{ $customer->company ?: '—' }}</td>
                    <td>{{ $customer->country ?: '—' }}</td>
                    <td>
                        <span class="badge badge-{{ $customer->status === 'active' ? 'success' : ($customer->status === 'lead' ? 'warning' : 'secondary') }}">
                            {{ $customer->status }}
                        </span>
                    </td>
                    <td class="fw-600" style="color:var(--success);">${{ number_format($customer->total_spent, 0) }}</td>
                    <td>{{ $customer->orders_count }}</td>
                    <td>
                        <a href="{{ route('crm.show', $customer) }}" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i></a>
                        @if(auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('crm.destroy', $customer) }}" style="display:inline;" onsubmit="return confirm('Delete this customer?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:32px;">No customers found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:0 20px;">{{ $customers->withQueryString()->links() }}</div>
</div>

<!-- Add Customer Modal -->
@if(auth()->user()->isManager())
<div id="addModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:300;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;padding:32px;width:100%;max-width:480px;margin:16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <h3 style="font-size:18px;font-weight:700;">Add Customer</h3>
            <button onclick="document.getElementById('addModal').style.display='none'" style="background:none;border:none;font-size:20px;cursor:pointer;color:var(--text-muted);">&times;</button>
        </div>
        <form method="POST" action="{{ route('crm.store') }}">
            @csrf
            <div class="grid-2">
                <div class="form-group"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control"></div>
                <div class="form-group"><label class="form-label">Company</label><input type="text" name="company" class="form-control"></div>
                <div class="form-group"><label class="form-label">Country</label><input type="text" name="country" class="form-control"></div>
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control form-select" required>
                        <option value="lead">Lead</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Add Customer</button>
        </form>
    </div>
</div>
@endif
@endsection
