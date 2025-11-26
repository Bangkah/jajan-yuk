<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-4 rounded shadow text-center">
            <p class="text-2xl font-bold text-green-600">{{ \App\Models\Order::count() }}</p>
            <p class="text-gray-600">Total Pesanan</p>
        </div>
        <div class="bg-white p-4 rounded shadow text-center">
            <p class="text-2xl font-bold text-blue-600">{{ \App\Models\Menu::count() }}</p>
            <p class="text-gray-600">Total Menu</p>
        </div>
        <div class="bg-white p-4 rounded shadow text-center">
            <p class="text-2xl font-bold text-purple-600">{{ \App\Models\Category::count() }}</p>
            <p class="text-gray-600">Kategori</p>
        </div>
        <div class="bg-white p-4 rounded shadow text-center">
            <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\Promo::where('start_date', '<=', now())->where('end_date', '>=', now())->count() }}</p>
            <p class="text-gray-600">Promo Aktif</p>
        </div>
    </div>

    <!-- Menu Cepat -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.menus.index') }}" class="block p-4 bg-green-100 hover:bg-green-200 rounded text-green-800 font-medium text-center">Kelola Menu</a>
        <a href="{{ route('admin.categories.index') }}" class="block p-4 bg-blue-100 hover:bg-blue-200 rounded text-blue-800 font-medium text-center">Kelola Kategori</a>
        <a href="{{ route('admin.promos.index') }}" class="block p-4 bg-purple-100 hover:bg-purple-200 rounded text-purple-800 font-medium text-center">Kelola Promo</a>
        <a href="{{ route('admin.orders.index') }}" class="block p-4 bg-yellow-100 hover:bg-yellow-200 rounded text-yellow-800 font-medium text-center">Kelola Pesanan</a>
    </div>
</x-app-layout>