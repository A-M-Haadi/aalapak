<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Aalapak') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'aalapak-orange': '#F28E2B',
                            'aalapak-blue': '#4E9FCA',
                            'aalapak-sky': '#76C6E6',
                        }
                    }
                }
            }
        </script>
    @endif
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <!-- 1. NAVBAR (Putih Bersih) -->
    <header class="bg-white sticky top-0 z-50 shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            
            <!-- Logo & Brand -->
            <a href="/" class="flex items-center gap-2">
                <!-- Ikon Keranjang Belanja Sederhana (Mewakili Logo) -->
                <div class="w-10 h-10 bg-aalapak-orange rounded-lg flex items-center justify-center text-white shadow-lg shadow-orange-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                </div>
                <span class="text-2xl font-extrabold text-aalapak-blue tracking-tight">Aalapak</span>
            </a>

            <!-- Menu Kanan -->
            <nav class="flex items-center gap-6 text-sm font-medium">
                <a href="#" class="hidden md:block text-gray-500 hover:text-aalapak-orange transition">Beranda</a>
                
                <div class="h-6 w-px bg-gray-200 mx-2 hidden md:block"></div>

                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-aalapak-orange">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-aalapak-orange">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-aalapak-blue text-white rounded-full hover:bg-sky-600 transition shadow-md shadow-blue-200">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        <!-- 2. HERO SECTION (BANNER GRADASI) -->
        <!-- Ini bagian "Latar Ungu/Biru" yang Anda inginkan -->
        <div class="relative bg-gradient-to-r from-aalapak-blue via-[#6d5dfc] to-[#b06ab3] h-[400px] flex flex-col items-center justify-center text-center px-4 overflow-hidden">
            
            <!-- Elemen Dekorasi Background (Lingkaran transparan) -->
            <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-aalapak-orange opacity-20 rounded-full translate-x-1/3 translate-y-1/3 blur-3xl"></div>

            <!-- Teks Hero -->
            <div class="relative z-10 max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 drop-shadow-sm tracking-tight">
                    Temukan Produk <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-aalapak-orange">Impian Anda</span>
                </h1>
                <p class="text-lg text-blue-50 mb-8 font-light">Ribuan produk berkualitas dengan harga terbaik dari seller terpercaya.</p>
            </div>
        </div>

        <!-- 3. SEARCH BAR (Floating / Melayang) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
            <div class="bg-white p-4 rounded-xl shadow-xl border border-gray-100">
                <form action="{{ route('home') }}" method="GET">
                    <div class="flex flex-col md:flex-row gap-3">
                        <!-- Input Cari -->
                        <div class="flex-grow relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <input type="text" name="search" class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:border-aalapak-blue focus:ring-aalapak-blue" placeholder="Cari produk..." value="{{ $searchQuery ?? '' }}">
                        </div>

                        <!-- Dropdown Kategori -->
                        <select name="category" class="md:w-1/4 py-3 rounded-lg border border-gray-200 focus:border-aalapak-blue focus:ring-aalapak-blue text-gray-600">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ ($filterCategory ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <!-- Dropdown Sort -->
                        <select name="sort" class="md:w-1/5 py-3 rounded-lg border border-gray-200 focus:border-aalapak-blue focus:ring-aalapak-blue text-gray-600">
                            <option value="">Urutkan</option>
                            <option value="asc" {{ ($sortPrice ?? '') == 'asc' ? 'selected' : '' }}>Harga: Murah ke Mahal</option>
                            <option value="desc" {{ ($sortPrice ?? '') == 'desc' ? 'selected' : '' }}>Harga: Mahal ke Murah</option>
                        </select>

                        <!-- Tombol Filter -->
                        <button type="submit" class="md:w-auto px-8 py-3 bg-gradient-to-r from-aalapak-blue to-[#6d5dfc] text-white font-bold rounded-lg hover:shadow-lg transition transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 4. GRID PRODUK -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Rekomendasi Untukmu</h2>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @forelse ($products as $product)
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 overflow-hidden flex flex-col relative group">
                        
                        <!-- Tombol Favorit -->
                        @if(Auth::check() && Auth::user()->role == 'buyer')
                            <form action="{{ route('favorite.toggle', $product->id) }}" method="POST" class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition">
                                @csrf
                                <button type="submit" class="p-2 rounded-full shadow-md {{ in_array($product->id, $favoriteProductIds ?? []) ? 'bg-red-500 text-white' : 'bg-white text-gray-400 hover:text-red-500' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('product.show', $product->id) }}" class="flex flex-col h-full">
                            <!-- Gambar -->
                            <div class="aspect-square w-full relative bg-gray-50">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Info Produk -->
                            <div class="p-4 flex flex-col flex-grow">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-aalapak-orange/10 text-aalapak-orange">Official</span>
                                    <span class="text-xs text-gray-400 truncate">{{ $product->store->name }}</span>
                                </div>
                                
                                <h3 class="text-sm font-medium text-gray-800 line-clamp-2 mb-2 min-h-[40px] group-hover:text-aalapak-blue transition-colors">{{ $product->name }}</h3>
                                
                                <div class="mt-auto">
                                    <p class="text-lg font-bold text-aalapak-orange">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <span class="text-xs text-gray-500 ml-1">4.8</span>
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $product->stock }} terjual</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full py-16 flex flex-col items-center justify-center text-gray-400 bg-white rounded-xl border border-dashed border-gray-300">
                        <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <p class="text-lg">Produk tidak ditemukan.</p>
                        <p class="text-sm">Coba kata kunci lain atau reset filter.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-gray-200 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-2xl font-extrabold text-aalapak-blue mb-4">Aalapak</p>
            <p class="text-gray-500 text-sm mb-8">Platform e-commerce terpercaya untuk memenuhi segala kebutuhan Anda.</p>
            <p class="text-gray-400 text-xs">&copy; {{ date('Y') }} Aalapak. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>