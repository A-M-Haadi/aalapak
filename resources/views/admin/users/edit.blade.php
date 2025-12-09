<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User: ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Nama User</label>
                            <input id="name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" type="text" name="name" value="{{ old('name', $user->name) }}" required />
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input id="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700">Role (Tidak dapat diubah)</label>
                            <input type="text" value="{{ ucfirst($user->role) }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 bg-gray-100 text-gray-500 cursor-not-allowed" disabled readonly />
                            <p class="text-xs text-gray-500 mt-1">Anda tidak dapat mengubah role pengguna ini.</p>
                        </div>

                        @if($user->role == 'seller')
                            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                                <label for="store_status" class="block font-medium text-sm text-gray-700">Status Toko Seller</label>
                                <select name="store_status" id="store_status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                    <option value="pending" @if(old('store_status', $user->store_status) == 'pending') selected @endif>Pending (Menunggu Persetujuan)</option>
                                    <option value="approved" @if(old('store_status', $user->store_status) == 'approved') selected @endif>Approved (Disetujui)</option>
                                    <option value="rejected" @if(old('store_status', $user->store_status) == 'rejected') selected @endif>Rejected (Ditolak)</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Ubah ke 'Pending' atau 'Rejected' untuk membekukan akses toko seller ini.</p>
                                @error('store_status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:underline mr-4">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Update User
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>