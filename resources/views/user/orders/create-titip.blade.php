<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Layanan Titip Beli</h1>
    <p class="text-gray-600 mb-6">Contoh: "marlong sebungkus", "bakso goreng tempat si bos"</p>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <input type="hidden" name="type" value="titip">

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Nama Barang yang Ingin Dititip</label>
            <input type="text" name="items[0][item_name]" required
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Contoh: Marlong Sebungkus">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                <input type="number" name="items[0][qty]" value="1" min="1" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Perkiraan Harga (Rp)</label>
                <input type="number" name="items[0][price]" value="15000" min="1000" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                    placeholder="15000">
                <p class="text-sm text-gray-500 mt-1">Admin akan mengonfirmasi harga sebenarnya.</p>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Alamat Pengiriman</label>
            <textarea name="address" required rows="3"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Contoh: Gedung TIK, Lantai 1, Poltek">{{ auth()->user()->name ?? '' }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Catatan Tambahan (Opsional)</label>
            <textarea name="notes" rows="2"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Contoh: kalau gak ada marlong mild aja"></textarea>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Ajukan Titip Beli
            </button>
            <a href="{{ route('orders.index') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                Batal
            </a>
        </div>
    </form>
</x-app-layout>