@extends('layouts.app')

@section('title', $product->name . ' • FurniBest')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="mb-6 text-sm text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-slate-700">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products') }}" class="hover:text-slate-700">Produk</a>
            <span class="mx-2">/</span>
            <span class="text-slate-900">{{ $product->name }}</span>
        </nav>

        <div class="grid gap-10 lg:grid-cols-2">
            <div>
                @php
                    $galleryImages = $product->images->isNotEmpty()
                        ? $product->images
                        : ($product->image_url ? collect([(object) ['url' => $product->image_url]]) : collect());
                @endphp

                @if ($galleryImages->isNotEmpty())
                    <div class="overflow-hidden rounded-2xl border border-slate-200/60 bg-slate-100">
                        <img id="mainProductImage" src="{{ $galleryImages->first()->url }}" alt="{{ $product->name }}" class="aspect-[4/3] w-full object-contain bg-white">
                    </div>
                    @if ($galleryImages->count() > 1)
                        <div class="mt-3 grid grid-cols-4 gap-2 sm:grid-cols-5">
                            @foreach ($galleryImages as $index => $img)
                                <button
                                    type="button"
                                    class="product-thumb overflow-hidden rounded-xl border-2 {{ $index === 0 ? 'border-slate-900' : 'border-transparent' }} focus:outline-none focus:ring-2 focus:ring-brand-400"
                                    data-image="{{ $img->url }}"
                                >
                                    <img src="{{ $img->url }}" alt="" class="aspect-square w-full object-contain bg-white">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="flex aspect-[4/3] items-center justify-center rounded-2xl border border-slate-200/60 bg-slate-100 text-sm text-slate-400">
                        Tanpa gambar
                    </div>
                @endif
            </div>

            <div>
                @if ($product->categories->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($product->categories as $category)
                            <a href="{{ route('products', ['kategori' => $category->slug]) }}" class="rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-800 hover:bg-brand-100">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">{{ $product->name }}</h1>

                <div class="mt-4 text-2xl font-bold text-slate-900">{{ $product->formatted_price }}</div>

                @if ($product->size)
                    <dl class="mt-4 rounded-xl border border-slate-200/60 bg-slate-50 px-4 py-3">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Ukuran</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">{{ $product->size }}</dd>
                    </dl>
                @endif

                <div class="mt-2 text-sm text-slate-600">
                    @if ($product->stock > 0)
                        <span class="inline-flex items-center gap-1 text-emerald-700">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Stok tersedia ({{ $product->stock }})
                        </span>
                    @else
                        <span class="text-rose-600 font-medium">Stok habis</span>
                    @endif
                </div>

                @if ($product->description)
                    <div class="mt-6 border-t border-slate-200/60 pt-6">
                        <h2 class="text-sm font-semibold text-slate-900">Keterangan</h2>
                        <div class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $product->description }}</div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ session('error') }}</div>
                @endif

                @if ($product->stock > 0)
                    <form action="{{ route('cart.store') }}" method="POST" class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-end">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center gap-2">
                            <label class="text-sm font-semibold text-slate-700">Jumlah</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-20 rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        </div>
                        <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 sm:flex-none">
                            Tambahkan ke keranjang
                        </button>
                    </form>
                @endif

                <div class="mt-3 flex flex-col gap-3 sm:flex-row">
                    @if ($product->stock > 0)
                        @auth
                            <a href="{{ route('checkout.create', $product) }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                                Checkout langsung
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                                Masuk untuk checkout
                            </a>
                        @endauth
                    @else
                        <span class="inline-flex flex-1 cursor-not-allowed items-center justify-center rounded-xl bg-slate-200 px-5 py-3 text-sm font-semibold text-slate-500">
                            Stok habis
                        </span>
                    @endif
                    <a href="{{ route('contact', ['produk' => $product->slug]) }}" class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Konsultasi
                    </a>
                </div>
            </div>
        </div>
    </section>

    @if ($galleryImages->count() > 1)
        <script>
            document.querySelectorAll('.product-thumb').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.getElementById('mainProductImage').src = btn.dataset.image;
                    document.querySelectorAll('.product-thumb').forEach(function (t) {
                        t.classList.remove('border-slate-900');
                        t.classList.add('border-transparent');
                    });
                    btn.classList.add('border-slate-900');
                    btn.classList.remove('border-transparent');
                });
            });
        </script>
    @endif
@endsection
