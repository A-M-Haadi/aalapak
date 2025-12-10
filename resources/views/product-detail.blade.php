<x-app-layout>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center space-x-2 text-sm">
                <a href="/" class="text-gray-500 hover:text-blue-600 transition-colors">Beranda</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="/" class="text-gray-500 hover:text-blue-600 transition-colors">{{ $product->category->name }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">{{ Str::limit($product->name, 40) }}</span>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-md animate-fade-in">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="space-y-4">
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center aspect-square">
                                <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                        
                        <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-200">
                            <div class="flex items-center space-x-2">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                    {{ substr($product->store->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Toko</p>
                                    <p class="font-semibold text-gray-900">{{ $product->store->name }}</p>
                                </div>
                            </div>
                            </div>

                        <div class="mb-6">
                            <p class="text-sm text-gray-500 mb-2">Harga</p>
                            <p class="text-5xl font-extrabold bg-gradient-to-r from-yellow-500 to-purple-600 bg-clip-text text-transparent">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>
                        
                        <div class="flex items-center gap-3 mb-6">
                            @auth
                                @if(Auth::user()->role == 'buyer')
                                    <form action="{{ route('cart.store') }}" method="POST" class="flex-1 flex gap-3">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        
                                        <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden w-32 bg-white h-[58px]"> 
                                            <button type="button" onclick="decrementQuantity()" class="h-full px-3 bg-gray-50 hover:bg-gray-100 border-r border-gray-300 transition text-gray-600 flex items-center justify-center">-</button>
                                            <input type="number" name="quantity" id="quantityInput" value="1" min="1" max="{{ $product->stock }}" class="w-full h-full text-center border-none focus:ring-0 p-0 text-gray-900 font-bold bg-transparent appearance-none" readonly>
                                            <button type="button" onclick="incrementQuantity()" class="h-full px-3 bg-gray-50 hover:bg-gray-100 border-l border-gray-300 transition text-gray-600 flex items-center justify-center">+</button>
                                        </div>

                                        <button type="submit" class="flex-1 px-6 py-4 bg-gradient-to-r from-[#6d5dfc] to-[#5b4ebc] text-white font-bold text-lg rounded-xl hover:shadow-xl hover:shadow-[#6d5dfc]/30 transform hover:-translate-y-1 transition-all flex items-center justify-center space-x-2">
                                            <span>+ Keranjang</span>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="flex-1 block text-center px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold text-lg rounded-xl hover:shadow-xl transform hover:-translate-y-1 transition-all">
                                    Login untuk Membeli
                                </a>
                            @endauth
                        </div>
                        
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Produk</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Ulasan Produk</h3>
                </div>

        </div>
    </div>
    
    <script>
        function decrementQuantity() {
            var input = document.getElementById('quantityInput');
            if(!input) return;
            var value = parseInt(input.value);
            if (value > 1) input.value = value - 1;
        }

        function incrementQuantity() {
            var input = document.getElementById('quantityInput');
            if(!input) return;
            var value = parseInt(input.value);
            var max = parseInt(input.getAttribute('max'));
            if (value < max) {
                input.value = value + 1;
            } else {
                alert('Stok maksimal tercapai');
            }
        }
    </script>
</x-app-layout>