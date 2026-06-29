<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Souk') }} - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet">
</head>
<body class="h-full bg-gray-50">

    {{-- Sidebar --}}
    <aside id="sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-200">
        <div class="h-full px-3 py-4 overflow-y-auto">
            {{-- Logo --}}
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('seller.dashboard') }}"
                class="flex items-center ps-2.5 mb-5">
                <span class="self-center text-xl font-semibold whitespace-nowrap text-blue-700">🛍️ Souk</span>
            </a>

            {{-- Navigation --}}
            <ul class="space-y-2 font-medium">

                {{-- Dashboard Link --}}
                <li>
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('seller.dashboard') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group
                        {{ request()->routeIs(auth()->user()->isAdmin() ? 'admin.dashboard' : 'seller.dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>

                {{-- Admin Links --}}
                @if (auth()->user()->isAdmin())
                    <li>
                        <a href="{{ route('admin.sellers.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group
                            {{ request()->routeIs('admin.sellers.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                            <span class="ms-3">Sellers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group
                            {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                            </svg>
                            <span class="ms-3">Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group
                            {{ request()->routeIs('admin.orders.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ms-3">Orders</span>
                        </a>
                    </li>
                @endif

                {{-- Seller Links --}}
                @if (auth()->user()->isSeller())
                    <li>
                        <a href="{{ route('seller.products.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group
                            {{ request()->routeIs('seller.products.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ms-3">My Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seller.orders.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group
                            {{ request()->routeIs('seller.orders.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ms-3">Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seller.store.edit') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group
                            {{ request()->routeIs('seller.store.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ms-3">Store Profile</span>
                        </a>
                    </li>
                @endif

                {{-- Back to Home --}}
                <li class="pt-4 mt-4 border-t border-gray-200">
                    <a href="{{ route('home') }}"
                        class="flex items-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 group">
                        <svg class="w-5 h-5 text-gray-400 transition duration-75 group-hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ms-3">Back to Site</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div class="sm:ml-64">
        {{-- Top Navbar --}}
        <nav class="bg-white border-b border-gray-200 px-4 py-2.5">
            <div class="flex items-center justify-between">
                {{-- Mobile sidebar toggle --}}
                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar"
                    class="text-gray-500 hover:text-gray-700 focus:outline-none sm:hidden">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                </button>

                {{-- User info --}}
                <div class="flex items-center gap-3 ms-auto">
                    <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-sm text-red-600 hover:text-red-700 font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        {{-- Page Content --}}
        <div class="p-4">
            {{ $slot }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>