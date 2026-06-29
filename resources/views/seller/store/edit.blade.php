<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Store Profile') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Store Name</label>
                            <input type="text" name="store_name" value="{{ old('store_name', $store->store_name) }}"
                                class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500" required>
                            @error('store_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Phone Number (visible to customers)</label>
                            <input type="text" name="phone" value="{{ old('phone', $store->phone) }}"
                                class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500" required>
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        @if ($store->image)
                            <div class="mb-5">
                                <label class="block mb-2 text-sm font-medium text-gray-700">Current Image</label>
                                <img src="{{ asset('storage/' . $store->image) }}" class="w-24 h-24 object-cover rounded-lg border">
                            </div>
                        @endif

                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-medium text-gray-700">New Image (optional)</label>
                            <input type="file" name="image" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                Save Changes
                            </button>
                            <a href="{{ route('seller.dashboard') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>