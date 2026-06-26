<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Products') }} 
            </h2>
            <a href="{{ route('seller.products.create') }}"
            class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
            + Add Product
        </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($products->isEmpty())
                        <p class="text-gray-500 text-center py-8">No products yet. Add your first product!</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="px-4 py-3">
                                            @if ($product->mainImage)
                                                <img src="{{ asset('storage/' . $product->mainImage->image_path) }}"
                                                    class="w-12 h-12 object-cover rounded">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded"></div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-medium">{{ $product->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ $product->category->parent?->name }} > {{ $product->category->name }}
                                        </td>
                                        <td class="px-4 py-3">{{ number_format($product->price) }} DZD</td>
                                        <td class="px-4 py-3">{{ $product->view_count }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->is_active ? 'Active' : 'Hidden' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-2 text-sm">
                                                <button onclick="copyToClipboard('{{ url('/p/' . $product->unique_link) }}')"
                                                    class="text-blue-600 hover:text-blue-900">Copy Link</button>
                                                <a href="{{ route('seller.products.edit', $product) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                                <form action="{{ route('seller.products.toggle-active', $product) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                        {{ $product->is_active ? 'Hide' : 'Show' }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Delete this product?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">{{ $products->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            // Fallback for all browsers
            var textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                alert('Link copied!');
            } catch (err) {
                alert('Failed to copy. Link: ' + text);
            }
            document.body.removeChild(textarea);
        }
    </script>
</x-app-layout>