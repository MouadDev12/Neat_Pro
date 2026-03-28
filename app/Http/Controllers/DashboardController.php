<?php

namespace App\Http\Controllers;

use App\Services\DashboardStatsService;

class DashboardController extends Controller
{
    public function __construct(private DashboardStatsService $stats) {}

    public function index()
    {
        return view('dashboard.index', [
            'stats'          => $this->stats->getStats(),
            'revenueChart'   => $this->stats->getRevenueChart(),
            'ordersByStatus' => $this->stats->getOrdersByStatus(),
            'recentOrders'   => $this->stats->getRecentOrders(),
            'topCustomers'   => $this->stats->getTopCustomers(),
        ]);
    }
}
