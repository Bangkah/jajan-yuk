    
    <x-app-layout>
    <div class="p-6 max-w-xl mx-auto">

        <h1 class="text-2xl font-bold mb-4">Tambah Menu</h1>

        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input name="nama" type="text" placeholder="Nama menu" class="w-full mb-3 p-2 border rounded">

            <textarea name="deskripsi" placeholder="Deskripsi" class="w-full mb-3 p-2 border rounded"></textarea>

            <input name="harga" type="number" placeholder="Harga" class="w-full mb-3 p-2 border rounded">

            <input type="file" name="gambar" class="w-full mb-3">

            <label class="flex items-center gap-2 mb-3">
                <input type="checkbox" name="promo">
                Promo Harian
            </label>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>

    </div>
</x-app-layout>
