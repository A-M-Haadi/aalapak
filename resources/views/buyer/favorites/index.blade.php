<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produk Favorit Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Daftar Wishlist</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        
                        @forelse ($favorites as $product)
                            <div class="border rounded-lg shadow-sm overflow-hidden flex flex-col">
                                <a href="{{ route('product.show', $product->id) }}">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-56 w-full object-cover">
                                    @else
                                        <div class="h-56 w-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500">No Image</span>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-4 flex flex-col flex-grow">
                                    <h3 class="text-lg font-semibold">
                                        <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-2">oleh {{ $product->store->name }}</p>
                                    <p class="text-lg font-bold text-gray-900">Rp {{ number_format($product->price) }}</p>
                                    
                                    <div class="flex-grow"></div> 

                                    <form action="{{ route('favorite.toggle', $product->id) }}" method="POST" class="mt-4">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                                            Hapus dari Favorit
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-full text-center text-gray-500">Anda belum memiliki produk favorit.</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>