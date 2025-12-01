<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $product->name }} - {{ config('app.name', 'Laravel') }}</title>
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="antialiased bg-gradient-to-br from-gray-50 via-white to-gray-100 min-h-screen">
        
        <!-- Modern Navbar -->
        <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="/" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        MarketPlace
                    </a>
                    
                    @if (Route::has('login'))
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                                    Masuk
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                        Daftar
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Breadcrumb -->
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

        <main class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Success Message -->
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
                    
                    <!-- Product Image Section -->
                    <div class="space-y-4">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-auto object-cover hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center" style="aspect-ratio: 1/1;">
                                    <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Product Info Section -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                            
                            <!-- Product Title -->
                            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                            
                            <!-- Store & Category -->
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
                                <div class="h-12 w-px bg-gray-300"></div>
                                <div>
                                    <p class="text-sm text-gray-500">Kategori</p>
                                    <p class="font-semibold text-gray-900">{{ $product->category->name }}</p>
                                </div>
                            </div>
                            
                            <!-- Price -->
                            <div class="mb-6">
                                <p class="text-sm text-gray-500 mb-2">Harga</p>
                                <p class="text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            <!-- Stock -->
                            <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <span class="text-gray-700 font-medium">Stok tersedia</span>
                                    </div>
                                    <span class="text-2xl font-bold text-blue-600">{{ $product->stock }}</span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            @php
                                $isFavorited = false;
                                if(Auth::check() && Auth::user()->role == 'buyer') {
                                    $isFavorited = Auth::user()->favorites()->where('product_id', $product->id)->exists();
                                }
                            @endphp

                            <div class="flex items-center gap-3 mb-6">
                                @if(Auth::check() && Auth::user()->role == 'buyer')
                                    <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold text-lg rounded-xl hover:shadow-xl transform hover:-translate-y-1 transition-all flex items-center justify-center space-x-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span>Tambah ke Keranjang</span>
                                        </button>
                                    </form>

                                    <form action="{{ route('favorite.toggle', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-5 py-4 rounded-xl border-2 transition-all
                                            @if($isFavorited) 
                                                bg-red-500 text-white border-red-500 hover:bg-red-600
                                            @else 
                                                bg-white text-gray-700 border-gray-300 hover:border-red-500 hover:text-red-500
                                            @endif">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @elseif(!Auth::check())
                                    <a href="{{ route('login') }}" class="flex-1 block text-center px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold text-lg rounded-xl hover:shadow-xl transform hover:-translate-y-1 transition-all">
                                        Login untuk Membeli
                                    </a>
                                @endif
                            </div>

                            <!-- Description -->
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Deskripsi Produk
                                </h3>
                                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="mt-12 bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                            <svg class="w-7 h-7 mr-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Rating & Review
                        </h3>
                        <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full font-semibold">{{ $reviewCount }} Ulasan</span>
                    </div>
                    
                    @if($reviewCount > 0)
                        <div class="mb-8 p-6 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl border border-yellow-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-6xl font-bold text-gray-900">{{ number_format($averageRating, 1) }}</p>
                                    <p class="text-gray-600 mt-1">dari 5.0</p>
                                </div>
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($averageRating))
                                            <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                        @else
                                            <svg class="w-8 h-8 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-6">
                        @forelse ($product->reviews as $review)
                            <div class="p-6 border border-gray-200 rounded-xl hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                            @else
                                                <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg">Belum ada review untuk produk ini</p>
                                <p class="text-gray-400 text-sm mt-2">Jadilah yang pertama memberikan review!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <p class="text-gray-400">&copy; 2024 MarketPlace. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>