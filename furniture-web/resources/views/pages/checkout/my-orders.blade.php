@extends('layouts.app')

@section('title', 'Pesanan Saya • FurniBest')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold tracking-tight">Pesanan saya</h1>
        <p class="mt-2 text-sm text-slate-600">Riwayat pesanan akun {{ auth()->user()->name }}.</p>

        @if ($orders->isEmpty())
            <div class="mt-8 rounded-2xl border border-slate-200/60 bg-white p-8 text-center text-sm text-slate-500">
                Belum ada pesanan. <a href="{{ route('products') }}" class="font-semibold text-brand-800 hover:underline">Lihat produk</a>
            </div>
        @else
            <div class="mt-6 grid gap-4">
                @foreach ($orders as $order)
                    <a href="{{ route('checkout.show', $order) }}" class="block rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition hover:border-slate-300">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="font-semibold text-slate-900">{{ $order->order_number }}</div>
                                <div class="mt-1 text-sm text-slate-600">{{ $order->items->first()?->product_name }}</div>
                                <div class="mt-2 text-sm">{{ $order->payment_method_label }} · {{ $order->payment_type_label }} — {{ $order->formatted_amount_to_pay }}</div>
                            </div>
                            <span class="rounded-full px-2 py-1 text-xs font-semibold capitalize {{ $order->status === 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-800' }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-6">{{ $orders->links() }}</div>
        @endif
    </section>
@endsection
