<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beri Review untuk: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="flex items-center gap-4 mb-6">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-20 w-20 object-cover rounded">
                            @endif
                            <div>
                                <h3 class="text-lg font-medium">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">Dipesan pada: {{ $order->created_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        <div>
                            <label for="rating" class="block font-medium text-sm text-gray-700">Rating (1-5)</label>
                            <select name="rating" id="rating" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                <option value="">-- Pilih Rating --</option>
                                <option value="5">Bintang 5</option>
                                <option value="4">Bintang 4</option>
                                <option value="3">Bintang 3</option>
                                <option value="2">Bintang 2</option>
                                <option value="1">Bintang 1</option>
                            </select>
                            @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <label for="comment" class="block font-medium text-sm text-gray-700">Ulasan (Opsional)</label>
                            <textarea id="comment" name="comment" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">{{ old('comment') }}</textarea>
                            @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Kirim Review
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>