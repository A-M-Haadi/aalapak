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
                        <h3 class="text-2xl font-semibold mb-4">Toko Anda: {{ $store->name }}</h3>
                        
                        @if ($store->image)
                            <img src="{{ asset('storage/' . $store->image) }}" alt="{{ $store->name }}" class="w-32 h-32 object-cover rounded-md mb-4">
                        @endif

                        <p class="mb-4">{{ $store->description ?? 'Belum ada deskripsi.' }}</p>

                        <a href="{{ route('seller.store.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                            Edit Informasi Toko
                        </a>

                    @else
                        <h3 class="text-2xl font-semibold mb-4">Selamat Datang, Seller!</h3>
                        <p class="mb-4">Akun Anda telah disetujui. Langkah selanjutnya adalah membuat toko Anda.</p>
                        <a href="{{ route('seller.store.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-green-500">
                            Buat Toko Sekarang
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>