<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alamat Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 text-right">
                <a href="{{ route('addresses.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Tambah Alamat Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Daftar Alamat Tersimpan</h3>
                    
                    <div class="space-y-4">
                        @forelse ($addresses as $address)
                            <div class="p-4 border rounded-lg flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-lg">{{ $address->label }}</p>
                                    <p class="text-gray-700">{{ $address->street }}</p>
                                    <p class="text-gray-700">{{ $address->city }}, {{ $address->province }}</p>
                                    <p class="text-gray-700">{{ $address->postal_code }}</p>
                                </div>
                                
                                <div class="flex-shrink-0 flex gap-2">
                                    <a href="{{ route('addresses.edit', $address->id) }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                                        Edit
                                    </a>
                                    <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus alamat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Anda belum menambahkan alamat.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>