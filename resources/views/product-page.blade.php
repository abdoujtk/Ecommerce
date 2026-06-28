<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - {{ $product->store->store_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <div class="max-w-lg mx-auto px-4 py-6">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Product Images --}}
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-4">
            @if ($product->mainImage)
                <img src="{{ asset('storage/' . $product->mainImage->image_path) }}"
                    alt="{{ $product->name }}" class="w-full h-64 object-cover">
            @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
            @endif

            {{-- Thumbnail Gallery --}}
            @if ($product->images->count() > 1)
                <div class="flex gap-1 p-2">
                    @foreach ($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                            class="w-12 h-12 object-cover rounded border {{ $image->is_main ? 'border-blue-600' : 'border-gray-300' }}">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <h1 class="text-lg font-bold text-gray-900">{{ $product->name }}</h1>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($product->price) }} DZD</p>

            <div class="flex items-center gap-2 mt-2">
                <span class="text-sm text-gray-500">{{ $product->store->store_name }}</span>
                <span class="text-xs text-gray-400">👁 {{ $product->view_count }} views</span>
            </div>

            <p class="text-sm text-gray-500 mt-1">
                {{ $product->category->parent?->name }} > {{ $product->category->name }}
            </p>

            @if ($product->description)
                <div class="mt-3 text-sm text-gray-700">
                    {{ $product->description }}
                </div>
            @endif

            {{-- Call Button --}}
            <a href="tel:{{ $product->store->phone }}"
                class="mt-4 block w-full text-center bg-green-600 text-white py-2 rounded text-sm font-medium hover:bg-green-700">
                Call Seller: {{ $product->store->phone }}
            </a>
        </div>

        {{-- Order Form --}}
        <div class="bg-white rounded-lg shadow-sm p-4">
            <h2 class="font-semibold text-gray-900 mb-3">Order This Product</h2>
            <form action="{{ route('product.order', $product->unique_link) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Your Name *</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    @error('customer_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Phone Number *</label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    @error('customer_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Delivery Address *</label>
                    <input type="text" name="customer_address" value="{{ old('customer_address') }}" required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    @error('customer_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Note (optional)</label>
                    <textarea name="customer_note" rows="2"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm">{{ old('customer_note') }}</textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded text-sm font-medium hover:bg-blue-700">
                    Place Order (Cash on Delivery)
                </button>
            </form>
        </div>

        {{-- Back to Home --}}
        <div class="mt-4 text-center">
            <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline">Back to Homepage</a>
        </div>
    </div>

</body>
</html>