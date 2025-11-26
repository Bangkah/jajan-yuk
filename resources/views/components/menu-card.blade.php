@props(['menu'])

<div class="border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
    <div class="p-4">
        <h3 class="font-bold text-lg">{{ $menu->name }}</h3>
        <p class="text-gray-600 text-sm mt-1">{{ $menu->description ?? '-' }}</p>
        
        {{-- Hitung harga akhir berdasarkan promo aktif hari ini --}}
        @php
            $today = now()->toDateString();
            $activePromo = $menu->promos->first(function ($promo) use ($today) {
                return $promo->start_date <= $today && $promo->end_date >= $today;
            });

            $finalPrice = $menu->price;
            if ($activePromo) {
                $finalPrice = $menu->price * (1 - $activePromo->discount_percent / 100);
                $finalPrice = round($finalPrice);
            }
        @endphp

        <p class="text-green-600 font-bold mt-2">
            Rp {{ number_format($finalPrice, 0, ',', '.') }}
            @if($activePromo)
                <span class="text-sm line-through text-gray-500 ml-2">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </span>
            @endif
        </p>

        <span class="inline-block mt-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded">
            {{ $menu->category->name }}
        </span>

        <div class="mt-3">
            <form action="{{ route('orders.store') }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="type" value="food">
                <input type="hidden" name="items[0][menu_id]" value="{{ $menu->id }}">
                <input type="hidden" name="items[0][item_name]" value="{{ $menu->name }}">
                <input type="hidden" name="items[0][qty]" value="1">
                <input type="hidden" name="items[0][price]" value="{{ $finalPrice }}">
                <button type="submit" class="w-full px-3 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                    Pesan
                </button>
            </form>
        </div>
    </div>
</div>