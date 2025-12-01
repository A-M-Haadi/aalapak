<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan #') . $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Informasi Pembeli</h3>
                            <p class="text-sm text-gray-500">Nama Pembeli</p>
                            <p class="font-medium mb-2">{{ $order->user->name }}</p>
                            
                            <p class="text-sm text-gray-500">Email Pembeli</p>
                            <p class="font-medium">{{ $order->user->email }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Update Status Pesanan </h3>
                            <form action="{{ route('seller.orders.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                
                                <label for="status" class="block text-sm font-medium text-gray-700">Status Saat Ini:</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="Menunggu Pembayaran" @if($order->status == 'Menunggu Pembayaran') selected @endif>Menunggu Pembayaran</option>
                                    <option value="Diproses" @if($order->status == 'Diproses') selected @endif>Diproses</option>
                                    <option value="Selesai" @if($order->status == 'Selesai') selected @endif>Selesai</option>
                                    <option value="Dibatalkan" @if($order->status == 'Dibatalkan') selected @endif>Dibatalkan</option>
                                </select>
                                
                                <button type="submit" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold border-b pb-2 mb-4">Item dari Toko Anda</h3>
                        <div class="space-y-4">
                            @php $subtotalToko = 0; @endphp
                            
                            @foreach ($order->items as $item)
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
                                    </div>
                                    @php $subtotalToko += $item->price * $item->quantity; @endphp
                                </div>
                            @endforeach

                            <div class="flex justify-end mt-6">
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Total dari Toko Anda:</p>
                                    <p class="text-2xl font-bold">Rp {{ number_format($subtotalToko) }}</p>
                                    <p class="text-xs text-gray-400">(Total keseluruhan pesanan: Rp {{ number_format($order->total_price) }})</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>