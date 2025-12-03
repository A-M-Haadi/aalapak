<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Semua Produk') }}
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
                    <p class="mb-4 text-gray-500">Halaman ini mengizinkan Admin untuk menghapus produk yang melanggar ketentuan .</p>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="text-left">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Nama Produk</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Toko (Seller)</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Harga</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Stok</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse ($products as $product)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ $product->name }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $product->store->name ?? 'Toko Dihapus' }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">Rp {{ number_format($product->price) }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $product->stock }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda akan menghapus produk ini dari toko seller. Yakin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="whitespace-nowrap px-4 py-2 text-center text-gray-500">
                                        Belum ada produk apa pun di platform ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>