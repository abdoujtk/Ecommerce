<x-guest-layout title="{{ $product->name }} - {{ $product->store->store_name }}">
    <div class="max-w-lg mx-auto">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>{{ session('success') }}</span>
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

            @if ($product->images->count() > 1)
                <div class="flex gap-1 p-2 overflow-x-auto">
                    @foreach ($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                            class="w-14 h-14 object-cover rounded border {{ $image->is_main ? 'border-blue-600' : 'border-gray-300' }} flex-shrink-0">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product Info Card --}}
        <div class="bg-white rounded-lg shadow-sm p-5 mb-4">
            <h1 class="text-xl font-bold text-gray-900">{{ $product->name }}</h1>
            <p class="text-3xl font-bold text-blue-700 mt-2">{{ number_format($product->price) }} DZD</p>

            <div class="flex items-center gap-3 mt-3 text-sm text-gray-500">
                <span class="font-medium text-gray-700">{{ $product->store->store_name }}</span>
                <span>👁 {{ $product->view_count }} views</span>
            </div>

            <p class="text-xs text-gray-400 mt-1">
                {{ $product->category->parent?->name }} > {{ $product->category->name }}
            </p>

            @if ($product->description)
                <div class="mt-4 text-sm text-gray-600 leading-relaxed">
                    {{ $product->description }}
                </div>
            @endif

            {{-- Call Button --}}
            <a href="tel:{{ $product->store->phone }}"
                class="mt-5 flex items-center justify-center gap-2 w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-3">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                Call {{ $product->store->phone }}
            </a>
        </div>

        {{-- Order Form Card --}}
        <div class="bg-white rounded-lg shadow-sm p-5">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">📝 Order This Product</h2>
            <form action="{{ route('product.order', $product->unique_link) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Your Name *</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                        class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                    @error('customer_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Phone Number *</label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required
                        class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                    @error('customer_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Delivery Address *</label>
                    <textarea name="customer_address" rows="2" required
                        class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">{{ old('customer_address') }}</textarea>
                    @error('customer_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-5">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Note (optional)</label>
                    <textarea name="customer_note" rows="2"
                        class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">{{ old('customer_note') }}</textarea>
                </div>

                <button type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3">
                    📦 Place Order (Cash on Delivery)
                </button>
            </form>
        </div>

        {{-- Back link --}}
        <div class="mt-4 text-center">
            <a href="{{ route('home') }}" class="text-sm text-blue-700 hover:underline">← Back to Homepage</a>
        </div>

    </div>
</x-guest-layout>