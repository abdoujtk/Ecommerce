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
                <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50" role="alert">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>⏳ Your store is pending admin approval. Products are hidden until approved.</span>
                </div>
            @endif

            @if ($store)
                {{-- Welcome --}}
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Welcome back, {{ $store->store_name }}!</h3>

                {{-- Stats Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                    <div class="bg-white rounded-lg shadow p-5">
                        <p class="text-sm font-medium text-gray-500">Products</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-5">
                        <p class="text-sm font-medium text-gray-500">Orders This Month</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_orders_this_month'] }}</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-5">
                        <p class="text-sm font-medium text-gray-500">Pending</p>
                        <p class="text-3xl font-bold {{ $stats['pending_orders'] > 0 ? 'text-yellow-600' : 'text-gray-900' }} mt-1">
                            {{ $stats['pending_orders'] }}
                        </p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-5">
                        <p class="text-sm font-medium text-gray-500">Views This Month</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_views_this_month'] }}</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-5">
                        <p class="text-sm font-medium text-gray-500">Sales This Month</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_sales_this_month'] }}</p>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <a href="{{ route('seller.products.index') }}"
                                class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                                <span class="text-2xl">📦</span>
                                <div>
                                    <span class="font-medium text-gray-900">My Products</span>
                                    <p class="text-sm text-gray-500">Manage your catalog</p>
                                </div>
                            </a>
                            <a href="{{ route('seller.orders.index') }}"
                                class="flex items-center gap-3 p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                                <span class="text-2xl">📋</span>
                                <div>
                                    <span class="font-medium text-gray-900">Orders</span>
                                    <p class="text-sm text-gray-500">View and manage orders</p>
                                </div>
                            </a>
                            <a href="{{ route('seller.store.edit') }}"
                                class="flex items-center gap-3 p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                                <span class="text-2xl">🏪</span>
                                <div>
                                    <span class="font-medium text-gray-900">Store Profile</span>
                                    <p class="text-sm text-gray-500">Edit your store info</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    No store found. Please contact support.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>