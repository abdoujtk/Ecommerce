<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" value="Product Name" />
                            <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $product->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="price" value="Price (DZD)" />
                            <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full"
                                :value="old('price', $product->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="category_id" value="Category" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                @foreach ($mainCategories as $main)
                                    <optgroup label="{{ $main->name }}">
                                        @foreach ($main->children as $sub)
                                            <option value="{{ $sub->id }}"
                                                {{ old('category_id', $product->category_id) == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        @if ($product->images->count() > 0)
                            <div class="mb-4">
                                <x-input-label value="Current Images" />
                                <div class="flex gap-2 mt-1">
                                    @foreach ($product->images as $image)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                class="w-24 h-24 object-cover rounded border">
                                            @if ($image->is_main)
                                                <span class="absolute top-0 left-0 bg-blue-600 text-white text-xs px-1 rounded-br">Main</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-4">
                            <x-input-label for="images" value="Add More Images (optional)" />
                            <input id="images" name="images[]" type="file" multiple accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700" />
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                Update Product
                            </button>
                            <a href="{{ route('seller.products.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>