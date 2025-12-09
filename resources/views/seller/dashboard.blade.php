<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
    @if ($store)
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                @if ($store->image)
                    <img src="{{ asset('storage/' . $store->image) }}" alt="{{ $store->name }}" class="w-16 h-16 object-cover rounded-full border border-gray-200">
                @else
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                @endif
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $store->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ $store->description ?? 'Deskripsi toko belum diisi.' }}</p>
                </div>
            </div>
            <a href="{{ route('seller.store.edit') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                Edit Toko
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-gray-500 text-sm font-medium">Total Pendapatan</h4>
                    <div class="p-2 bg-green-100 rounded-lg text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-gray-500 text-sm font-medium">Total Produk</h4>
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-gray-500 text-sm font-medium">Pesanan Baru</h4>
                    <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $pendingOrders }}</p>
            </div>
        </div>

    @else
        <div class="text-center py-10">
            <h3 class="text-2xl font-semibold mb-4">Selamat Datang, Seller!</h3>
            <p class="mb-6 text-gray-600">Akun Anda telah disetujui. Langkah selanjutnya adalah membuat toko Anda.</p>
            <a href="{{ route('seller.store.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-500 transition shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m8-2h2m-2 4h2m-2-4h2m-2 4h2m-2-4h2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Buat Toko Sekarang
            </a>
        </div>
    @endif
</div>
            </div>
        </div>
    </div>
</x-app-layout>