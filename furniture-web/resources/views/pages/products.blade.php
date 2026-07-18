@extends('layouts.app')

@section('title', 'Produk • FurniBest')

@section('content')
    <section class="bg-slate-50/70">
        <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Produk</h1>
                    <p class="mt-2 text-sm text-slate-600">
                        @if ($keyword ?? '')
                            Hasil pencarian "<span class="font-semibold">{{ $keyword }}</span>" —
                            <span class="font-semibold">{{ $products->total() }}</span> produk ditemukan
                        @elseif ($activeCategory)
                            Menampilkan produk kategori <span class="font-semibold">{{ $activeCategory->name }}</span>
                        @else
                            Semua produk dari katalog FurniBest.
                        @endif
                    </p>
                </div>

                {{-- Search Bar --}}
                <form method="GET" action="{{ route('products') }}" class="flex w-full sm:w-72 gap-2">
                    @if($activeCategory)
                        <input type="hidden" name="kategori" value="{{ $activeCategory->slug }}">
                    @endif
                    <div class="relative flex-1">
                        <input
                            type="text"
                            name="cari"
                            value="{{ $keyword ?? '' }}"
                            placeholder="Cari nama produk..."
                            class="w-full rounded-xl border border-slate-200 bg-white py-2 pl-9 pr-4 text-sm text-slate-800 placeholder-slate-400 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400"
                        >
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                    </div>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                        Cari
                    </button>
                    @if($keyword ?? '')
                        <a href="{{ route('products', $activeCategory ? ['kategori' => $activeCategory->slug] : []) }}" class="flex items-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-500 hover:bg-slate-50" title="Hapus pencarian">✕</a>
                    @endif
                </form>
            </div>

            @if ($categories->isNotEmpty())
                <div class="mt-6 flex flex-wrap gap-2">
                    <a href="{{ route('products') }}" class="rounded-full px-4 py-2 text-xs font-semibold {{ !$activeCategory ? 'bg-slate-900 text-white' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                        Semua
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('products', ['kategori' => $category->slug]) }}" class="rounded-full px-4 py-2 text-xs font-semibold {{ $activeCategory && $activeCategory->id === $category->id ? 'bg-slate-900 text-white' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            @if ($products->isEmpty())
                <div class="mt-8 rounded-2xl border border-slate-200/60 bg-white p-10 text-center shadow-sm">
                    <p class="text-sm text-slate-600">
                        @if ($keyword ?? '')
                            Produk dengan nama "<span class="font-semibold">{{ $keyword }}</span>" tidak ditemukan.
                            <a href="{{ route('products') }}" class="mt-2 block text-slate-500 underline hover:text-slate-700">Lihat semua produk</a>
                        @elseif ($activeCategory)
                            Belum ada produk di kategori ini.
                        @else
                            Belum ada produk. Tambahkan dari halaman admin.
                        @endif
                    </p>
                </div>
            @else
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($products as $product)
                        <a href="{{ route('products.show', $product) }}" class="group overflow-hidden rounded-2xl border border-slate-200/60 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="relative h-44 bg-slate-100">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-contain bg-white">
                                @else
                                    <div class="flex h-full items-center justify-center text-xs text-slate-400">Tanpa gambar</div>
                                @endif
                                @php $firstCategory = $product->categories->first(); @endphp
                                @if ($firstCategory)
                                    <div class="absolute left-4 top-4 rounded-full bg-slate-900/80 px-2 py-1 text-[11px] font-semibold text-white">
                                        {{ $firstCategory->name }}
                                    </div>
                                @endif
                                @if ($product->stock <= 0)
                                    <div class="absolute right-4 top-4 rounded-full bg-rose-600 px-2 py-1 text-[11px] font-semibold text-white">Habis</div>
                                @elseif ($product->stock <= 5)
                                    <div class="absolute right-4 top-4 rounded-full bg-amber-500 px-2 py-1 text-[11px] font-semibold text-white">Stok terbatas</div>
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="text-sm font-semibold text-slate-900 group-hover:text-brand-800">{{ $product->name }}</div>
                                @if ($product->size)
                                    <div class="mt-1 text-xs text-slate-500">{{ $product->size }}</div>
                                @endif
                                <div class="mt-1 text-sm text-slate-600">{{ $product->formatted_price }}</div>
                                @if ($product->description)
                                    <p class="mt-2 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                                @endif
                                <div class="mt-3 text-xs font-medium text-brand-700">Lihat detail →</div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
