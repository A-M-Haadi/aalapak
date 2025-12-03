<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Alamat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('addresses.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="label" :value="__('Label Alamat (cth: Rumah, Kantor)')" />
                            <x-text-input id="label" class="block mt-1 w-full" type="text" name="label" :value="old('label')" required autofocus />
                            <x-input-error :messages="$errors->get('label')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="street" :value="__('Alamat Jalan (Nama Jalan, No. Rumah, RT/RW)')" />
                            <x-text-input id="street" class="block mt-1 w-full" type="text" name="street" :value="old('street')" required />
                            <x-input-error :messages="$errors->get('street')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <x-input-label for="city" :value="__('Kota / Kabupaten')" />
                                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="province" :value="__('Provinsi')" />
                                <x-text-input id="province" class="block mt-1 w-full" type="text" name="province" :value="old('province')" required />
                                <x-input-error :messages="$errors->get('province')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="postal_code" :value="__('Kode Pos')" />
                                <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')" required />
                                <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('addresses.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>

                            <x-primary-button>
                                {{ __('Simpan Alamat') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>