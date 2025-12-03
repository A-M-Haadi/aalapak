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
                        @method('PUT') <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Nama User</label>
                            <input id="name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus />
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input id="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <label for="role" class="block font-medium text-sm text-gray-700">Role</label>
                            <select name="role" id="role" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                <option value="admin" @if(old('role', $user->role) == 'admin') selected @endif>Admin</option>
                                <option value="seller" @if(old('role', $user->role) == 'seller') selected @endif>Seller</option>
                                <option value="buyer" @if(old('role', $user->role) == 'buyer') selected @endif>Buyer</option>
                            </select>
                            @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
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