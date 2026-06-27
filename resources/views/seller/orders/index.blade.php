<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filters --}}
            <div class="mb-4 flex gap-2">
                <a href="{{ route('seller.orders.index') }}"
                    class="px-3 py-1 rounded text-sm {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    All
                </a>
                <a href="{{ route('seller.orders.index', ['status' => 'pending']) }}"
                    class="px-3 py-1 rounded text-sm {{ request('status') === 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Pending
                </a>
                <a href="{{ route('seller.orders.index', ['status' => 'confirmed']) }}"
                    class="px-3 py-1 rounded text-sm {{ request('status') === 'confirmed' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Confirmed
                </a>
                <a href="{{ route('seller.orders.index', ['status' => 'delivered']) }}"
                    class="px-3 py-1 rounded text-sm {{ request('status') === 'delivered' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Delivered
                </a>
                <a href="{{ route('seller.orders.index', ['status' => 'rejected']) }}"
                    class="px-3 py-1 rounded text-sm {{ request('status') === 'rejected' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Rejected
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($orders->isEmpty())
                        <p class="text-gray-500 text-center py-8">No orders found.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="px-3 py-3 text-sm">#{{ $order->id }}</td>
                                        <td class="px-3 py-3 text-sm">{{ $order->customer_name }}</td>
                                        <td class="px-3 py-3 text-sm">{{ $order->customer_phone }}</td>
                                        <td class="px-3 py-3 text-sm max-w-xs truncate">{{ $order->customer_address }}</td>
                                        <td class="px-3 py-3 text-sm">{{ $order->product->name }}</td>
                                        <td class="px-3 py-3 text-sm">{{ number_format($order->product->price) }} DZD</td>
                                        <td class="px-3 py-3">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3 text-sm text-gray-500">{{ $order->created_at->format('M d') }}</td>
                                        <td class="px-3 py-3 text-sm">
                                            <div class="flex gap-1">
                                                @if ($order->status === 'pending')
                                                    <form action="{{ route('seller.orders.confirm', $order) }}" method="POST">
                                                        @csrf
                                                        <button class="text-green-600 hover:text-green-900 text-xs">Confirm</button>
                                                    </form>
                                                    <form action="{{ route('seller.orders.reject', $order) }}" method="POST">
                                                        @csrf
                                                        <button class="text-red-600 hover:text-red-900 text-xs"
                                                            onclick="return confirm('Reject this order?')">Reject</button>
                                                    </form>
                                                @endif
                                                @if ($order->status === 'confirmed')
                                                    <form action="{{ route('seller.orders.mark-delivered', $order) }}" method="POST">
                                                        @csrf
                                                        <button class="text-blue-600 hover:text-blue-900 text-xs"
                                                            onclick="return confirm('Mark as delivered? A rating link will be generated.')">
                                                            Mark Delivered
                                                        </button>
                                                    </form>
                                                @endif
                                                @if ($order->rating_code && $order->review)
                                                    <span class="text-xs text-gray-500">⭐ {{ $order->review->rating }}</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">{{ $orders->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>