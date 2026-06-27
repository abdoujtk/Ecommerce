<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Souk') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    {{-- Header --}}
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900">Souk</a>
            <div class="flex gap-3">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Seller Login</a>
                <a href="{{ route('register') }}" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Start Selling</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
        {{-- Search --}}
        <form action="{{ route('home') }}" method="GET" class="mb-4">
            <div class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products or stores..."
                    class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Search</button>
            </div>
        </form>

        {{-- Category Filters --}}
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('home') }}"
                class="px-3 py-1 rounded-full text-sm {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                All
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('home', ['category' => $cat->id]) }}"
                    class="px-3 py-1 rounded-full text-sm {{ request('category') == $cat->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

{{-- Product Grid --}}
@if ($products->isEmpty())
    <p class="text-gray-500 text-center py-12">No products found.</p>
@else
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
        @foreach ($products as $product)
            <a href="{{ url('/p/' . $product->unique_link) }}"
                class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                {{-- Image --}}
                <div class="bg-gray-100" style="height: 140px;">
                    @if ($product->mainImage)
                        <img src="{{ asset('storage/' . $product->mainImage->image_path) }}"
                            alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                    @endif
                </div>
                {{-- Info --}}
                <div class="p-2">
                    <h3 class="text-xs font-medium text-gray-900 truncate">{{ $product->name }}</h3>
                    <p class="text-sm font-bold text-gray-900 mt-0.5">{{ number_format($product->price) }} DZD</p>
                    <p class="text-xs text-gray-400 truncate mt-0.5">{{ $product->store->store_name }}</p>
                </div>
            </a>
        @endforeach
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
@endif
    </main>
</body>
</html>