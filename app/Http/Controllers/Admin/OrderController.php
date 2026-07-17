<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_email', 'LIKE', "%{$search}%");
            });
        }

        if ($dateFrom = $request->input('date_from')) {
            $query->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->where('created_at', '<=', $dateTo . ' 23:59:59');
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total' => Order::count(),
            'pending' => Order::pending()->count(),
            'confirmed' => Order::confirmed()->count(),
            'processing' => Order::processing()->count(),
            'delivered' => Order::delivered()->count(),
            'cancelled' => Order::cancelled()->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        match($newStatus) {
            'confirmed' => $order->markAsConfirmed(),
            'processing' => $order->markAsProcessing(),
            'delivered' => $order->markAsDelivered(),
            'cancelled' => $order->markAsCancelled(),
            default => $order->update(['status' => $newStatus]),
        };

        ActivityLog::log(
            'order_status_changed',
            "Order #{$order->reference_number} status changed from {$oldStatus} to {$newStatus}",
            ['order_id' => $order->id, 'old_status' => $oldStatus, 'new_status' => $newStatus]
        );

        return back()->with('success', "Order status updated to {$newStatus}.");
    }

    public function export(Request $request)
    {
        $query = Order::with('items');

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($dateFrom = $request->input('date_from')) {
            $query->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->where('created_at', '<=', $dateTo . ' 23:59:59');
        }

        $orders = $query->latest()->get();

        $filename = 'orders_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Reference', 'Status', 'Customer Name', 'Email', 'Phone',
                'Country', 'City', 'Address', 'Items', 'Subtotal',
                'Shipping', 'Total', 'Notes', 'Created At',
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->reference_number,
                    $order->status,
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->customer_country,
                    $order->customer_city,
                    $order->customer_address,
                    $order->items->pluck('product_name')->implode(', '),
                    $order->subtotal,
                    $order->shipping_cost,
                    $order->total,
                    $order->notes,
                    $order->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
