<x-app-layout>
    <div class="p-6">

        <a href="{{ route('menu.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah Menu
        </a>

        <div class="grid grid-cols-3 gap-4 mt-4">
            @foreach($menus as $menu)
            <div class="border rounded p-4">
                <img src="{{ asset('storage/'.$menu->image) }}" class="w-full h-40 object-cover rounded">

                <h2 class="text-xl font-bold mt-2">{{ $menu->nama }}</h2>
                <p class="text-gray-500">{{ $menu->deskripsi }}</p>
                <p class="font-semibold mt-1">Rp {{ number_format($menu->harga) }}</p>

                <div class="flex gap-2 mt-3">
                    <a href="{{ route('menu.edit', $menu->id) }}" 
                       class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>

                    <form action="{{ route('menu.destroy', $menu->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-3 py-1 rounded"
                                onclick="return confirm('Hapus menu ini?')">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
