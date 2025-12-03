<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="text-left">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Nama</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Email</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Role</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Status Seller</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse ($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $user->email }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700 capitalize">{{ $user->role }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        @if($user->role == 'seller')
                                            <span class="capitalize">{{ $user->store_status }}</span>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 mr-2">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('PERINGATAN: Menghapus user ini akan menghapus semua data terkait (toko, produk, pesanan). Apakah Anda yakin?');">
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
                                        Tidak ada user lain selain Anda.
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