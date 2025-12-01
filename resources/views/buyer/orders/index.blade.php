<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="text-left">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Order ID</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Tanggal</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Total Harga</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Status [cite: 71]</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse ($orders as $order)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">#{{ $order->id }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">Rp {{ number_format($order->total_price) }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
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
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2">
                                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center px-3 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="whitespace-nowrap px-4 py-2 text-center text-gray-500">
                                        Anda belum memiliki riwayat pesanan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>