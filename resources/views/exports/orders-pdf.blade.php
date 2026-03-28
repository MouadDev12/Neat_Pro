<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #334155; }
    h1 { font-size: 20px; color: #0f172a; margin-bottom: 4px; }
    .subtitle { color: #94a3b8; margin-bottom: 24px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f1f5f9; padding: 10px 12px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: .05em; color: #64748b; }
    td { padding: 10px 12px; border-bottom: 1px solid #e2e8f0; }
    .badge { padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 600; }
    .pending { background: #fef3c7; color: #92400e; }
    .delivered { background: #d1fae5; color: #065f46; }
    .cancelled { background: #fee2e2; color: #991b1b; }
    .processing { background: #dbeafe; color: #1e40af; }
    .shipped { background: #ede9fe; color: #5b21b6; }
    .total-row { font-weight: 700; background: #f8fafc; }
</style>
</head>
<body>
<h1>Orders Report</h1>
<p class="subtitle">Generated on {{ now()->format('F d, Y') }}</p>

<table>
    <thead>
        <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->customer->name }}</td>
            <td>${{ number_format($order->total, 2) }}</td>
            <td><span class="badge {{ $order->status }}">{{ $order->status }}</span></td>
            <td>{{ $order->created_at->format('M d, Y') }}</td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td colspan="2">Total ({{ $orders->count() }} orders)</td>
            <td>${{ number_format($orders->sum('total'), 2) }}</td>
            <td colspan="2"></td>
        </tr>
    </tbody>
</table>
</body>
</html>
