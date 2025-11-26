<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('user', 'items.menu.category');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:new,processing,delivering,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update status
        $order->update(['status' => $request->status]);

        // Kirim notifikasi ke user
        $order->user->notify(new OrderStatusUpdated($order));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Status pesanan diperbarui & notifikasi dikirim!');
    }
}