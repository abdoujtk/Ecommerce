<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('All Orders') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-wrap gap-2 mb-4">
                @foreach (['' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'delivered' => 'Delivered', 'rejected' => 'Rejected'] as $key => $label)
                    <a href="{{ route('admin.orders.index', $key ? ['status' => $key] : []) }}"
                        class="px-3 py-1.5 text-xs font-medium rounded-full {{ request('status') === $key || (!request('status') && $key === '') ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    @if ($orders->isEmpty())
                        <p class="text-gray-500 text-center py-8">No orders found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-3">#</th>
                                        <th class="px-3 py-3">Customer</th>
                                        <th class="px-3 py-3">Phone</th>
                                        <th class="px-3 py-3">Product</th>
                                        <th class="px-3 py-3">Store</th>
                                        <th class="px-3 py-3">Status</th>
                                        <th class="px-3 py-3">Rating</th>
                                        <th class="px-3 py-3">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($orders as $order)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-3 font-medium">#{{ $order->id }}</td>
                                            <td class="px-3 py-3">{{ $order->customer_name }}</td>
                                            <td class="px-3 py-3">{{ $order->customer_phone }}</td>
                                            <td class="px-3 py-3">{{ $order->product->name }}</td>
                                            <td class="px-3 py-3">{{ $order->store->store_name }}</td>
                                            <td class="px-3 py-3">
                                                <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                    {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : '' }}
                                                    {{ $order->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3">{{ $order->review ? '⭐' . $order->review->rating : '-' }}</td>
                                            <td class="px-3 py-3">{{ $order->created_at->format('M d, H:i') }}</td>
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