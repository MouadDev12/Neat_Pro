<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardStatsService
{
    public function getStats(): array
    {
        return [
            'total_revenue'    => Transaction::where('status', 'completed')->where('type', 'credit')->sum('amount'),
            'total_orders'     => Order::count(),
            'total_customers'  => Customer::count(),
            'total_users'      => User::count(),
            'pending_orders'   => Order::where('status', 'pending')->count(),
            'revenue_growth'   => $this->revenueGrowth(),
        ];
    }

    public function getRevenueChart(): array
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = [
                'month'   => $date->format('M Y'),
                'revenue' => Transaction::where('status', 'completed')
                    ->where('type', 'credit')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('amount'),
            ];
        }
        return $months;
    }

    public function getOrdersByStatus(): array
    {
        return Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    public function getRecentOrders(int $limit = 5)
    {
        return Order::with('customer')->latest()->limit($limit)->get();
    }

    public function getTopCustomers(int $limit = 5)
    {
        return Customer::orderByDesc('total_spent')->limit($limit)->get();
    }

    private function revenueGrowth(): float
    {
        $thisMonth = Transaction::where('status', 'completed')
            ->where('type', 'credit')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        $lastMonth = Transaction::where('status', 'completed')
            ->where('type', 'credit')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('amount');

        if ($lastMonth == 0) return 100;
        return round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1);
    }
}
