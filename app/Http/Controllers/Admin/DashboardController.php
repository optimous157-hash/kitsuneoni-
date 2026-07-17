<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use App\Models\NewsletterSubscriber;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'total_customers' => User::where('role', 'user')->count(),
            'total_reviews' => Review::count(),
            'newsletter_subscribers' => NewsletterSubscriber::active()->count(),
        ];

        $recentOrders = Order::with('items')
            ->latest()
            ->limit(10)
            ->get();

        $recentActivity = ActivityLog::with('user')
            ->latest()
            ->limit(20)
            ->get();

        $driver = \DB::connection()->getDriverName();
        $monthExpr = $driver === 'sqlite'
            ? "CAST(strftime('%m', created_at) AS INTEGER) as month"
            : "DATE_FORMAT(created_at, '%c') as month";
        $yearExpr = $driver === 'sqlite'
            ? "strftime('%Y', created_at) as year"
            : "DATE_FORMAT(created_at, '%Y') as year";

        $monthlyRevenue = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subMonths(12))
            ->selectRaw("{$monthExpr}, {$yearExpr}, SUM(total) as revenue")
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $topProducts = Product::with('category')
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();

        $ordersByStatus = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.dashboard', compact(
            'stats', 'recentOrders', 'recentActivity',
            'monthlyRevenue', 'topProducts', 'ordersByStatus'
        ));
    }
}
