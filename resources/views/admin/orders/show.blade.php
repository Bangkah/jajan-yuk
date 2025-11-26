<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Pesanan #{{ $order->id }}</h1>

    <!-- Info Pesanan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-semibold text-lg">Informasi Pesanan</h3>
            <p><strong>User:</strong> {{ $order->user->name }}</p>
            <p><strong>Tipe:</strong> {{ $order->type === 'titip' ? 'Titip Beli' : 'Makanan' }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            <p><strong>Catatan:</strong> {{ $order->notes ?? '-' }}</p>
            @if($order->address)
                <p><strong>Alamat:</strong> {{ $order->address }}</p>
            @endif
        </div>

        <!-- Update Status -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-semibold text-lg mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border rounded">
                        <option value="new" {{ $order->status === 'new' ? 'selected' : '' }}>Baru</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="delivering" {{ $order->status === 'delivering' ? 'selected' : '' }}>Dikirim</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <!-- Jika titip beli: izinkan ubah harga -->
                @if($order->type === 'titip')
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Harga Sebenarnya (Rp)</label>
                        <input type="number" name="real_price" value="{{ $order->items[0]->price }}"
                            class="w-full px-3 py-2 border rounded" min="1000">
                        <p class="text-sm text-gray-500 mt-1">Ubah jika perkiraan user tidak akurat.</p>
                    </div>
                @endif

                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <!-- Detail Item -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold text-lg mb-4">Detail Item</h3>
        <ul class="space-y-2">
            @foreach($order->items as $item)
                <li class="flex justify-between">
                    <span>{{ $item->qty }}x {{ $item->item_name }}</span>
                    <span>Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.orders.index') }}" class="text-green-600 hover:underline">← Kembali ke Daftar</a>
    </div>
</x-app-layout>