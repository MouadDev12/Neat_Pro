<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Services\ExportService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private ExportService $export) {}

    public function index(Request $request)
    {
        $orders = Order::with('customer')
            ->when($request->search, fn($q) => $q->where('order_number', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('customer', 'transactions');
        return view('orders.show', compact('order'));
    }

    public function exportPdf(Request $request)
    {
        $orders = Order::with('customer')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->get();
        return $this->export->exportOrdersPdf($orders);
    }

    public function exportCsv(Order $order)
    {
        return $this->export->exportOrderCsv($order);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated.');
    }
}
