<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production');
        Config::$isSanitized = (bool) config('midtrans.is_sanitized');
        Config::$is3ds = (bool) config('midtrans.is_3ds');
    }

    public function createSnapToken(Order $order): string
    {
        $order->load('items');

        $itemDetails = $order->items->map(function ($item) {
            return [
                'id' => (string) $item->product_id,
                'price' => (int) round($item->unit_price),
                'quantity' => (int) $item->quantity,
                'name' => \Illuminate\Support\Str::limit($item->product_name, 50),
            ];
        })->all();

        $grossAmount = (int) round($order->amount_to_pay);

        // Sesuaikan item_details agar total = gross_amount (syarat Midtrans)
        if (! empty($itemDetails)) {
            $itemDetails[0]['price'] = $grossAmount;
            $itemDetails[0]['quantity'] = 1;
            if (count($itemDetails) > 1) {
                $itemDetails = [$itemDetails[0]];
            }
        } else {
            $itemDetails = [[
                'id' => $order->order_number,
                'price' => $grossAmount,
                'quantity' => 1,
                'name' => 'Pesanan FurniBest',
            ]];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'phone' => $order->customer_phone,
                'email' => $order->customer_email ?: 'customer@furnibest.test',
                'shipping_address' => [
                    'address' => $order->customer_address,
                ],
            ],
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('checkout.finish', $order),
            ],
        ];

        // Tambahkan enabled payments dari config
        $enabledPayments = config('midtrans.enabled_payments');
        if (! empty($enabledPayments)) {
            $params['enabled_payments'] = $enabledPayments;
        }

        // Tambahkan konfigurasi credit card
        $creditCardConfig = config('midtrans.credit_card');
        if (! empty($creditCardConfig)) {
            $params['credit_card'] = $creditCardConfig;
        }

        // Tambahkan expiry settings
        $expiryConfig = config('midtrans.expiry');
        if (! empty($expiryConfig)) {
            $params['expiry'] = array_merge([
                'start_time' => date('Y-m-d H:i:s T'),
            ], $expiryConfig);
        }

        return Snap::getSnapToken($params);
    }

    public function parseNotification(): Notification
    {
        return new Notification();
    }

    public function mapOrderStatus(string $transactionStatus, ?string $fraudStatus = null): string
    {
        if (in_array($transactionStatus, ['capture', 'settlement'], true)) {
            if ($transactionStatus === 'capture' && $fraudStatus && $fraudStatus !== 'accept') {
                return Order::STATUS_PENDING;
            }

            return Order::STATUS_PAID;
        }

        if (in_array($transactionStatus, ['deny', 'cancel'], true)) {
            return Order::STATUS_FAILED;
        }

        if ($transactionStatus === 'expire') {
            return Order::STATUS_EXPIRED;
        }

        return Order::STATUS_PENDING;
    }
}
