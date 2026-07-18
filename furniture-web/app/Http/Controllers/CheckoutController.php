<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function create(Product $product)
    {
        if ($product->stock <= 0) {
            return redirect()->route('products.show', $product)
                ->with('error', 'Produk ini sedang habis stok.');
        }

        $user = auth()->user();
        $paymentData = $this->checkoutPaymentData();

        // Tidak perlu validasi midtransEnabled karena sekarang selalu true (untuk tampilkan opsi)
        // Validasi akan dilakukan saat submit

        return view('pages.checkout.create', array_merge(compact('product', 'user'), $paymentData));
    }

    public function createFromCart(CartService $cart)
    {
        $cart->pruneUnavailable();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $errors = $cart->stockErrors();

        if (! empty($errors)) {
            return redirect()->route('cart.index')->with('error', implode(' ', $errors));
        }

        $paymentData = $this->checkoutPaymentData();

        // Tidak perlu validasi midtransEnabled karena sekarang selalu true (untuk tampilkan opsi)
        // Validasi akan dilakukan saat submit

        return view('pages.checkout.cart-create', array_merge([
            'lines' => $cart->lines(),
            'subtotal' => $cart->subtotal(),
            'formattedSubtotal' => $cart->formattedSubtotal(),
            'user' => auth()->user(),
        ], $paymentData));
    }

    public function store(Request $request, MidtransService $midtrans, CartService $cart)
    {
        $dpOptions = config('midtrans.dp_options', [30, 50]);
        $user = $request->user();
        $midtransConfigured = ! empty(config('midtrans.server_key'));

        $validated = $request->validate([
            'from_cart' => 'nullable|boolean',
            'product_id' => 'required_without:from_cart|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:30',
            'customer_address' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:midtrans,transfer',
            'bank_account_id' => 'required_if:payment_method,transfer|nullable|exists:bank_accounts,id',
            'payment_type' => 'required|in:full,dp',
            'dp_percent' => 'required_if:payment_type,dp|nullable|integer|in:' . implode(',', $dpOptions),
        ]);

        // Validasi Midtrans sudah dikonfigurasi
        if ($validated['payment_method'] === 'midtrans' && ! $midtransConfigured) {
            return back()->withInput()->with('error', 'Pembayaran Midtrans belum dikonfigurasi. Silakan gunakan Transfer Bank Manual atau hubungi admin. Panduan setup: lihat file GET_MIDTRANS_CREDENTIALS.md');
        }

        if ($validated['payment_method'] === 'transfer') {
            $bank = BankAccount::active()->find($validated['bank_account_id']);
            if (! $bank) {
                return back()->withInput()->with('error', 'Rekening bank tidak valid atau tidak aktif.');
            }
        }

        if ($request->boolean('from_cart')) {
            return $this->storeFromCart($request, $midtrans, $cart, $validated, $user);
        }

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock <= 0) {
            return back()->withInput()->with('error', 'Produk habis stok.');
        }

        $cartLines = collect([(object) [
            'product' => $product,
            'quantity' => 1,
        ]]);

        return $this->placeOrder($request, $midtrans, $validated, $user, $cartLines, null);
    }

    private function storeFromCart(Request $request, MidtransService $midtrans, CartService $cart, array $validated, $user)
    {
        $cart->pruneUnavailable();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $errors = $cart->stockErrors();

        if (! empty($errors)) {
            return back()->withInput()->with('error', implode(' ', $errors));
        }

        return $this->placeOrder($request, $midtrans, $validated, $user, $cart->lines(), $cart);
    }

    private function placeOrder(Request $request, MidtransService $midtrans, array $validated, $user, $cartLines, ?CartService $cartToClear)
    {
        $subtotal = $cartLines->sum(fn ($line) => (float) $line->product->price * $line->quantity);

        if ($validated['payment_type'] === 'dp') {
            $dpPercent = (int) $validated['dp_percent'];
            $amountToPay = floor($subtotal * $dpPercent / 100);
            $remaining = $subtotal - $amountToPay;
        } else {
            $dpPercent = null;
            $amountToPay = $subtotal;
            $remaining = 0;
        }

        if ($amountToPay < 1) {
            return back()->withInput()->with('error', 'Nominal pembayaran tidak valid.');
        }

        $paymentMethod = $validated['payment_method'];
        $bankAccountId = $paymentMethod === 'transfer' ? $validated['bank_account_id'] : null;

        try {
            $order = DB::transaction(function () use ($validated, $cartLines, $subtotal, $amountToPay, $remaining, $dpPercent, $user, $paymentMethod, $bankAccountId) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'order_number' => Order::generateOrderNumber(),
                    'customer_name' => $validated['customer_name'],
                    'customer_phone' => $validated['customer_phone'],
                    'customer_email' => $user->email,
                    'customer_address' => $validated['customer_address'],
                    'notes' => $validated['notes'] ?? null,
                    'payment_method' => $paymentMethod,
                    'bank_account_id' => $bankAccountId,
                    'payment_type' => $validated['payment_type'],
                    'dp_percent' => $dpPercent,
                    'subtotal' => $subtotal,
                    'amount_to_pay' => $amountToPay,
                    'remaining_amount' => $remaining,
                    'status' => Order::STATUS_PENDING,
                ]);

                foreach ($cartLines as $line) {
                    $order->items()->create([
                        'product_id' => $line->product->id,
                        'product_name' => $line->product->name,
                        'product_size' => $line->product->size,
                        'unit_price' => $line->product->price,
                        'quantity' => $line->quantity,
                    ]);
                }

                if ($validated['customer_phone'] && $user->phone !== $validated['customer_phone']) {
                    $user->update(['phone' => $validated['customer_phone']]);
                }

                return $order;
            });

            if ($cartToClear) {
                $cartToClear->clear();
            }

            if ($paymentMethod === 'transfer') {
                return redirect()->route('checkout.transfer', $order);
            }

            // Try to create Midtrans snap token
            try {
                if (! config('midtrans.server_key')) {
                    throw new \Exception('Midtrans not configured');
                }

                $snapToken = $midtrans->createSnapToken($order);
                $order->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                // Log error tapi tetap lanjut ke halaman pay dengan pesan
                \Log::warning('Failed to create Midtrans snap token: ' . $e->getMessage());
                $order->update(['snap_token' => null]);
            }

            return redirect()->route('checkout.pay', $order);
        } catch (\Exception $e) {
            report($e);

            return back()->withInput()->with('error', 'Gagal membuat pesanan. Coba lagi.');
        }
    }

    public function transfer(Order $order)
    {
        $this->authorizeOrder($order);

        if ($order->payment_method !== 'transfer') {
            return redirect()->route('checkout.show', $order);
        }

        $order->load(['items', 'bankAccount']);

        return view('pages.checkout.transfer', compact('order'));
    }

    public function confirmTransfer(Request $request, Order $order)
    {
        $this->authorizeOrder($order);

        if ($order->payment_method !== 'transfer') {
            abort(404);
        }

        $validated = $request->validate([
            'transfer_note' => 'nullable|string|max:255',
        ]);

        $order->update([
            'transfer_note' => $validated['transfer_note'] ?? $order->transfer_note,
        ]);

        return redirect()->route('checkout.transfer', $order)
            ->with('success', 'Terima kasih. Tim kami akan segera memverifikasi pembayaran Anda.');
    }

    public function pay(Order $order)
    {
        $this->authorizeOrder($order);

        if ($order->payment_method === 'transfer') {
            return redirect()->route('checkout.transfer', $order);
        }

        if ($order->isPaid()) {
            return redirect()->route('checkout.show', $order);
        }

        // Jika snap token ada → gunakan Midtrans Snap asli
        if ($order->snap_token) {
            return view('pages.checkout.pay', [
                'order' => $order->load('items'),
                'clientKey' => config('midtrans.client_key'),
                'snapToken' => $order->snap_token,
                'isProduction' => config('midtrans.is_production'),
                'demoMode' => false,
            ]);
        }

        // Tidak ada snap token → tampilkan halaman simulasi pembayaran
        return view('pages.checkout.pay', [
            'order' => $order->load('items'),
            'clientKey' => config('midtrans.client_key'),
            'snapToken' => null,
            'isProduction' => false,
            'demoMode' => true,
            // Generate VA dan QR simulasi berdasarkan order number
            'simulasi' => [
                'bca_va'  => '70012' . str_pad($order->id, 11, '0', STR_PAD_LEFT),
                'bni_va'  => '8808' . str_pad($order->id, 12, '0', STR_PAD_LEFT),
                'bri_va'  => '26215' . str_pad($order->id, 11, '0', STR_PAD_LEFT),
                'mandiri' => '7093' . str_pad($order->id, 12, '0', STR_PAD_LEFT),
                'qris_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode('SIMULASI-QRIS-' . $order->order_number . '-' . $order->amount_to_pay),
            ],
        ]);
    }

    public function simulatePay(Request $request, Order $order)
    {
        $this->authorizeOrder($order);

        if ($order->isPaid()) {
            return redirect()->route('checkout.finish', $order);
        }

        // Tandai order sebagai paid (simulasi)
        DB::transaction(function () use ($order, $request) {
            $order->update([
                'status' => Order::STATUS_PAID,
                'midtrans_transaction_id' => 'DEMO-' . strtoupper(uniqid()),
                'midtrans_payment_type' => $request->input('method', 'demo'),
                'midtrans_transaction_status' => 'settlement',
                'paid_at' => now(),
            ]);

            // Decrement stock
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    $product = \App\Models\Product::find($item->product_id);
                    if ($product && $product->stock > 0) {
                        $product->decrement('stock', min($item->quantity, $product->stock));
                    }
                }
            }
        });

        return redirect()->route('checkout.finish', $order);
    }

    public function finish(Order $order)
    {
        $this->authorizeOrder($order);
        $order->load('items');

        return view('pages.checkout.finish', compact('order'));
    }

    public function show(Order $order)
    {
        $this->authorizeOrder($order);
        $order->load(['items', 'bankAccount']);

        return view('pages.checkout.show', compact('order'));
    }

    public function myOrders()
    {
        $orders = auth()->user()
            ->orders()
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('pages.checkout.my-orders', compact('orders'));
    }

    private function checkoutPaymentData(): array
    {
        return [
            'bankAccounts' => BankAccount::active()->ordered()->get(),
            'midtransEnabled' => true, // Selalu tampilkan opsi Midtrans
            'midtransConfigured' => ! empty(config('midtrans.server_key')), // Status konfigurasi
            'dpOptions' => config('midtrans.dp_options', [30, 50]),
        ];
    }

    private function authorizeOrder(Order $order): void
    {
        if (! $order->belongsToUser(auth()->id())) {
            abort(403);
        }
    }
}
