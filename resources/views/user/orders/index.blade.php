<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Pesanan</h1>

    @if($orders->isEmpty())
        <div class="text-center py-10">
            <p class="text-gray-500">Belum ada pesanan.</p>
            <a href="{{ route('home') }}" class="text-green-600 hover:underline mt-2 inline-block">Lihat Menu</a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="border rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold">Pesanan #{{ $order->id }}</h3>
                            <span class="inline-block mt-1 px-2 py-1 text-xs 
                                @if($order->status === 'new') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'delivering') bg-purple-100 text-purple-800
                                @elseif($order->status === 'completed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif rounded">
                                {{ ucfirst($order->status) }}
                            </span>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $order->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        <p class="font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>

                    <div class="mt-3">
                        <h4 class="font-semibold">Detail:</h4>
                        <ul class="mt-2 space-y-1">
                            @foreach($order->items as $item)
                                <li>
                                    <span class="font-medium">{{ $item->qty }}x</span> 
                                    {{ $item->item_name ?? $item->menu?->name ?? 'Barang tidak ditemukan' }}
                                    @if($item->menu)
                                        <span class="text-sm text-gray-500">({{ $item->menu->category->name }})</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    @if($order->notes)
                        <p class="mt-2 text-sm text-gray-600">Catatan: {{ $order->notes }}</p>
                    @endif

                    @if($order->address)
                        <p class="mt-2 text-sm text-gray-600">Alamat: {{ $order->address }}</p>
                    @endif
                </div>
            @endforeach

            {{ $orders->links() }}
        </div>
    @endif

    <div class="mt-8 flex space-x-4">
        <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">← Kembali ke Menu</a>
        <a href="{{ route('orders.create.titip') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">+ Titip Beli</a>
    </div>
    <script>
    // Simulasi real-time update status setiap 10 detik
    setInterval(() => {
        axios.get('{{ route("orders.index") }}')
            .then(response => {
                // Di proyek nyata: update DOM secara dinamis
                // Untuk demo: cukup reload halaman jika ada perubahan
                console.log('Memeriksa update status...');
            })
            .catch(console.error);
    }, 10000);
</script>
</x-app-layout>