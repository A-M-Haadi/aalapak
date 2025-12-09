<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Selamat Datang -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Halo, Admin!</h3>
                    <p class="text-gray-600">Selamat datang di panel kontrol utama Aalapak.</p>
                </div>
            </div>

            <!-- Grid Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total User -->
                <div class="bg-blue-500 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="text-3xl font-bold">{{ $totalUsers }}</div>
                        <div class="text-sm opacity-80">Total Pengguna</div>
                    </div>
                </div>

                <!-- Total Produk -->
                <div class="bg-green-500 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="text-3xl font-bold">{{ $totalProducts }}</div>
                        <div class="text-sm opacity-80">Produk Terdaftar</div>
                    </div>
                </div>

                <!-- Total Order -->
                <div class="bg-purple-600 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="text-3xl font-bold">{{ $totalOrders }}</div>
                        <div class="text-sm opacity-80">Total Transaksi</div>
                    </div>
                </div>

                <!-- Pending Sellers -->
                <div class="bg-orange-500 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="text-3xl font-bold">{{ $pendingSellers }}</div>
                        <div class="text-sm opacity-80">Seller Perlu Verifikasi</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Aksi Cepat -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4 text-gray-800">Aksi Cepat</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.categories.index') }}" class="block p-4 border rounded-lg hover:bg-gray-50 text-center">
                                <span class="block font-bold text-gray-700">Kelola Kategori</span>
                            </a>
                            <a href="{{ route('admin.sellers.index') }}" class="block p-4 border rounded-lg hover:bg-gray-50 text-center">
                                <span class="block font-bold text-gray-700">Verifikasi Seller</span>
                                @if($pendingSellers > 0)
                                    <span class="text-xs bg-red-500 text-white px-2 py-0.5 rounded-full">{{ $pendingSellers }} Baru</span>
                                @endif
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="block p-4 border rounded-lg hover:bg-gray-50 text-center">
                                <span class="block font-bold text-gray-700">Manajemen User</span>
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="block p-4 border rounded-lg hover:bg-gray-50 text-center">
                                <span class="block font-bold text-gray-700">Semua Produk</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pesanan Terbaru -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4 text-gray-800">Transaksi Terbaru</h3>
                        <ul class="divide-y divide-gray-100">
                            @forelse($latestOrders as $order)
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</p>
                                        <p class="text-xs text-gray-500">Oleh {{ $order->user->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900">Rp {{ number_format($order->total_price) }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-sm text-gray-500 text-center py-4">Belum ada transaksi.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>