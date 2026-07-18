@extends('layouts.app')

@section('title', 'Instruksi Transfer • ' . $order->order_number)

@section('content')
    <section class="mx-auto max-w-2xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold tracking-tight">Transfer bank</h1>
        <p class="mt-2 text-sm text-slate-600">Selesaikan pembayaran sesuai detail di bawah.</p>

        @if (session('success'))
            <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
            Status: <strong>Menunggu konfirmasi pembayaran</strong>. Pesanan diproses setelah admin memverifikasi transfer Anda.
        </div>

        <div class="mt-4 rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <div class="text-xs font-semibold uppercase text-slate-500">Nomor pesanan</div>
            <div class="mt-1 text-xl font-bold text-slate-900">{{ $order->order_number }}</div>
            <div class="mt-4 text-2xl font-bold text-brand-800">{{ $order->formatted_amount_to_pay }}</div>
            <div class="mt-1 text-sm text-slate-600">{{ $order->payment_type_label }}</div>
            @if ($order->remaining_amount > 0)
                <p class="mt-2 text-sm text-amber-700">Sisa pelunasan: {{ $order->formatted_remaining_amount }}</p>
            @endif
        </div>

        @if ($order->bankAccount)
            <div class="mt-4 rounded-2xl border-2 border-brand-200 bg-brand-50 p-6">
                <h2 class="text-sm font-semibold text-brand-900">Transfer ke rekening berikut</h2>
                <dl class="mt-4 grid gap-3 text-sm">
                    <div>
                        <dt class="text-slate-500">Bank</dt>
                        <dd class="text-lg font-bold text-slate-900">{{ $order->bankAccount->bank_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Nomor rekening</dt>
                        <dd class="font-mono text-lg font-bold text-slate-900">{{ $order->bankAccount->account_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Atas nama</dt>
                        <dd class="font-semibold text-slate-900">{{ $order->bankAccount->account_holder }}</dd>
                    </div>
                </dl>
                <p class="mt-4 text-xs text-slate-600">Cantumkan <strong>{{ $order->order_number }}</strong> di berita transfer agar mudah diverifikasi.</p>
            </div>
        @endif

        <div class="mt-4 rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold text-slate-800">Konfirmasi (opsional)</h2>
            <p class="mt-1 text-xs text-slate-500">Isi jika sudah transfer — membantu admin memverifikasi lebih cepat.</p>
            <form action="{{ route('checkout.transfer.confirm', $order) }}" method="POST" class="mt-4 grid gap-3">
                @csrf
                <div>
                    <label class="mb-1 block text-xs font-semibold text-slate-600">Nama pengirim / no. referensi</label>
                    <input type="text" name="transfer_note" value="{{ old('transfer_note', $order->transfer_note) }}" placeholder="Contoh: Budi / TRF12345" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                </div>
                <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Saya sudah transfer</button>
            </form>
        </div>

        <div class="mt-6 flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('checkout.show', $order) }}" class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Detail pesanan</a>
            <a href="{{ route('orders.mine') }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Pesanan saya</a>
        </div>
    </section>
@endsection
