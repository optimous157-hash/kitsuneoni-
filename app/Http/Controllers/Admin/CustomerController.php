<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(20)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $customer->load(['orders' => fn ($q) => $q->latest()->limit(20), 'orders.items']);
        return view('admin.customers.show', compact('customer'));
    }

    public function toggleStatus(User $customer)
    {
        $customer->update(['is_active' => !$customer->is_active]);
        return back()->with('success', 'Customer status updated.');
    }
}
