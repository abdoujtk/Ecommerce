{{-- Souk Marketplace --}}
<x-guest-layout title="Souk - Marketplace">
    {{-- Search --}}
    <form action="{{ route('home') }}" method="GET" class="mb-6">
        <div class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products or stores..."
                   class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Search</button>
        </div>
    </form>

    {{-- Categories --}}
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('home') }}" class="px-3 py-1.5 text-xs font-medium rounded-full {{ !request('category') ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">All</a>
        @foreach ($categories as $cat)
            <a href="{{ route('home', ['category' => $cat->id]) }}" class="px-3 py-1.5 text-xs font-medium rounded-full {{ request('category') == $cat->id ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">{{ $cat->name }}</a>
        @endforeach
    </div>

    {{-- Products Grid --}}
    @if ($products->isEmpty())
        <p class="text-gray-500 text-center py-12">No products found.</p>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($products as $product)
                <a href="{{ url('/p/' . $product->unique_link) }}" class="block bg-white rounded-lg shadow hover:shadow-md transition">
                    <div class="h-40 bg-gray-100 rounded-t-lg overflow-hidden">
                        @if ($product->mainImage)
                            <img src="{{ asset('storage/' . $product->mainImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">No Image</div>
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                        <p class="text-lg font-bold text-blue-700">{{ number_format($product->price) }} DZD</p>
                        <p class="text-xs text-gray-500 truncate">{{ $product->store->store_name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    @endif
</x-guest-layout>