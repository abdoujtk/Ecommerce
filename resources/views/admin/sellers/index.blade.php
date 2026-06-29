<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Sellers') }}
        </h2>
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
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Seller</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registered</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($sellers as $seller)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $seller->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $seller->store?->store_name ?? 'No store' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $seller->phone }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($seller->is_banned)
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Banned</span>
                                            @elseif ($seller->is_approved)
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $seller->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex space-x-2">
                                                @if (!$seller->is_approved && !$seller->is_banned)
                                                    <form action="{{ route('admin.sellers.approve', $seller) }}" method="POST">
                                                        @csrf
                                                        <button class="text-green-600 hover:text-green-900 font-medium">Approve</button>
                                                    </form>
                                                @endif
                                                @if (!$seller->is_banned)
                                                    <form action="{{ route('admin.sellers.ban', $seller) }}" method="POST">
                                                        @csrf
                                                        <button class="text-yellow-600 hover:text-yellow-900 font-medium"
                                                            onclick="return confirm('Ban this seller?')">Ban</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.sellers.unban', $seller) }}" method="POST">
                                                        @csrf
                                                        <button class="text-blue-600 hover:text-blue-900 font-medium">Unban</button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.sellers.destroy', $seller) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-red-600 hover:text-red-900 font-medium"
                                                        onclick="return confirm('DELETE this seller and ALL their data?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $sellers->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>