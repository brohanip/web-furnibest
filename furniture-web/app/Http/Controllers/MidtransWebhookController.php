<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request, MidtransService $midtrans)
    {
        try {
            $notification = $midtrans->parseNotification();

            $orderNumber = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? null;

            $order = Order::where('order_number', $orderNumber)->first();

            if (! $order) {
                Log::warning('Midtrans webhook: order not found', ['order_id' => $orderNumber]);

                return response()->json(['message' => 'Order not found'], 404);
            }

            $newStatus = $midtrans->mapOrderStatus($transactionStatus, $fraudStatus);

            DB::transaction(function () use ($order, $notification, $newStatus) {
                $wasPaid = $order->isPaid();

                $order->update([
                    'midtrans_transaction_id' => $notification->transaction_id ?? $order->midtrans_transaction_id,
                    'midtrans_payment_type' => $notification->payment_type ?? $order->midtrans_payment_type,
                    'midtrans_transaction_status' => $notification->transaction_status,
                    'status' => $newStatus,
                    'paid_at' => $newStatus === Order::STATUS_PAID ? now() : $order->paid_at,
                ]);

                if ($newStatus === Order::STATUS_PAID && ! $wasPaid) {
                    $this->decrementStock($order);
                }
            });

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error('Midtrans webhook error', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Error'], 500);
        }
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
