<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Warning if not approved --}}
            @if (!auth()->user()->is_approved)
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                    ⏳ Your store is pending admin approval. You can add products, but they won't be visible to the public yet.
                </div>
            @endif

            @if ($store)
                {{-- Welcome --}}
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Welcome back, {{ $store->store_name }}!</h3>
                </div>

                {{-- Stats Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4">
                            <h4 class="text-sm font-medium text-gray-500">Total Products</h4>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4">
                            <h4 class="text-sm font-medium text-gray-500">Orders This Month</h4>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders_this_month'] }}</p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4">
                            <h4 class="text-sm font-medium text-gray-500">Pending Orders</h4>
                            <p class="text-2xl font-bold {{ $stats['pending_orders'] > 0 ? 'text-yellow-600' : 'text-gray-900' }}">
                                {{ $stats['pending_orders'] }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4">
                            <h4 class="text-sm font-medium text-gray-500">Views This Month</h4>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_views_this_month'] }}</p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4">
                            <h4 class="text-sm font-medium text-gray-500">Sales This Month</h4>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_sales_this_month'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- <a href="{{ route('seller.products.index') }}" class="block p-4 bg-blue-50 rounded-lg hover:bg-blue-100">
                                📦 My Products
                            </a> --}}
                            {{-- <a href="{{ route('seller.orders.index') }}" class="block p-4 bg-green-50 rounded-lg hover:bg-green-100">
                                📋 Orders
                            </a> --}}
                            <a href="{{ route('seller.store.edit') }}" class="block p-4 bg-purple-50 rounded-lg hover:bg-purple-100">
                                🏪 Store Profile
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p>No store found. Please contact support.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>