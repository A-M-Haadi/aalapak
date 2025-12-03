<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($cartItems->isEmpty())
                        <p class="text-center text-gray-500">Keranjang belanja Anda masih kosong.</p>
                        <div class="text-center mt-4">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Mulai Belanja
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                <thead class="text-left">
                                    <tr>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Produk</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Harga</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Jumlah</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Total</th>
                                        <th class="px-4 py-2"></th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td class="whitespace-nowrap px-4 py-2">
                                                <div class="flex items-center gap-4">
                                                    @if($item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-16 w-16 object-cover rounded">
                                                    @endif
                                                    <div>
                                                        <p class="font-medium">{{ $item->product->name }}</p>
                                                        <p class="text-xs text-gray-500">Stok: {{ $item->product->stock }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">Rp {{ number_format($item->product->price) }}</td>
                                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" class="w-20 rounded border-gray-300 text-sm" min="1" max="{{ $item->product->stock }}">
                                                    <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-900">Update</button>
                                                </form>
                                                @error('quantity')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">Rp {{ number_format($item->product->price * $item->quantity) }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">
                                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>                            
                            </table>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <div class="w-full max-w-md space-y-4">
                                <div class="flex justify-between text-lg font-medium">
                                    <span>Subtotal:</span>
                                    <span>Rp {{ number_format($subtotal) }}</span>
                                </div>
                                
                                <a href="{{ route('checkout.index') }}" class="block w-full text-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-lg text-white uppercase tracking-widest hover:bg-green-500">
                                    Lanjut ke Checkout
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>