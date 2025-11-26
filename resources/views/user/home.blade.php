<x-app-layout>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang di Yuk Jajan! 🍜</h1>
        <p class="text-gray-600">
            @if($recommendations['is_morning'])
                Selamat pagi! Yuk, mulai hari dengan kopi segar ☕
            @elseif($recommendations['is_night'])
                Malam-malam enaknya mie atau camilan! 🌙
            @else
                Waktunya makan siang! Pilih menu favoritmu 🍛
            @endif
        </p>
    </div>

    {{-- Promo Hari Ini --}}
    @if($recommendations['promo']->isNotEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-8 rounded">
            <h2 class="text-xl font-bold text-yellow-700">🔥 Promo Hari Ini</h2>
            @foreach($recommendations['promo'] as $promo)
                <p class="text-yellow-600">{{ $promo->title }}</p>
                @if($promo->menu)
                    <p>Diskon {{ $promo->discount_percent }}% untuk <strong>{{ $promo->menu->name }}</strong></p>
                @else
                    <p>Promo berlaku untuk semua menu!</p>
                @endif
            @endforeach
        </div>
    @endif

    {{-- Rekomendasi Waktu --}}
    @if($recommendations['time_based']->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                @if($recommendations['is_morning']) Rekomendasi Pagi
                @elseif($recommendations['is_night']) Rekomendasi Malam
                @else Rekomendasi Siang
                @endif
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($recommendations['time_based'] as $menu)
                    <x-menu-card :menu="$menu" />
                @endforeach
            </div>
        </div>
    @endif

    {{-- Terlaris --}}
    @if($recommendations['top']->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Terlaris Minggu Ini</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                @foreach($recommendations['top'] as $menu)
                    <x-menu-card :menu="$menu" />
                @endforeach
            </div>
        </div>
    @endif

    {{-- Semua Menu --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Semua Menu</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($menus as $menu)
                <x-menu-card :menu="$menu" />
            @endforeach
        </div>
        {{ $menus->links() }}
    </div>
</x-app-layout>