<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Products') }}
            </h2>
            <a href="{{ route('seller.products.create') }}"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                + Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    @if ($products->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-gray-400 text-lg mb-2">📦</p>
                            <p class="text-gray-500">No products yet. Add your first product!</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3">Image</th>
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">Category</th>
                                        <th class="px-4 py-3">Price</th>
                                        <th class="px-4 py-3">Views</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($products as $product)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                @if ($product->mainImage)
                                                    <img src="{{ asset('storage/' . $product->mainImage->image_path) }}"
                                                        class="w-10 h-10 object-cover rounded">
                                                @else
                                                    <div class="w-10 h-10 bg-gray-200 rounded"></div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $product->name }}</td>
                                            <td class="px-4 py-3">{{ $product->category->parent?->name }} > {{ $product->category->name }}</td>
                                            <td class="px-4 py-3 font-medium">{{ number_format($product->price) }} DZD</td>
                                            <td class="px-4 py-3">{{ $product->view_count }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                    {{ $product->is_active ? 'Active' : 'Hidden' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex gap-1">
                                                    <button onclick="copyToClipboard('{{ url('/p/' . $product->unique_link) }}')"
                                                        class="text-blue-600 hover:text-blue-800 text-xs font-medium">Copy</button>
                                                    <a href="{{ route('seller.products.edit', $product) }}" class="text-green-600 hover:text-green-800 text-xs font-medium">Edit</a>
                                                    <form action="{{ route('seller.products.toggle-active', $product) }}" method="POST">
                                                        @csrf
                                                        <button class="text-yellow-600 hover:text-yellow-800 text-xs font-medium">
                                                            {{ $product->is_active ? 'Hide' : 'Show' }}
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="text-red-600 hover:text-red-800 text-xs font-medium"
                                                            onclick="return confirm('Delete this product?')">Del</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $products->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            var textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            try { document.execCommand('copy'); alert('Link copied!'); }
            catch (err) { alert('Link: ' + text); }
            document.body.removeChild(textarea);
        }
    </script>
</x-app-layout>