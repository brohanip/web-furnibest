<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('items')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->appends($request->query());

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'bankAccount']);

        return view('admin.orders.show', compact('order'));
    }

    public function confirmPayment(Order $order)
    {
        if ($order->payment_method !== 'transfer') {
            return back()->with('error', 'Hanya pesanan transfer manual yang dikonfirmasi dari sini.');
        }

        if ($order->isPaid()) {
            return back()->with('error', 'Pesanan ini sudah dibayar.');
        }

        if ($order->status !== Order::STATUS_PENDING) {
            return back()->with('error', 'Status pesanan tidak dapat dikonfirmasi.');
        }

        DB::transaction(function () use ($order) {
            $order->update([
                'status' => Order::STATUS_PAID,
                'paid_at' => now(),
            ]);

            $this->decrementStock($order);
        });

        return back()->with('success', 'Pembayaran dikonfirmasi. Stok telah dikurangi.');
    }

    private function decrementStock(Order $order): void
    {
        foreach ($order->items as $item) {
            if (! $item->product_id) {
                continue;
            }

            $product = Product::find($item->product_id);

            if ($product && $product->stock > 0) {
                $product->decrement('stock', min($item->quantity, $product->stock));
            }
        }
    }
}
