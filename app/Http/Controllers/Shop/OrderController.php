<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderConfirmationMail;
use App\Mail\AdminOrderNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $product = null;
        $products = Product::active()->inStock()->with(['images', 'category'])->ordered()->get();

        if ($productId = $request->input('product_id')) {
            $product = Product::active()->inStock()->with(['images', 'category'])->find($productId);
        }

        return view('shop.order', compact('product', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_country' => 'required|string|max:100',
            'customer_city' => 'required|string|max:100',
            'customer_address' => 'required|string|max:500',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10',
            'variant_id' => 'nullable|exists:product_variants,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $quantity = (int) $validated['quantity'];

        return DB::transaction(function () use ($validated, $request, $quantity) {
            $product = Product::active()
                ->inStock()
                ->with(['images', 'variants' => fn ($q) => $q->where('is_active', true)])
                ->lockForUpdate()
                ->findOrFail($validated['product_id']);

            if ($product->stock < $quantity) {
                throw new \Illuminate\Validation\ValidationException(
                    \Illuminate\Support\Facades\Validator::make([], [
                        'quantity' => ['Insufficient stock. Only ' . $product->stock . ' available.'],
                    ])
                );
            }

            $unitPrice = $product->price;
            $variant = null;
            if (!empty($validated['variant_id'])) {
                $variant = $product->variants->firstWhere('id', $validated['variant_id']);
                if ($variant) {
                    $unitPrice += $variant->price_modifier;
                }
            }

            $subtotal = $unitPrice * $quantity;
            $shippingCost = $this->calculateShipping($validated['customer_country']);
            $total = $subtotal + $shippingCost;

            $primaryImage = $product->images->firstWhere('is_primary', true)
                ?? $product->images->first();

            $order = Order::create([
                'reference_number' => 'YO-' . strtoupper(Str::random(8)),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_country' => $validated['customer_country'],
                'customer_city' => $validated['customer_city'],
                'customer_address' => $validated['customer_address'],
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'notes' => $validated['notes'] ?? null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'pending',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_slug' => $product->slug,
                'product_image' => $primaryImage?->path,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $subtotal,
                'variant' => $variant?->value,
            ]);

            $product->decrement('stock', $quantity);
            $product->increment('sales_count', $quantity);

            try {
                Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                \Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }

            try {
                Mail::to(config('site.contact.email'))->send(new AdminOrderNotificationMail($order));
            } catch (\Exception $e) {
                \Log::error('Failed to send admin order notification: ' . $e->getMessage());
            }

            return redirect()->route('order.success', $order->reference_number)
                ->with('success', 'Your order has been placed successfully!');
        });
    }

    public function success(string $referenceNumber)
    {
        $order = Order::where('reference_number', $referenceNumber)
            ->with('items.product')
            ->firstOrFail();

        return view('shop.order-success', compact('order'));
    }

    private function calculateShipping(string $country): float
    {
        $cisCountries = ['RU', 'BY', 'KZ', 'UA', 'UZ', 'KG', 'TJ', 'AM', 'AZ', 'MD', 'GE'];
        $countryCode = strtoupper(substr($country, 0, 2));

        if (in_array($countryCode, $cisCountries)) {
            return 0;
        }

        return 25.00;
    }
}
