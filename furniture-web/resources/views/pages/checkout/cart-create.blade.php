@extends('layouts.app')

@section('title', 'Checkout Keranjang • FurniBest')

@section('content')
    <section class="mx-auto max-w-2xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="mb-6 text-sm text-slate-500">
            <a href="{{ route('cart.index') }}" class="hover:text-slate-700">← Kembali ke keranjang</a>
        </nav>

        <h1 class="text-2xl font-bold tracking-tight">Checkout</h1>
        <p class="mt-2 text-sm text-slate-600">{{ $lines->count() }} produk — subtotal {{ $formattedSubtotal }}</p>

        @if (session('error'))
            <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ session('error') }}</div>
        @endif

        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200/60 bg-white shadow-sm">
            <div class="divide-y divide-slate-200/60 border-b border-slate-200/60">
                @foreach ($lines as $line)
                    <div class="flex gap-3 p-4">
                        @if ($line->product->image_url)
                            <img src="{{ $line->product->image_url }}" alt="" class="h-14 w-14 rounded-lg object-contain bg-white border border-slate-200">
                        @endif
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-semibold">{{ $line->product->name }}</div>
                            <div class="text-xs text-slate-500">{{ $line->quantity }} × Rp {{ number_format($line->product->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="text-sm font-semibold">{{ $line->formatted_line_total }}</div>
                    </div>
                @endforeach
            </div>

            <form action="{{ route('checkout.store') }}" method="POST" class="grid gap-4 p-5">
                @csrf
                <input type="hidden" name="from_cart" value="1">

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('customer_name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">WhatsApp / Telepon</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone', $user->phone) }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                        @error('customer_phone') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Email akun</label>
                        <input type="email" value="{{ $user->email }}" disabled class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-600">
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Alamat pengiriman</label>
                    <textarea name="customer_address" rows="3" required class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">{{ old('customer_address') }}</textarea>
                    @error('customer_address') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Catatan (opsional)</label>
                    <textarea name="notes" rows="2" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">{{ old('notes') }}</textarea>
                </div>

                @include('pages.checkout._payment-options', ['subtotal' => $subtotal])

                <button type="submit" class="w-full rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Buat pesanan
                </button>
            </form>
        </div>
    </section>
@endsection
