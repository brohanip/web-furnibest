@extends('layouts.app')

@section('title', 'Home • FurniBest')

@section('content')
    <section class="relative overflow-hidden">
        @if ($homeHero->is_active && $homeHero->background_image_url)
            <div class="absolute inset-0 -z-10 bg-cover bg-center" style="background-image: url('{{ $homeHero->background_image_url }}')"></div>
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-white/92 via-white/88 to-white"></div>
        @else
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-brand-50 via-white to-white"></div>
            <div class="absolute -top-24 right-0 -z-10 h-72 w-72 rounded-full bg-brand-200/40 blur-3xl"></div>
            <div class="absolute -bottom-24 left-0 -z-10 h-72 w-72 rounded-full bg-slate-200/50 blur-3xl"></div>
        @endif

        <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-brand-200/60 bg-white px-3 py-1 text-xs font-semibold text-brand-800 shadow-sm">
                        <span class="inline-block h-2 w-2 rounded-full bg-brand-600"></span>
                        Baru: koleksi minimalis 2026
                    </div>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl">
                        Buat rumah terasa <span class="text-brand-700">hangat</span> dengan furniture pilihan.
                    </h1>
                    <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-600">
                        Desain modern, material berkualitas, dan harga masuk akal. Mulai dari sofa, meja, kursi kerja, sampai lemari—semua siap mempercantik ruangmu.
                    </p>
                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <a href="{{ route('products') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                            Lihat katalog produk
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Konsultasi gratis
                        </a>
                    </div>

                    <dl class="mt-8 grid grid-cols-3 gap-4 rounded-2xl border border-slate-200/60 bg-white/70 p-4 shadow-sm">
                        <div>
                            <dt class="text-xs font-medium text-slate-500">Garansi</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900">12 bulan</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-slate-500">Pengiriman</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900">Jepara</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-slate-500">Material</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900">Premium</dd>
                        </div>
                    </dl>
                </div>

                @if ($homePromo->is_active)
                    <div class="relative">
                        <div class="absolute -inset-4 -z-10 rounded-3xl bg-gradient-to-br from-brand-200/60 to-slate-200/50 blur-2xl"></div>
                        <div class="overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-sm">
                            <div class="grid gap-0 lg:grid-cols-2">
                                <div class="p-6">
                                    <div class="text-xs font-semibold text-slate-500">{{ $homePromo->package_label }}</div>
                                    <div class="mt-2 text-lg font-semibold text-slate-900">{{ $homePromo->title }}</div>
                                    @if ($homePromo->subtitle)
                                        <div class="mt-1 text-sm text-slate-600">{{ $homePromo->subtitle }}</div>
                                    @endif
                                    @if ($homePromo->discount_badge || $homePromo->discount_note)
                                        <div class="mt-4 flex items-center gap-2">
                                            @if ($homePromo->discount_badge)
                                                <span class="rounded-full bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">{{ $homePromo->discount_badge }}</span>
                                            @endif
                                            @if ($homePromo->discount_note)
                                                <span class="text-xs text-slate-500">{{ $homePromo->discount_note }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="relative flex min-h-[11rem] items-center justify-center overflow-hidden p-6 text-white">
                                    @if ($homePromo->image_url)
                                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $homePromo->image_url }}')"></div>
                                        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/75 via-brand-900/70 to-slate-900/80"></div>
                                    @else
                                        <div class="absolute inset-0 bg-gradient-to-br from-brand-700 to-slate-900"></div>
                                    @endif
                                    <div class="relative text-center">
                                        <div class="text-xs font-semibold text-white/80">{{ $homePromo->price_label }}</div>
                                        <div class="mt-1 text-3xl font-bold">{{ $homePromo->formatted_price }}</div>
                                        @if ($homePromo->install_note)
                                            <div class="mt-2 text-xs text-white/80">{{ $homePromo->install_note }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 border-t border-slate-200/60 bg-white">
                                <div class="p-4 text-center">
                                    <div class="text-xs text-slate-500">{{ $homePromo->stat_rating_label }}</div>
                                    <div class="mt-1 text-sm font-semibold">{{ $homePromo->stat_rating_value }}</div>
                                </div>
                                <div class="border-x border-slate-200/60 p-4 text-center">
                                    <div class="text-xs text-slate-500">{{ $homePromo->stat_sold_label }}</div>
                                    <div class="mt-1 text-sm font-semibold">{{ $homePromo->stat_sold_value }}</div>
                                </div>
                                <div class="p-4 text-center">
                                    <div class="text-xs text-slate-500">{{ $homePromo->stat_support_label }}</div>
                                    <div class="mt-1 text-sm font-semibold">{{ $homePromo->stat_support_value }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if ($featuredProducts->isNotEmpty())
        <section class="bg-slate-50/70">
            <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between gap-6">
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight">Produk unggulan</h2>
                        <p class="mt-2 text-sm text-slate-600">Produk terbaru dari katalog FurniBest.</p>
                    </div>
                    <a href="{{ route('products') }}" class="hidden text-sm font-semibold text-brand-800 hover:text-brand-900 sm:inline">Lihat semua →</a>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($featuredProducts as $product)
                        <a href="{{ route('products.show', $product) }}" class="group overflow-hidden rounded-2xl border border-slate-200/60 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="relative h-36 bg-slate-100">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-contain bg-white">
                                @else
                                    <div class="flex h-full items-center justify-center text-xs text-slate-400">Tanpa gambar</div>
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="text-sm font-semibold text-slate-900 group-hover:text-brand-800">{{ $product->name }}</div>
                                @php $firstCategory = $product->categories->first(); @endphp
                                @if ($firstCategory)
                                    <div class="mt-1 text-xs text-brand-700">{{ $firstCategory->name }}</div>
                                @endif
                                <div class="mt-1 text-sm text-slate-600">{{ $product->formatted_price }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold tracking-tight">Kategori favorit</h2>
                <p class="mt-2 text-sm text-slate-600">Pilih kategori untuk melihat produk terkait.</p>
            </div>
            <a href="{{ route('products') }}" class="hidden text-sm font-semibold text-brand-800 hover:text-brand-900 sm:inline">Lihat semua produk →</a>
        </div>

        @if ($categories->isEmpty())
            <div class="mt-6 rounded-2xl border border-slate-200/60 bg-white p-8 text-center text-sm text-slate-500">
                Belum ada kategori. Tambahkan dari admin backend.
            </div>
        @else
            @php
                $accents = ['from-brand-600 to-brand-800', 'from-slate-600 to-slate-800', 'from-emerald-600 to-emerald-800', 'from-amber-600 to-amber-800'];
            @endphp
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($categories as $category)
                    <a href="{{ route('products', ['kategori' => $category->slug]) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="relative h-32 bg-slate-100">
                            @if ($category->image_url)
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-gradient-to-br {{ $accents[$loop->index % count($accents)] }} opacity-20 blur-2xl"></div>
                                <div class="flex h-full items-center justify-center text-xs text-slate-400">Tanpa gambar</div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="text-lg font-semibold text-slate-900">{{ $category->name }}</div>
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-900 text-white transition group-hover:bg-brand-800">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-2 text-sm text-slate-600">{{ $category->description ?: 'Jelajahi koleksi ' . $category->name }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection

