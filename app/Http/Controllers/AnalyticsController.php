<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $revenueByMonth = $this->revenueByMonth();
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))->groupBy('status')->pluck('count', 'status');
        $topCountries   = Customer::select('country', DB::raw('count(*) as count'))->groupBy('country')->orderByDesc('count')->limit(5)->get();
        $conversionRate = $this->conversionRate();

        return view('analytics.index', compact('revenueByMonth', 'ordersByStatus', 'topCountries', 'conversionRate'));
    }

    private function revenueByMonth(): array
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date   = now()->subMonths($i);
            $data[] = [
                'month'   => $date->format('M'),
                'revenue' => Transaction::where('status', 'completed')->where('type', 'credit')
                    ->whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->sum('amount'),
                'orders'  => Order::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count(),
            ];
        }
        return $data;
    }

    private function conversionRate(): float
    {
        $total     = Order::count();
        $completed = Order::where('status', 'delivered')->count();
        return $total > 0 ? round(($completed / $total) * 100, 1) : 0;
    }
}
