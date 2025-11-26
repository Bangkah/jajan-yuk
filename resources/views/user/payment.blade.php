<x-app-layout>
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold text-center mb-6">Scan QR untuk Bayar</h2>
        
        <div class="flex justify-center mb-4">
            <!-- Placeholder QRIS -->
            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-48 h-48 flex items-center justify-center">
                <span class="text-gray-500 text-sm">QRIS Placeholder</span>
            </div>
        </div>

        <p class="text-center text-gray-700 mb-2">Total: <span class="font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
        <p class="text-center text-sm text-gray-500 mb-6">Scan dengan aplikasi e-wallet kamu</p>

        <form action="{{ route('orders.confirm-payment', $order) }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                Konfirmasi Pembayaran
            </button>
        </form>

        <a href="{{ route('orders.index') }}" class="block text-center mt-4 text-gray-600 hover:text-green-600">
            ← Kembali ke Riwayat
        </a>
    </div>
</x-app-layout>