<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan #') . $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold border-b pb-2 mb-4">Ringkasan Pesanan</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Order ID</p>
                                <p class="font-medium">#{{ $order->id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal Pesanan</p>
                                <p class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Harga</p>
                                <p class="font-medium text-lg text-blue-600">Rp {{ number_format($order->total_price) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="font-medium">
                                    @if($order->status == 'Menunggu Pembayaran')
                                        <span class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2.5 py-0.5 text-amber-700">
                                            {{ $order->status }}
                                        </span>
                                    @elseif($order->status == 'Selesai')
                                        <span class="inline-flex items-center justify-center rounded-full bg-green-100 px-2.5 py-0.5 text-green-700">
                                            {{ $order->status }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center rounded-full bg-blue-100 px-2.5 py-0.5 text-blue-700">
                                            {{ $order->status }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold border-b pb-2 mb-4">Item yang Dipesan</h3>
                        <div class="space-y-4">
                            @foreach ($orderItems as $item)
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div class="flex items-center gap-4">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-16 w-16 object-cover rounded">
                                        @endif
                                        <div>
                                            <p class="font-medium">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $item->quantity }} x Rp {{ number_format($item->price) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold">Rp {{ number_format($item->price * $item->quantity) }}</p>
                                        
                                        @if($order->status == 'Selesai')
                                            @php
                                                $hasReviewed = $order->items->find($item->id)
                                                                ->product->reviews()
                                                                ->where('user_id', Auth::id())
                                                                ->where('order_id', $order->id)
                                                                ->exists();
                                            @endphp

                                            @if($hasReviewed)
                                                <span class="text-sm text-green-600 mt-2">Sudah direview</span>
                                            @else
                                                <a href="{{ route('reviews.create', ['order' => $order->id, 'product' => $item->product_id]) }}" class="text-sm text-indigo-600 hover:text-indigo-800 mt-2">
                                                    Beri Rating
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>