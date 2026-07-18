@extends('layouts.app')

@section('title', 'Tentang Kami • FurniBest')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-b from-brand-50 via-white to-white">
        <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $about->headline }}</h1>
                @if ($about->subtitle)
                    <p class="mt-3 text-lg font-medium text-brand-800">{{ $about->subtitle }}</p>
                @endif
                @if ($about->intro)
                    <p class="mt-4 text-base leading-relaxed text-slate-600">{{ $about->intro }}</p>
                @endif
            </div>
        </div>
    </section>

    @if ($about->story)
        <section class="mx-auto max-w-6xl px-4 pb-12 sm:px-6 lg:px-8">
            <div class="rounded-3xl border border-slate-200/60 bg-white p-8 shadow-sm lg:p-10">
                <h2 class="text-xl font-bold text-slate-900">Cerita kami</h2>
                <div class="mt-4 whitespace-pre-line text-sm leading-relaxed text-slate-600 lg:text-base">{{ $about->story }}</div>
            </div>
        </section>
    @endif

    <section class="bg-slate-50/70 py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">{{ $about->materials_title }}</h2>
                <p class="mt-2 text-sm text-slate-600">Pilihan bahan yang kami gunakan untuk furniture berkualitas.</p>
            </div>

            @if ($materials->isEmpty())
                <div class="rounded-2xl border border-slate-200/60 bg-white p-8 text-center text-sm text-slate-500">
                    Informasi bahan akan segera ditambahkan.
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($materials as $material)
                        <article class="overflow-hidden rounded-2xl border border-slate-200/60 bg-white shadow-sm">
                            @if ($material->image_url)
                                <img src="{{ $material->image_url }}" alt="{{ $material->name }}" class="aspect-[4/3] w-full object-cover">
                            @else
                                <div class="flex aspect-[4/3] items-center justify-center bg-slate-100 text-xs text-slate-400">Tanpa gambar</div>
                            @endif
                            <div class="p-5">
                                <h3 class="font-semibold text-slate-900">{{ $material->name }}</h3>
                                @if ($material->description)
                                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $material->description }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">{{ $about->colors_title }}</h2>
            <p class="mt-2 text-sm text-slate-600">Referensi warna finishing yang bisa dipilih untuk pesanan custom.</p>
        </div>

        @if ($colorSamples->isEmpty())
            <div class="rounded-2xl border border-slate-200/60 bg-white p-8 text-center text-sm text-slate-500">
                Sampel warna akan segera ditambahkan.
            </div>
        @else
            <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                @foreach ($colorSamples as $sample)
                    <div class="overflow-hidden rounded-2xl border border-slate-200/60 bg-white p-3 shadow-sm text-center">
                        <div class="mx-auto aspect-square w-full max-w-[120px] overflow-hidden rounded-xl border border-slate-200/80">
                            @if ($sample->image_url)
                                <img src="{{ $sample->image_url }}" alt="{{ $sample->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full" style="{{ $sample->swatch_style }}"></div>
                            @endif
                        </div>
                        <div class="mt-3 text-sm font-semibold text-slate-900">{{ $sample->name }}</div>
                        @if ($sample->color_code)
                            <div class="mt-1 text-xs text-slate-500">{{ $sample->color_code }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-12 flex flex-col gap-3 rounded-2xl border border-brand-200/60 bg-brand-50 p-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="font-semibold text-slate-900">Butuh rekomendasi bahan & warna?</div>
                <p class="mt-1 text-sm text-slate-600">Tim kami siap membantu memilih kombinasi yang cocok untuk ruangan Anda.</p>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <a href="{{ route('products') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Lihat produk
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Hubungi kami
                </a>
            </div>
        </div>
    </section>
@endsection
