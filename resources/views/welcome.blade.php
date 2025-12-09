<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Aalapak') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <header class="bg-white sticky top-0 z-50 shadow-sm border-b border-gray-100/80 backdrop-blur-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            
            <a href="/" class="flex items-center gap-2 animate-scale-in">
                <div class="w-10 h-10 bg-aalapak-orange rounded-lg flex items-center justify-center text-white shadow-lg shadow-orange-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                </div>
                <span class="text-2xl font-extrabold text-aalapak-blue tracking-tight">Aalapak</span>
            </a>

            <nav class="flex items-center gap-6 text-sm font-medium">
                <div class="h-6 w-px bg-gray-200 mx-2 hidden md:block"></div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-aalapak-orange">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-aalapak-orange">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-aalapak-blue text-white rounded-full hover:bg-sky-600 transition shadow-md shadow-blue-200 hover:scale-105 transform duration-200">Daftar</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <main>
        <div class="relative bg-gradient-to-r from-aalapak-blue via-[#6d5dfc] to-[#b06ab3] h-[400px] flex flex-col items-center justify-center text-center px-4 overflow-hidden">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-aalapak-orange opacity-20 rounded-full translate-x-1/3 translate-y-1/3 blur-3xl animate-pulse"></div>

            <div class="relative z-10 max-w-3xl mx-auto animate-fade-in">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 drop-shadow-sm tracking-tight">
                    Temukan Produk <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-aalapak-orange">Impian Anda</span>
                </h1>
                <p class="text-lg text-blue-50 mb-8 font-light">Ribuan produk berkualitas dengan harga terbaik dari seller terpercaya.</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20 animate-slide-up">
            <div class="bg-white p-4 rounded-xl shadow-xl border border-gray-100">
                <form action="{{ route('home') }}" method="GET">
                    <div class="flex flex-col md:flex-row gap-3">
                        <div class="flex-grow relative">
                            <input type="text" name="search" class="w-full pl-4 pr-4 py-3 rounded-lg border border-gray-200 focus:border-aalapak-blue focus:ring-aalapak-blue" placeholder="Cari produk..." value="{{ $searchQuery ?? '' }}">
                        </div>
                        
                        <select name="category" class="md:w-1/4 py-3 rounded-lg border border-gray-200 focus:border-aalapak-blue focus:ring-aalapak-blue text-gray-600">
                            <option value="">Semua Kategori</option>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>

                        <button type="submit" class="md:w-auto px-8 py-3 bg-gradient-to-r from-aalapak-blue to-[#6d5dfc] text-white font-bold rounded-lg hover:shadow-lg transition transform hover:-translate-y-0.5">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Rekomendasi Untukmu</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6 animate-fade-in" style="animation-delay: 0.2s;">
                @if(isset($products) && count($products) > 0)
                    @foreach ($products as $product)
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden group hover:-translate-y-1">
                            <a href="{{ route('product.show', $product->id) }}">
                                <div class="aspect-square w-full relative bg-gray-50">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="text-sm font-medium text-gray-800 line-clamp-2 group-hover:text-aalapak-blue transition-colors">{{ $product->name }}</h3>
                                    <p class="text-lg font-bold text-aalapak-orange mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full py-16 flex flex-col items-center justify-center text-gray-400 bg-white rounded-xl border border-dashed border-gray-300">
                        <p class="text-lg">Produk tidak ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 pt-12 pb-8 text-center">
        <p class="text-2xl font-extrabold text-aalapak-blue mb-4">Aalapak</p>
        <p class="text-gray-400 text-xs">&copy; {{ date('Y') }} Aalapak. All rights reserved.</p>
    </footer>

</body>
</html>