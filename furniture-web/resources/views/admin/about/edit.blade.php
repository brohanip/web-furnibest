@extends('admin.layouts.app')

@section('title', 'Tentang Kami • Admin')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight">Tentang Kami</h1>
            <p class="mt-1 text-sm text-slate-600">Atur teks utama halaman Tentang Kami.</p>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.about.update') }}" method="POST" class="grid gap-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Judul halaman</label>
                    <input type="text" name="headline" value="{{ old('headline', $about->headline) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('headline') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Subjudul</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $about->subtitle) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('subtitle') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Intro (paragraf pembuka)</label>
                    <textarea name="intro" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">{{ old('intro', $about->intro) }}</textarea>
                    @error('intro') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Cerita kami</label>
                    <textarea name="story" rows="6" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">{{ old('story', $about->story) }}</textarea>
                    @error('story') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Judul section bahan</label>
                        <input type="text" name="materials_title" value="{{ old('materials_title', $about->materials_title) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                        @error('materials_title') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Judul section sampel warna</label>
                        <input type="text" name="colors_title" value="{{ old('colors_title', $about->colors_title) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                        @error('colors_title') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.materials.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kelola Bahan</a>
                    <a href="{{ route('admin.color-samples.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kelola Sampel Warna</a>
                    <a href="{{ route('about') }}" target="_blank" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat halaman</a>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Simpan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
