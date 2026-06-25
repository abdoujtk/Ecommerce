<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Add Main Category Form --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Add Main Category</h3>
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="flex gap-4 items-end">
                            <div class="flex-1">
                                <x-input-label for="name" value="Category Name" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Add
                            </button>
                        </div>
                        <input type="hidden" name="parent_id" value="">
                    </form>
                </div>
            </div>

            {{-- Categories List --}}
            @foreach ($mainCategories as $mainCategory)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    {{-- Main Category --}}
                    <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                        <div>
                            <span class="font-bold text-lg">📁 {{ $mainCategory->name }}</span>
                            <span class="text-sm text-gray-500 ml-2">
                                ({{ $mainCategory->children->count() }} subcategories)
                            </span>
                        </div>
                        <div class="flex gap-2">
                            {{-- Edit Main Category Button --}}
                            <button onclick="document.getElementById('edit-main-{{ $mainCategory->id }}').classList.toggle('hidden')"
                                class="text-blue-600 hover:text-blue-900 text-sm">
                                Edit
                            </button>

                            {{-- Delete Main Category --}}
                            <form action="{{ route('admin.categories.destroy', $mainCategory) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm"
                                    onclick="return confirm('Delete this category?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Edit Main Category Form (hidden by default) --}}
                    <div id="edit-main-{{ $mainCategory->id }}" class="hidden p-4 bg-gray-50 border-b">
                        <form action="{{ route('admin.categories.update', $mainCategory) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="flex gap-4 items-end">
                                <div class="flex-1">
                                    <x-text-input name="name" type="text" class="mt-1 block w-full" value="{{ $mainCategory->name }}" required />
                                </div>
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Subcategories --}}
                    @foreach ($mainCategory->children as $subcategory)
                        <div class="p-3 pl-10 border-b flex justify-between items-center">
                            <span>↳ {{ $subcategory->name }}</span>
                            <div class="flex gap-2">
                                {{-- Edit Subcategory --}}
                                <button onclick="document.getElementById('edit-sub-{{ $subcategory->id }}').classList.toggle('hidden')"
                                    class="text-blue-600 hover:text-blue-900 text-sm">
                                    Edit
                                </button>

                                {{-- Delete Subcategory --}}
                                <form action="{{ route('admin.categories.destroy', $subcategory) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm"
                                        onclick="return confirm('Delete this subcategory?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Edit Subcategory Form (hidden by default) --}}
                        <div id="edit-sub-{{ $subcategory->id }}" class="hidden p-3 pl-10 bg-gray-50 border-b">
                            <form action="{{ route('admin.categories.update', $subcategory) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="flex gap-4 items-end">
                                    <div class="flex-1">
                                        <x-text-input name="name" type="text" class="mt-1 block w-full" value="{{ $subcategory->name }}" required />
                                    </div>
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    {{-- Add Subcategory Form --}}
                    <div class="p-3 pl-10">
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $mainCategory->id }}">
                            <div class="flex gap-4 items-end">
                                <div class="flex-1">
                                    <x-text-input name="name" type="text" class="mt-1 block w-full" placeholder="New subcategory name..." required />
                                </div>
                                <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
                                    + Add Subcategory
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>