<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
                        @csrf
                        {{-- Show all errors --}}
                        @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    @if (is_string($error))
                                        <li>{{ $error }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                        {{-- Name --}}
                        <div class="mb-4">
                            <x-input-label for="name" value="Product Name" />
                            <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Price --}}
                        <div class="mb-4">
                            <x-input-label for="price" value="Price (DZD)" />
                            <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full"
                                :value="old('price')" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        {{-- Category --}}
                        <div class="mb-4">
                            <x-input-label for="category_id" value="Category" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                @foreach ($mainCategories as $main)
                                    <optgroup label="{{ $main->name }}">
                                        @foreach ($main->children as $sub)
                                            <option value="{{ $sub->id }}" {{ old('category_id') == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                      {{-- Images --}}
<div class="mb-4">
    <x-input-label value="Images (first image will be the main image)" />
    <div id="image-preview" class="flex gap-2 mt-2 mb-2 flex-wrap"></div>
    <input id="images" name="images[]" type="file" multiple accept="image/*" required
        onchange="previewImages(event)"
        class="mt-1 block w-full text-sm text-gray-500
        file:mr-4 file:py-2 file:px-4
        file:rounded file:border-0
        file:text-sm file:font-semibold
        file:bg-blue-50 file:text-blue-700" />
    
    
</div>

                        <div class="flex gap-4">
                            <button type="submit" id="submit-btn"
                                class="cursor-pointer relative z-10 w-full sm:w-auto text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-6 py-3 text-center">
                                <span id="btn-text">Create Product</span>
                                <span id="btn-loading" class="hidden">
                                    <svg class="inline w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Uploading...
                                </span>
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

    <script>
        function previewImages(event) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';
            for (let file of event.target.files) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'w-16 h-16 object-cover rounded border';
                preview.appendChild(img);
            }
        }

        const form = document.getElementById('product-form');
        const btn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnLoading = document.getElementById('btn-loading');

        form.addEventListener('submit', function() {
            btn.disabled = true;
            btn.classList.add('opacity-50');
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
        });
    </script>
</x-app-layout>