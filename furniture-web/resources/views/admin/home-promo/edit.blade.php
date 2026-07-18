@extends('admin.layouts.app')

@section('title', 'Kartu Promo Home • Admin')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight">Kartu Promo Home</h1>
            <p class="mt-1 text-sm text-slate-600">Atur konten kartu promo di bagian kanan halaman depan.</p>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.home-promo.update') }}" method="POST" enctype="multipart/form-data" class="grid gap-5">
                @csrf
                @method('PUT')

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <label class="flex cursor-pointer items-center gap-2 text-sm font-semibold text-slate-700">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }}>
                        Tampilkan kartu promo di halaman home
                    </label>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Label paket</label>
                        <input type="text" name="package_label" value="{{ old('package_label', $promo->package_label) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                        @error('package_label') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Judul paket</label>
                        <input type="text" name="title" value="{{ old('title', $promo->title) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                        @error('title') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Isi paket</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $promo->subtitle) }}" placeholder="Contoh: Sofa + meja + karpet" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('subtitle') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Badge diskon</label>
                        <input type="text" name="discount_badge" value="{{ old('discount_badge', $promo->discount_badge) }}" placeholder="Diskon 20%" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                        @error('discount_badge') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Catatan promo</label>
                        <input type="text" name="discount_note" value="{{ old('discount_note', $promo->discount_note) }}" placeholder="hingga akhir bulan" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                        @error('discount_note') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Label harga</label>
                        <input type="text" name="price_label" value="{{ old('price_label', $promo->price_label) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                        @error('price_label') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Harga (angka)</label>
                        <input type="number" name="price" min="0" step="1" value="{{ old('price', $promo->price) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                        @error('price') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Info pemasangan</label>
                    <input type="text" name="install_note" value="{{ old('install_note', $promo->install_note) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('install_note') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="rounded-xl border border-slate-200 p-4">
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Gambar background area harga</label>
                    <p class="mb-3 text-xs text-slate-500">Ditampilkan di belakang teks harga (Mulai dari, Rp …, info pemasangan). Rekomendasi: foto furniture landscape, min. 800×600 px.</p>
                    @if ($promo->image_url)
                        <div class="mb-3 overflow-hidden rounded-xl border border-slate-200">
                            <img src="{{ $promo->image_url }}" alt="Preview background harga" class="h-40 w-full object-cover">
                        </div>
                        <label class="mb-3 flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remove_image" value="1">
                            Hapus gambar saat ini
                        </label>
                    @endif
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
                    @error('image') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="border-t border-slate-200 pt-4">
                    <h2 class="mb-3 text-sm font-semibold text-slate-800">Statistik bawah kartu</h2>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="space-y-2 rounded-xl border border-slate-200 p-3">
                            <input type="text" name="stat_rating_label" value="{{ old('stat_rating_label', $promo->stat_rating_label) }}" placeholder="Label" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-xs">
                            <input type="text" name="stat_rating_value" value="{{ old('stat_rating_value', $promo->stat_rating_value) }}" placeholder="Nilai" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold">
                        </div>
                        <div class="space-y-2 rounded-xl border border-slate-200 p-3">
                            <input type="text" name="stat_sold_label" value="{{ old('stat_sold_label', $promo->stat_sold_label) }}" placeholder="Label" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-xs">
                            <input type="text" name="stat_sold_value" value="{{ old('stat_sold_value', $promo->stat_sold_value) }}" placeholder="Nilai" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold">
                        </div>
                        <div class="space-y-2 rounded-xl border border-slate-200 p-3">
                            <input type="text" name="stat_support_label" value="{{ old('stat_support_label', $promo->stat_support_label) }}" placeholder="Label" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-xs">
                            <input type="text" name="stat_support_value" value="{{ old('stat_support_value', $promo->stat_support_value) }}" placeholder="Nilai" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold">
                        </div>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('home') }}" target="_blank" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat di website</a>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Simpan perubahan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
