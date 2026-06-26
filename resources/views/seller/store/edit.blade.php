<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Store Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Store Name --}}
                        <div class="mb-4">
                            <x-input-label for="store_name" value="Store Name" />
                            <x-text-input id="store_name" name="store_name" type="text" class="mt-1 block w-full"
                                :value="old('store_name', $store->store_name)" required />
                            <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
                        </div>

                        {{-- Phone --}}
                        <div class="mb-4">
                            <x-input-label for="phone" value="Phone Number (visible to customers)" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                :value="old('phone', $store->phone)" required />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        {{-- Current Image --}}
                        @if ($store->image)
                            <div class="mb-4">
                                <x-input-label value="Current Store Image" />
                                <img src="{{ asset('storage/' . $store->image) }}" alt="Store Image"
                                    class="w-32 h-32 object-cover rounded mt-1">
                            </div>
                        @endif

                        {{-- New Image --}}
                        <div class="mb-4">
                            <x-input-label for="image" value="New Store Image (optional)" />
                            <input id="image" name="image" type="file" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Save Changes
                            </button>
                            <a href="{{ route('seller.dashboard') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>