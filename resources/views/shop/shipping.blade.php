@extends('layouts.app')

@section('title', 'Shipping & Delivery — Kitsuneoni')
@section('description', 'Kitsuneoni ships worldwide via DHL, FedEx, EMS, and SDEK. Free shipping on orders over $500. Learn about our shipping policies, timelines, and rates.')
@section('og_title', 'Shipping & Delivery — Kitsuneoni')
@section('og_description', 'Kitsuneoni ships worldwide via DHL, FedEx, EMS, and SDEK. Free shipping on orders over $500.')

@section('content')

<section class="py-20">
    <div class="container-premium max-w-3xl">
        <h1 class="text-3xl md:text-4xl font-display font-bold text-yamagata-black dark:text-white mb-8">Shipping & Delivery</h1>

        <div class="space-y-8">
            <div class="card-premium p-8">
                <h2 class="text-xl font-semibold text-yamagata-black dark:text-white mb-4">Domestic (CIS)</h2>
                <p class="text-yamagata-silver mb-4">We ship within CIS countries using reliable carriers:</p>
                <ul class="space-y-2 text-yamagata-silver">
                    <li>• CDEK, Russian Post, Yandex Delivery</li>
                    <li>• Delivery time: 3-7 business days</li>
                    <li>• Free shipping on orders</li>
                </ul>
            </div>

            <div class="card-premium p-8">
                <h2 class="text-xl font-semibold text-yamagata-black dark:text-white mb-4">International</h2>
                <p class="text-yamagata-silver mb-4">We deliver worldwide using premium carriers:</p>
                <ul class="space-y-2 text-yamagata-silver">
                    <li>• DHL / UPS</li>
                    <li>• Delivery time: 7-21 business days</li>
                    <li>• Flat rate shipping: $25</li>
                    <li>• Tracking provided for all shipments</li>
                </ul>
            </div>

            <div class="card-premium p-8">
                <h2 class="text-xl font-semibold text-yamagata-black dark:text-white mb-4">Packaging</h2>
                <p class="text-yamagata-silver">Every piece is carefully packaged in a premium gift case with maintenance oil and display stand where applicable. We ensure your order arrives in perfect condition.</p>
            </div>
        </div>
    </div>
</section>

@endsection
