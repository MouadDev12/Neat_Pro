@extends('layouts.app')
@section('title', __('messages.products'))
@section('page-title', __('messages.products'))

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">Products</span>
        @if(auth()->user()->isManager())
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('addModal').style.display='flex'">
            <i class="fas fa-plus"></i> Add Product
        </button>
        @endif
    </div>
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:16px;">
            <input type="text" name="search" class="form-control" style="max-width:220px;" placeholder="Search products..." value="{{ request('search') }}">
            <select name="category" class="form-control form-select" style="max-width:160px;">
                <option value="">All categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('ecommerce.index') }}" class="btn btn-secondary btn-sm">Reset</a>
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="fw-600">{{ $product->name }}</td>
                    <td><span class="badge badge-info">{{ $product->category ?: '—' }}</span></td>
                    <td class="fw-600" style="color:var(--success);">${{ number_format($product->price, 2) }}</td>
                    <td>
                        <span class="{{ $product->stock < 10 ? 'badge badge-danger' : 'badge badge-success' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $product->active ? 'success' : 'secondary' }}">
                            {{ $product->active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        @if(auth()->user()->isManager())
                        <button class="btn btn-sm btn-outline" onclick="editProduct({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }}, {{ $product->active ? 1 : 0 }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('ecommerce.destroy', $product) }}" style="display:inline;" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:32px;">No products found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:0 20px;">{{ $products->withQueryString()->links() }}</div>
</div>

<!-- Add Modal -->
@if(auth()->user()->isManager())
<div id="addModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:300;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;padding:32px;width:100%;max-width:480px;margin:16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <h3 style="font-size:18px;font-weight:700;">Add Product</h3>
            <button onclick="document.getElementById('addModal').style.display='none'" style="background:none;border:none;font-size:20px;cursor:pointer;">&times;</button>
        </div>
        <form method="POST" action="{{ route('ecommerce.store') }}">
            @csrf
            <div class="form-group"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" required></div>
            <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
            <div class="grid-2">
                <div class="form-group"><label class="form-label">Price *</label><input type="number" name="price" class="form-control" step="0.01" min="0" required></div>
                <div class="form-group"><label class="form-label">Stock *</label><input type="number" name="stock" class="form-control" min="0" required></div>
            </div>
            <div class="form-group"><label class="form-label">Category</label><input type="text" name="category" class="form-control"></div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Add Product</button>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:300;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;padding:32px;width:100%;max-width:480px;margin:16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <h3 style="font-size:18px;font-weight:700;">Edit Product</h3>
            <button onclick="document.getElementById('editModal').style.display='none'" style="background:none;border:none;font-size:20px;cursor:pointer;">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group"><label class="form-label">Name *</label><input type="text" id="editName" name="name" class="form-control" required></div>
            <div class="grid-2">
                <div class="form-group"><label class="form-label">Price *</label><input type="number" id="editPrice" name="price" class="form-control" step="0.01" min="0" required></div>
                <div class="form-group"><label class="form-label">Stock *</label><input type="number" id="editStock" name="stock" class="form-control" min="0" required></div>
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" id="editActive" name="active" value="1"> Active
                </label>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Save Changes</button>
        </form>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
function editProduct(id, name, price, stock, active) {
    document.getElementById('editForm').action = '/ecommerce/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editPrice').value = price;
    document.getElementById('editStock').value = stock;
    document.getElementById('editActive').checked = active === 1;
    document.getElementById('editModal').style.display = 'flex';
}
</script>
@endpush
