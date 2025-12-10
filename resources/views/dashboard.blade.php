<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                {{ __('Dashboard Buyer') }}
            </h2>
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-[#6d5dfc]" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-gray-600 font-medium">Selamat Berbelanja!</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-md animate-slide-up" role="alert">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Modern Search & Filter Card -->
            <div class="mb-8 bg-white rounded-2xl shadow-xl border border-gray-100 p-6 transform transition-all hover:shadow-2xl">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Cari & Filter Produk</h3>
                </div>
                
                <form action="{{ route('dashboard') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        
                        <!-- Search Input -->
                        <div class="md:col-span-5">
                            <div class="relative">
                                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" 
                                    name="search" 
                                    class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all" 
                                    placeholder="Cari produk impian Anda..." 
                                    value="{{ $searchQuery ?? '' }}">
                            </div>
                        </div>
                        
                        <!-- Category Select -->
                        <div class="md:col-span-3">
                            <select name="category" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all">
                                <option value="">🏷️ Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ ($filterCategory ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Sort Select -->
                        <div class="md:col-span-3">
                            <select name="sort" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all">
                                <option value="">📊 Urutkan</option>
                                <option value="asc" {{ ($sortPrice ?? '') == 'asc' ? 'selected' : '' }}>💰 Harga: Murah → Mahal</option>
                                <option value="desc" {{ ($sortPrice ?? '') == 'desc' ? 'selected' : '' }}>💎 Harga: Mahal → Murah</option>
                            </select>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="md:col-span-1">
                            <button type="submit" class="w-full h-full px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Section Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Rekomendasi Produk</h2>
                    <p class="text-gray-600">Produk terbaik pilihan untuk Anda ✨</p>
                </div>
                <div class="hidden md:flex items-center space-x-2 text-gray-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span class="text-sm font-medium">Grid View</span>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 transform hover:-translate-y-2">
                        
                        <!-- Image Container -->
                        <div class="relative overflow-hidden aspect-square">
                            @if(Auth::check() && Auth::user()->role == 'buyer')
                                <form action="{{ route('favorite.toggle', $product->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                                    @csrf
                                    <button type="submit" class="p-2.5 rounded-full backdrop-blur-sm transition-all shadow-lg
                                        @if(in_array($product->id, $favoriteProductIds)) 
                                            bg-red-500 scale-110
                                        @else 
                                            bg-white/90 text-gray-700 hover:bg-red-500 hover:text-white hover:scale-110
                                        @endif">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                            
                            <a href="{{ route('product.show', $product->id) }}" class="block">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-5">
                            <a href="{{ route('product.show', $product->id) }}">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors min-h-[3.5rem]">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            
                            <div class="flex items-center space-x-2 mb-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold">
                                    {{ substr($product->store->name, 0, 1) }}
                                </div>
                                <p class="text-sm text-gray-600 truncate">{{ $product->store->name }}</p>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span>Tambah ke Keranjang</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">Tidak ada produk untuk ditampilkan</p>
                        <p class="text-gray-400 text-sm mt-2">Coba ubah filter pencarian Anda</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>