<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <div>
                                <h3 class="text-lg font-semibold border-b pb-2 mb-4">1. Pilih Alamat Pengiriman</h3>
                                
                                @if($addresses->isEmpty())
                                    <p class="text-gray-500 mb-4">Anda belum memiliki alamat tersimpan.</p>
                                    <a href="{{ route('addresses.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                        Tambah Alamat Baru
                                    </a>
                                @else
                                    <div class="space-y-4">
                                        @foreach($addresses as $address)
                                            <label for="address_{{ $address->id }}" class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                                <input type="radio" name="address_id" id="address_{{ $address->id }}" value="{{ $address->id }}" class="mt-1 mr-3" {{ $loop->first ? 'checked' : '' }}>
                                                <div>
                                                    <p class="font-bold">{{ $address->label }}</p>
                                                    <p class="text-sm text-gray-700">{{ $address->street }}</p>
                                                    <p class="text-sm text-gray-700">{{ $address->city }}, {{ $address->province }} - {{ $address->postal_code }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('address_id')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                @endif
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold border-b pb-2 mb-4">2. Ringkasan Pesanan</h3>
                                <div class="space-y-3">
                                    @foreach($cartItems as $item)
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                            <span class="font-medium">Rp {{ number_format($item->product->price * $item->quantity) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="border-t mt-4 pt-4 flex justify-between text-xl font-bold">
                                    <span>Total:</span>
                                    <span>Rp {{ number_format($subtotal) }}</span>
                                </div>

                                @if($addresses->isNotEmpty())
                                    <button type="submit" class="mt-6 w-full px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-lg text-white uppercase tracking-widest hover:bg-green-500">
                                        Buat Pesanan
                                    </button>
                                @endif
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>