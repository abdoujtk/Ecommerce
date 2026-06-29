<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Manage Categories') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">{{ session('error') }}</div>
            @endif

            {{-- Add Main Category --}}
            <div class="bg-white rounded-lg shadow mb-4">
                <div class="p-4">
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="flex gap-3 items-end">
                        @csrf
                        <div class="flex-1">
                            <input type="text" name="name" placeholder="New main category..."
                                class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <input type="hidden" name="parent_id" value="">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Add</button>
                    </form>
                </div>
            </div>

            {{-- Categories List --}}
            @foreach ($mainCategories as $mainCategory)
                <div class="bg-white rounded-lg shadow mb-3">
                    <div class="p-4 flex justify-between items-center bg-gray-50 rounded-t-lg border-b">
                        <div>
                            <span class="font-bold text-gray-900">📁 {{ $mainCategory->name }}</span>
                            <span class="text-xs text-gray-500 ml-2">({{ $mainCategory->children->count() }} subcategories)</span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="document.getElementById('edit-main-{{ $mainCategory->id }}').classList.toggle('hidden')"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                            <form action="{{ route('admin.categories.destroy', $mainCategory) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Delete?')">Del</button>
                            </form>
                        </div>
                    </div>

                    <div id="edit-main-{{ $mainCategory->id }}" class="hidden p-4 border-b bg-gray-50">
                        <form action="{{ route('admin.categories.update', $mainCategory) }}" method="POST" class="flex gap-3 items-end">
                            @csrf @method('PUT')
                            <div class="flex-1">
                                <input type="text" name="name" value="{{ $mainCategory->name }}"
                                    class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2.5">Save</button>
                        </form>
                    </div>

                    @foreach ($mainCategory->children as $subcategory)
                        <div class="px-6 py-3 flex justify-between items-center border-b hover:bg-gray-50">
                            <span class="text-sm">↳ {{ $subcategory->name }}</span>
                            <div class="flex gap-2">
                                <button onclick="document.getElementById('edit-sub-{{ $subcategory->id }}').classList.toggle('hidden')"
                                    class="text-blue-600 hover:text-blue-800 text-xs font-medium">Edit</button>
                                <form action="{{ route('admin.categories.destroy', $subcategory) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 text-xs font-medium" onclick="return confirm('Delete?')">Del</button>
                                </form>
                            </div>
                        </div>

                        <div id="edit-sub-{{ $subcategory->id }}" class="hidden px-6 py-3 border-b bg-gray-50">
                            <form action="{{ route('admin.categories.update', $subcategory) }}" method="POST" class="flex gap-3 items-end">
                                @csrf @method('PUT')
                                <div class="flex-1">
                                    <input type="text" name="name" value="{{ $subcategory->name }}"
                                        class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500" required>
                                </div>
                                <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2.5">Save</button>
                            </form>
                        </div>
                    @endforeach

                    <div class="px-6 py-3">
                        <form action="{{ route('admin.categories.store') }}" method="POST" class="flex gap-3 items-end">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $mainCategory->id }}">
                            <div class="flex-1">
                                <input type="text" name="name" placeholder="New subcategory..."
                                    class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <button type="submit" class="text-white bg-gray-600 hover:bg-gray-700 font-medium rounded-lg text-sm px-4 py-2.5">+ Add</button>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>