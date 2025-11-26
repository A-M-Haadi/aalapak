<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Akun Seller') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

                    @if(Auth::user()->store_status == 'pending')
                        <h3 class="text-2xl font-semibold mb-4">Akun Anda Sedang Ditinjau</h3>
                        <p>
                            Terima kasih telah mendaftar. Akun Seller Anda sedang dalam proses verifikasi oleh Admin.
                            <br>
                            Silakan cek kembali nanti.
                        </p>

                    @elseif(Auth::user()->store_status == 'rejected')
                        <h3 class="text-2xl font-semibold mb-4 text-red-600">Pendaftaran Anda Ditolak</h3>
                        <p class="mb-6">
                            Mohon maaf, pendaftaran Seller Anda telah ditolak oleh Admin.
                            <br>
                            Anda dapat menghapus akun Anda dan mendaftar kembali jika ada kesalahan.
                        </p>
                        
                        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen?');">
                            @csrf
                            @method('delete')
                            
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Hapus Akun Saya
                            </button>
                        </form>

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>