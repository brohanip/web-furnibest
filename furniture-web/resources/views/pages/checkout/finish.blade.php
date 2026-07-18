@extends('layouts.app')

@section('title', 'Selesai • ' . $order->order_number)

@section('content')
    <section class="mx-auto max-w-lg px-4 py-12 sm:px-6 lg:px-8 text-center">
        @if ($order->isPaid())
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="mt-4 text-2xl font-bold">Pembayaran berhasil</h1>
        @elseif ($order->status === 'pending')
            <h1 class="mt-4 text-2xl font-bold">Menunggu pembayaran</h1>
            <p class="mt-2 text-sm text-slate-600">Jika sudah bayar, status akan diperbarui dalam beberapa menit.</p>
        @else
            <h1 class="mt-4 text-2xl font-bold">Status pesanan</h1>
        @endif

        <p class="mt-2 text-sm text-slate-600">No. pesanan: <span class="font-semibold">{{ $order->order_number }}</span></p>

        <div class="mt-6 rounded-2xl border border-slate-200/60 bg-white p-6 text-left text-sm shadow-sm">
            <div class="flex justify-between"><span class="text-slate-500">Total produk</span><span>{{ $order->formatted_subtotal }}</span></div>
            <div class="mt-2 flex justify-between"><span class="text-slate-500">Dibayar sekarang</span><span class="font-semibold">{{ $order->formatted_amount_to_pay }}</span></div>
            @if ($order->remaining_amount > 0)
                <div class="mt-2 flex justify-between text-amber-700"><span>Sisa pelunasan</span><span class="font-semibold">{{ $order->formatted_remaining_amount }}</span></div>
            @endif
        </div>

        <div class="mt-6 flex flex-col gap-2">
            <a href="{{ route('checkout.show', $order) }}" class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Detail pesanan</a>
            <a href="{{ route('home') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali ke home</a>
        </div>
    </section>
@endsection
