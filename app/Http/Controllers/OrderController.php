<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('items.menu')->latest()->paginate(10);
        return view('user.orders.index', compact('orders'));
    }

    public function createTitip()
    {
        return view('user.orders.create-titip');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:food,titip',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required_if:type,food|exists:menus,id',
            'items.*.item_name' => 'required_if:type,titip|string|max:255',
            'items.*.qty' => 'required|integer|min:1|max:100',
            'items.*.price' => 'required|numeric|min:1000|max:1000000', // tetap divalidasi, tapi tidak dipakai untuk food
            'address' => 'required_if:type,titip|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        return DB::transaction(function () use ($request) {
            $total = 0;
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => 0, // sementara 0, akan diupdate
                'type' => $request->type,
                'notes' => $request->notes,
                'address' => $request->type === 'titip' ? $request->address : null,
                'status' => 'new'
            ]);

            foreach ($request->items as $itemData) {
                $menu = null;
                $item_name = '';
                $finalPrice = 0;

                if ($request->type === 'food') {
                    // Ambil data menu dari database (jangan percaya input)
                    $menu = Menu::where('id', $itemData['menu_id'])->where('is_available', true)->firstOrFail();
                    $item_name = $menu->name;

                    // Cek promo aktif hari ini untuk menu ini
                    $today = now()->toDateString();
                    $promo = Promo::where('applied_menu_id', $menu->id)
                        ->whereDate('start_date', '<=', $today)
                        ->whereDate('end_date', '>=', $today)
                        ->first();

                    $finalPrice = $promo 
                        ? round($menu->price * (1 - $promo->discount_percent / 100))
                        : $menu->price;

                } else {
                    // Titip beli: harga dari user (akan dikonfirmasi admin nanti)
                    $item_name = $itemData['item_name'];
                    $finalPrice = $itemData['price'];
                }

                $qty = $itemData['qty'];
                $subtotal = $finalPrice * $qty;
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu?->id,
                    'item_name' => $item_name,
                    'qty' => $qty,
                    'price' => $finalPrice
                ]);
            }

            // Update total price setelah semua item diproses
            $order->update(['total_price' => $total]);

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dibuat! Status: ' . $order->status);
        });
    }
}