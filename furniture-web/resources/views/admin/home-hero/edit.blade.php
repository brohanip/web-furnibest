@extends('admin.layouts.app')

@section('title', 'Hero Home • Admin')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight">Hero Home</h1>
            <p class="mt-1 text-sm text-slate-600">Atur gambar background untuk bagian hero di atas halaman depan.</p>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.home-hero.update') }}" method="POST" enctype="multipart/form-data" class="grid gap-5">
                @csrf
                @method('PUT')

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <label class="flex cursor-pointer items-center gap-2 text-sm font-semibold text-slate-700">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $hero->is_active) ? 'checked' : '' }}>
                        Tampilkan gambar background hero
                    </label>
                    <p class="mt-2 text-xs text-slate-500">Jika dimatikan, hero memakai gradien default (tanpa foto).</p>
                </div>

                <div class="rounded-xl border border-slate-200 p-4">
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Gambar background hero</label>
                    <p class="mb-3 text-xs text-slate-500">Foto lebar penuh di belakang judul utama & kartu promo. Rekomendasi: landscape 1920×1080 px atau lebih besar.</p>

                    @if ($hero->background_image_url)
                        <div class="mb-3 overflow-hidden rounded-xl border border-slate-200">
                            <img src="{{ $hero->background_image_url }}" alt="Preview hero background" class="h-48 w-full object-cover">
                        </div>
                        <label class="mb-3 flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remove_background_image" value="1">
                            Hapus gambar saat ini
                        </label>
                    @endif

                    <input type="file" name="background_image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
                    @error('background_image') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('home') }}" target="_blank" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat di website</a>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Simpan perubahan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
