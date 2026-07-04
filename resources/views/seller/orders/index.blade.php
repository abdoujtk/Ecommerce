<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filters --}}
            <div class="flex flex-wrap gap-1.5 mb-4">
                <a href="{{ route('seller.orders.index') }}"
                    class="px-2.5 py-1 rounded text-xs font-medium {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    All
                </a>
                <a href="{{ route('seller.orders.index', ['status' => 'pending']) }}"
                    class="px-2.5 py-1 rounded text-xs font-medium {{ request('status') === 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Pending
                </a>
                <a href="{{ route('seller.orders.index', ['status' => 'confirmed']) }}"
                    class="px-2.5 py-1 rounded text-xs font-medium {{ request('status') === 'confirmed' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Confirmed
                </a>
                <a href="{{ route('seller.orders.index', ['status' => 'delivered']) }}"
                    class="px-2.5 py-1 rounded text-xs font-medium {{ request('status') === 'delivered' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Delivered
                </a>
                <a href="{{ route('seller.orders.index', ['status' => 'rejected']) }}"
                    class="px-2.5 py-1 rounded text-xs font-medium {{ request('status') === 'rejected' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Rejected
                </a>
            </div>

            @if ($orders->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    No orders found.
                </div>
            @else
                {{-- Mobile: Card view --}}
                <div class="sm:hidden space-y-3">
                    @foreach ($orders as $order)
                        <div class="bg-white rounded-lg shadow p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="font-bold text-sm">#{{ $order->id }}</span>
                                    <span class="text-xs text-gray-500 ml-2">{{ $order->created_at->format('M d') }}</span>
                                </div>
                                <span class="px-2 py-0.5 text-xs rounded-full
                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $order->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <div class="text-sm space-y-1 mb-3">
                                <p><span class="text-gray-500">Customer:</span> {{ $order->customer_name }}</p>
                                <p><span class="text-gray-500">Phone:</span> <a href="tel:{{ $order->customer_phone }}" class="text-blue-600">{{ $order->customer_phone }}</a></p>
                                <p><span class="text-gray-500">Address:</span> {{ $order->customer_address }}</p>
                                <p><span class="text-gray-500">Product:</span> {{ $order->product->name }}</p>
                                <p><span class="text-gray-500">Price:</span> <strong>{{ number_format($order->product->price) }} DZD</strong></p>
                                @if ($order->review)
                                    <p><span class="text-gray-500">Rating:</span> ⭐{{ $order->review->rating }}</p>
                                @endif
                            </div>

                            <div class="flex gap-2">
                                @if ($order->status === 'pending')
                                    <form action="{{ route('seller.orders.confirm', $order) }}" method="POST">
                                        @csrf
                                        <button class="w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded text-xs px-3 py-1.5">Confirm</button>
                                    </form>
                                    <form action="{{ route('seller.orders.reject', $order) }}" method="POST">
                                        @csrf
                                        <button class="w-full text-white bg-red-600 hover:bg-red-700 font-medium rounded text-xs px-3 py-1.5" onclick="return confirm('Reject?')">Reject</button>
                                    </form>
                                @endif
                                @if ($order->status === 'confirmed')
                                    <form action="{{ route('seller.orders.mark-delivered', $order) }}" method="POST" class="w-full">
                                        @csrf
                                        <button class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded text-xs px-3 py-1.5" onclick="return confirm('Mark delivered?')">Mark Delivered</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Desktop: Table view --}}
                <div class="hidden sm:block bg-white rounded-lg shadow">
                    <div class="p-6">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
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
                                        <td class="px-3 py-3">#{{ $order->id }}</td>
                                        <td class="px-3 py-3">{{ $order->customer_name }}</td>
                                        <td class="px-3 py-3">{{ $order->customer_phone }}</td>
                                        <td class="px-3 py-3 max-w-xs truncate">{{ $order->customer_address }}</td>
                                        <td class="px-3 py-3">{{ $order->product->name }}</td>
                                        <td class="px-3 py-3">{{ number_format($order->product->price) }} DZD</td>
                                        <td class="px-3 py-3">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3 text-gray-500">{{ $order->created_at->format('M d') }}</td>
                                        <td class="px-3 py-3">
                                            <div class="flex gap-1">
                                                @if ($order->status === 'pending')
                                                    <form action="{{ route('seller.orders.confirm', $order) }}" method="POST">
                                                        @csrf
                                                        <button class="text-green-600 hover:text-green-900 text-xs">Confirm</button>
                                                    </form>
                                                    <form action="{{ route('seller.orders.reject', $order) }}" method="POST">
                                                        @csrf
                                                        <button class="text-red-600 hover:text-red-900 text-xs" onclick="return confirm('Reject?')">Reject</button>
                                                    </form>
                                                @endif
                                                @if ($order->status === 'confirmed')
                                                    <form action="{{ route('seller.orders.mark-delivered', $order) }}" method="POST">
                                                        @csrf
                                                        <button class="text-blue-600 hover:text-blue-900 text-xs" onclick="return confirm('Mark delivered?')">Deliver</button>
                                                    </form>
                                                @endif
                                                @if ($order->review)
                                                    <span class="text-xs">⭐{{ $order->review->rating }}</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">{{ $orders->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>