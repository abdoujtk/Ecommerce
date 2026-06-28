<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filters --}}
            <div class="mb-4 flex flex-wrap gap-2">
                <a href="{{ route('admin.orders.index') }}"
                    class="px-3 py-1 rounded text-sm {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                    All
                </a>
                @foreach (['pending', 'confirmed', 'delivered', 'rejected'] as $status)
                    <a href="{{ route('admin.orders.index', ['status' => $status]) }}"
                        class="px-3 py-1 rounded text-sm {{ request('status') === $status ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                        {{ ucfirst($status) }}
                    </a>
                @endforeach
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($orders->isEmpty())
                        <p class="text-gray-500 text-center py-8">No orders found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Store</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="px-3 py-2">#{{ $order->id }}</td>
                                            <td class="px-3 py-2">{{ $order->customer_name }}</td>
                                            <td class="px-3 py-2">{{ $order->customer_phone }}</td>
                                            <td class="px-3 py-2 max-w-xs truncate">{{ $order->customer_address }}</td>
                                            <td class="px-3 py-2">{{ $order->product->name }}</td>
                                            <td class="px-3 py-2">{{ $order->store->store_name }}</td>
                                            <td class="px-3 py-2">
                                                <span class="px-2 py-0.5 text-xs rounded-full
                                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $order->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ $order->review ? '⭐' . $order->review->rating : '-' }}
                                            </td>
                                            <td class="px-3 py-2 text-gray-500">{{ $order->created_at->format('M d, H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $orders->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>