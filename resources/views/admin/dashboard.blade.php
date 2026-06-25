<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                {{-- Total Sellers --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500">Total Sellers</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_sellers'] }}</p>
                    </div>
                </div>

                {{-- Pending Approvals --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500">Pending Approvals</h3>
                        <p class="text-3xl font-bold {{ $stats['pending_approvals'] > 0 ? 'text-yellow-600' : 'text-gray-900' }}">
                            {{ $stats['pending_approvals'] }}
                        </p>
                    </div>
                </div>

                {{-- Total Products --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500">Total Products</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                    </div>
                </div>

                {{-- Total Orders --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500">Total Orders</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="#" class="block p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <span class="text-lg">👥</span>
                            <span class="font-medium">Manage Sellers</span>
                            <p class="text-sm text-gray-500 mt-1">Approve, ban, or delete sellers</p>
                        </a>

                        <a href="{{ route('admin.categories.index') }}" class="block p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <span class="text-lg">📁</span>
                            <span class="font-medium">Manage Categories</span>
                            <p class="text-sm text-gray-500 mt-1">Add, edit, or delete categories</p>
                        </a>

                        <a href="#" class="block p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                            <span class="text-lg">📦</span>
                            <span class="font-medium">View All Orders</span>
                            <p class="text-sm text-gray-500 mt-1">Monitor all orders across stores</p>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>