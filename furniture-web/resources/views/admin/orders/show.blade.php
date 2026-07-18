@extends('admin.layouts.app')

@section('title', $order->order_number . ' • Admin')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-slate-600 hover:text-slate-900">← Daftar pesanan</a>
        <h1 class="mt-4 text-2xl font-bold">{{ $order->order_number }}</h1>
        <p class="mt-1 text-sm text-slate-600">Status: <span class="capitalize">{{ $order->status }}</span> · {{ $order->payment_method_label }}</p>

        @if (session('success'))
            <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ session('error') }}</div>
        @endif

        @if ($order->isTransfer() && $order->status === 'pending')
            <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST" class="mt-4" onsubmit="return confirm('Konfirmasi pembayaran transfer sudah diterima? Stok akan dikurangi.');">
                @csrf
                <button type="submit" class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">Konfirmasi pembayaran transfer</button>
            </form>
        @endif

        <div class="mt-6 grid gap-4 rounded-2xl border border-slate-200/70 bg-white p-6 text-sm shadow-sm">
            <div class="grid gap-4 sm:grid-cols-2">
                <div><span class="text-slate-500">Pelanggan</span><div class="font-medium">{{ $order->customer_name }}</div></div>
                <div><span class="text-slate-500">Telepon</span><div class="font-medium">{{ $order->customer_phone }}</div></div>
                <div class="sm:col-span-2"><span class="text-slate-500">Alamat</span><div class="font-medium">{{ $order->customer_address }}</div></div>
            </div>
            <hr>
            <div class="grid gap-2 sm:grid-cols-3">
                <div><span class="text-slate-500">Subtotal</span><div class="font-semibold">{{ $order->formatted_subtotal }}</div></div>
                <div><span class="text-slate-500">Dibayar</span><div class="font-semibold">{{ $order->formatted_amount_to_pay }}</div></div>
                <div><span class="text-slate-500">Sisa</span><div class="font-semibold">{{ $order->formatted_remaining_amount }}</div></div>
            </div>
            <div><span class="text-slate-500">Tipe</span><div>{{ $order->payment_type_label }}</div></div>
            @if ($order->bankAccount)
                <div class="sm:col-span-2 rounded-xl border border-slate-100 bg-slate-50 p-3">
                    <span class="text-slate-500">Rekening tujuan</span>
                    <div class="mt-1 font-medium">{{ $order->bankAccount->bank_name }} — {{ $order->bankAccount->account_number }} ({{ $order->bankAccount->account_holder }})</div>
                </div>
            @endif
            @if ($order->transfer_note)
                <div><span class="text-slate-500">Catatan transfer pelanggan</span><div>{{ $order->transfer_note }}</div></div>
            @endif
            @if ($order->notes)<div><span class="text-slate-500">Catatan pesanan</span><div>{{ $order->notes }}</div></div>@endif
            @if ($order->midtrans_transaction_id)
                <div class="text-xs text-slate-500">Midtrans ID: {{ $order->midtrans_transaction_id }} ({{ $order->midtrans_transaction_status }})</div>
            @endif
        </div>

        <div class="mt-4 rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
            <h2 class="font-semibold">Item</h2>
            @foreach ($order->items as $item)
                <div class="mt-3 border-t pt-3 text-sm">
                    {{ $item->product_name }} — {{ $item->formatted_line_total }}
                </div>
            @endforeach
        </div>
    </section>
@endsection
