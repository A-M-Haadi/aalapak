<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Halo, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Ini adalah ringkasan performa toko <span class="font-semibold">{{ $store->name }}</span> Anda.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-blue-500 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="text-2xl font-bold">{{ $totalProducts }}</div>
                        <div class="text-sm opacity-80">Total Produk Aktif</div>
                    </div>
                </div>

                <div class="bg-green-500 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="text-2xl font-bold">{{ $totalOrders }}</div>
                        <div class="text-sm opacity-80">Item Terjual</div>
                    </div>
                </div>

                <div class="bg-purple-600 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="text-2xl font-bold">Rp {{ number_format($totalRevenue) }}</div>
                        <div class="text-sm opacity-80">Total Pendapatan (Selesai)</div>
                    </div>
                </div>

            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('seller.products.create') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 text-center">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Tambah Produk Baru</h5>
                    <p class="font-normal text-gray-700">Upload produk jualanmu sekarang.</p>
                </a>
                <a href="{{ route('seller.orders.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 text-center">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Cek Pesanan Masuk</h5>
                    <p class="font-normal text-gray-700">Lihat dan proses pesanan dari pembeli.</p>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>