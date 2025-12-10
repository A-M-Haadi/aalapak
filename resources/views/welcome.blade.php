<x-app-layout>
    <div class="relative bg-gradient-to-r from-blue-600 via-[#6d5dfc] to-purple-600 h-[450px] flex flex-col items-center justify-center text-center px-4 overflow-hidden -mt-[1px]">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-orange-400 opacity-20 rounded-full translate-x-1/3 translate-y-1/3 blur-3xl animate-pulse"></div>

        <div class="relative z-10 max-w-3xl mx-auto animate-fade-in">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 drop-shadow-md tracking-tight leading-tight">
                Temukan Produk <br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-300">Impian Anda</span>
            </h1>
            <p class="text-lg text-blue-50 mb-8 font-light max-w-2xl mx-auto">
                Ribuan produk berkualitas dengan harga terbaik dari seller terpercaya di seluruh Indonesia.
            </p>
            
            <div class="md:hidden">
                 <a href="#search-section" class="px-6 py-3 bg-white text-[#6d5dfc] font-bold rounded-full shadow-lg">Mulai Mencari</a>
            </div>
        </div>
    </div>

    <div id="search-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20 animate-slide-up">
        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <form action="{{ route('home') }}" method="GET">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-[#6d5dfc] focus:ring focus:ring-[#6d5dfc]/20 transition-all outline-none" placeholder="Cari barang elektronik, fashion, hobi..." value="{{ $searchQuery ?? '' }}">
                    </div>
                    
                    <div class="md:w-1/4 relative">
                        <select name="category" class="w-full py-3.5 px-4 rounded-xl border border-gray-200 focus:border-[#6d5dfc] focus:ring focus:ring-[#6d5dfc]/20 text-gray-600 outline-none appearance-none bg-white">
                            <option value="">📂 Semua Kategori</option>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-[#6d5dfc] to-[#5b4ebc] text-white font-bold rounded-xl shadow-lg hover:shadow-[#6d5dfc]/40 hover:-translate-y-1 transition-all duration-300">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Rekomendasi Untukmu ✨</h2>
            {{-- <a href="#" class="text-[#6d5dfc] font-semibold hover:underline">Lihat Semua →</a> --}}
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6 animate-fade-in">
            @if(isset($products) && count($products) > 0)
                @foreach ($products as $product)
                    <div class="group bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-2xl hover:shadow-gray-200/50 transition duration-300 overflow-hidden hover:-translate-y-2">
                        <a href="{{ route('product.show', $product->id) }}">
                            <div class="aspect-square w-full relative bg-gray-50 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-100">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                
                                <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-xs font-bold text-gray-700 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                    Stok: {{ $product->stock }}
                                </div>
                            </div>

                            <div class="p-4">
                                <div class="flex items-center space-x-1 mb-2">
                                    <div class="w-4 h-4 rounded-full bg-gray-200 flex items-center justify-center text-[10px] text-gray-600 font-bold">
                                        {{ substr($product->store->name, 0, 1) }}
                                    </div>
                                    <span class="text-xs text-gray-500 truncate">{{ $product->store->name }}</span>
                                </div>

                                <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 min-h-[40px] group-hover:text-[#6d5dfc] transition-colors mb-2">
                                    {{ $product->name }}
                                </h3>
                                
                                <div class="flex items-center justify-between">
                                    <p class="text-lg font-extrabold text-[#6d5dfc]">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="col-span-full py-16 flex flex-col items-center justify-center text-gray-400 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p class="text-lg font-medium text-gray-500">Produk tidak ditemukan.</p>
                    <p class="text-sm">Coba gunakan kata kunci lain.</p>
                </div>
            @endif
        </div>
    </div>

    </x-app-layout>