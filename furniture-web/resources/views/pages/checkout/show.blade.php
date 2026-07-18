@extends('layouts.app')

@section('title', 'Pesanan ' . $order->order_number)

@section('content')
    <section class="mx-auto max-w-2xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold tracking-tight">Detail pesanan</h1>
        <p class="mt-1 text-sm text-slate-600">{{ $order->order_number }}</p>

        @if (session('error'))
            <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ session('error') }}</div>
        @endif

        @php
            $statusColors = [
                'paid' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                'pending' => 'bg-amber-50 text-amber-800 border-amber-200',
                'failed' => 'bg-rose-50 text-rose-800 border-rose-200',
                'expired' => 'bg-slate-100 text-slate-700 border-slate-200',
                'cancelled' => 'bg-slate-100 text-slate-700 border-slate-200',
            ];
            $statusLabels = [
                'paid' => 'Lunas / DP terbayar',
                'pending' => 'Menunggu pembayaran',
                'failed' => 'Gagal',
                'expired' => 'Kedaluwarsa',
                'cancelled' => 'Dibatalkan',
            ];
        @endphp

        <div class="mt-6 rounded-2xl border {{ $statusColors[$order->status] ?? 'border-slate-200' }} px-4 py-3 text-sm font-semibold">
            {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
            @if ($order->isDp() && $order->isPaid() && $order->remaining_amount > 0)
                — sisa {{ $order->formatted_remaining_amount }} akan dikonfirmasi tim kami
            @endif
        </div>

        <div class="mt-6 grid gap-4 rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm text-sm">
            <div><span class="text-slate-500">Nama</span><div class="font-medium">{{ $order->customer_name }}</div></div>
            <div><span class="text-slate-500">Telepon</span><div class="font-medium">{{ $order->customer_phone }}</div></div>
            <div><span class="text-slate-500">Alamat</span><div class="font-medium">{{ $order->customer_address }}</div></div>
            <div><span class="text-slate-500">Metode</span><div class="font-medium">{{ $order->payment_method_label }}</div></div>
            <div><span class="text-slate-500">Pembayaran</span><div class="font-medium">{{ $order->payment_type_label }} — {{ $order->formatted_amount_to_pay }}</div></div>
            @if ($order->bankAccount)
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-3">
                    <span class="text-slate-500">Rekening tujuan</span>
                    <div class="mt-1 font-medium">{{ $order->bankAccount->bank_name }} — {{ $order->bankAccount->account_number }} ({{ $order->bankAccount->account_holder }})</div>
                </div>
            @endif
        </div>

        <div class="mt-4 rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold text-slate-800">Produk</h2>
            @foreach ($order->items as $item)
                <div class="mt-3 border-t border-slate-100 pt-3">
                    <div class="font-medium">{{ $item->product_name }}</div>
                    @if ($item->product_size)<div class="text-xs text-slate-500">{{ $item->product_size }}</div>@endif
                    <div class="text-sm text-slate-600">{{ $item->formatted_line_total }}</div>
                </div>
            @endforeach
        </div>

        @if ($order->status === 'pending')
            @if ($order->isTransfer())
                <a href="{{ route('checkout.transfer', $order) }}" class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Lihat instruksi transfer
                </a>
            @elseif ($order->snap_token)
                <a href="{{ route('checkout.pay', $order) }}" class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Lanjutkan pembayaran
                </a>
            @endif
        @endif
    </section>
@endsection
