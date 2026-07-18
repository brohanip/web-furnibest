@extends('layouts.app')

@section('title', 'Keranjang • FurniBest')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold tracking-tight">Keranjang belanja</h1>
        <p class="mt-2 text-sm text-slate-600">{{ $lines->count() }} jenis produk di keranjang.</p>

        @if (session('success'))
            <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ session('error') }}</div>
        @endif

        @if ($lines->isEmpty())
            <div class="mt-8 rounded-2xl border border-slate-200/60 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-slate-600">Keranjang masih kosong.</p>
                <a href="{{ route('products') }}" class="mt-4 inline-flex rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Lihat katalog produk
                </a>
            </div>
        @else
            <div class="mt-6 grid gap-4">
                @foreach ($lines as $line)
                    <div class="flex flex-col gap-4 rounded-2xl border border-slate-200/60 bg-white p-4 shadow-sm sm:flex-row sm:items-center">
                        <a href="{{ route('products.show', $line->product) }}" class="flex shrink-0 gap-4">
                            @if ($line->product->image_url)
                                <img src="{{ $line->product->image_url }}" alt="" class="h-20 w-20 rounded-xl object-contain bg-white border border-slate-200">
                            @else
                                <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-slate-100 text-xs text-slate-400">Tanpa gambar</div>
                            @endif
                            <div class="min-w-0 sm:hidden">
                                <div class="font-semibold text-slate-900">{{ $line->product->name }}</div>
                                <div class="text-sm text-slate-600">{{ $line->formatted_line_total }}</div>
                            </div>
                        </a>

                        <div class="min-w-0 flex-1 hidden sm:block">
                            <a href="{{ route('products.show', $line->product) }}" class="font-semibold text-slate-900 hover:text-brand-800">{{ $line->product->name }}</a>
                            @if ($line->product->size)
                                <div class="text-xs text-slate-500">{{ $line->product->size }}</div>
                            @endif
                            <div class="mt-1 text-sm text-slate-600">Rp {{ number_format($line->product->price, 0, ',', '.') }} / item</div>
                            @unless ($line->stock_ok)
                                <p class="mt-1 text-xs text-rose-600">Stok tidak mencukupi (tersedia {{ $line->product->stock }})</p>
                            @endunless
                        </div>

                        <div class="flex items-center justify-between gap-4 sm:justify-end">
                            <form action="{{ route('cart.update', $line->product) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label class="text-xs text-slate-500">Qty</label>
                                <input type="number" name="quantity" value="{{ $line->quantity }}" min="0" max="{{ $line->max_quantity }}" class="w-16 rounded-lg border border-slate-200 px-2 py-1 text-sm">
                                <button type="submit" class="rounded-lg border border-slate-200 px-2 py-1 text-xs font-semibold hover:bg-slate-50">Update</button>
                            </form>

                            <div class="text-right">
                                <div class="hidden text-sm font-semibold sm:block">{{ $line->formatted_line_total }}</div>
                                <form action="{{ route('cart.destroy', $line->product) }}" method="POST" class="mt-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between text-lg font-bold">
                    <span>Subtotal</span>
                    <span>{{ $formattedSubtotal }}</span>
                </div>
                <p class="mt-2 text-xs text-slate-500">Ongkir dan biaya lain akan dikonfirmasi setelah pemesanan.</p>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    @auth
                        <a href="{{ route('checkout.cart') }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                            Checkout
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                            Masuk untuk checkout
                        </a>
                    @endauth
                    <a href="{{ route('products') }}" class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Lanjut belanja
                    </a>
                </div>
            </div>
        @endif
    </section>
@endsection
