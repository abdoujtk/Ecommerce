<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                {{-- Total Sellers --}}
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Sellers</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_sellers'] }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Pending Approvals --}}
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending Approvals</p>
                            <p class="text-3xl font-bold {{ $stats['pending_approvals'] > 0 ? 'text-yellow-600' : 'text-gray-900' }} mt-1">
                                {{ $stats['pending_approvals'] }}
                            </p>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Products --}}
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Products</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_products'] }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Orders --}}
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Orders</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_orders'] }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <a href="{{ route('admin.sellers.index') }}"
                            class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <span class="text-2xl">👥</span>
                            <div>
                                <span class="font-medium text-gray-900">Manage Sellers</span>
                                <p class="text-sm text-gray-500">Approve, ban, or delete</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.categories.index') }}"
                            class="flex items-center gap-3 p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <span class="text-2xl">📁</span>
                            <div>
                                <span class="font-medium text-gray-900">Manage Categories</span>
                                <p class="text-sm text-gray-500">Add, edit, or delete</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.orders.index') }}"
                            class="flex items-center gap-3 p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                            <span class="text-2xl">📦</span>
                            <div>
                                <span class="font-medium text-gray-900">View All Orders</span>
                                <p class="text-sm text-gray-500">Monitor all orders</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>