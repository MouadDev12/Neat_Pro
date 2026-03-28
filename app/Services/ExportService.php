<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class ExportService
{
    public function exportOrdersPdf(Collection $orders)
    {
        $pdf = Pdf::loadView('exports.orders-pdf', compact('orders'));
        return $pdf->download('orders-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportOrderCsv(Order $order)
    {
        $filename = 'order-' . $order->order_number . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($order) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Order #', 'Customer', 'Total', 'Status', 'Date']);
            fputcsv($file, [
                $order->order_number,
                $order->customer->name,
                $order->total,
                $order->status,
                $order->created_at->format('Y-m-d'),
            ]);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
