<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Show warning if not approved --}}
            @if (!auth()->user()->is_approved)
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                    ⏳ Your store is pending admin approval. You can add products, but they won't be visible to the public yet.
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h3>
                    <p>This is your store dashboard.</p>
                    {{-- We'll add stats and links later --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>