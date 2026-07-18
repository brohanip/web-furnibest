@extends('admin.layouts.app')

@section('title', 'Tambah Sampel Warna • Admin')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="mb-6 text-2xl font-bold">Tambah Sampel Warna</h1>
        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.color-samples.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nama warna</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Oak Natural" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Kode warna (hex)</label>
                    <input type="text" name="color_code" value="{{ old('color_code') }}" placeholder="#8B7355" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    <p class="mt-1 text-xs text-slate-500">Opsional jika sudah upload foto tekstur.</p>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Foto tekstur (opsional)</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm">
                    <p class="mt-1 text-xs text-slate-500">Maks 5MB. Jika ada foto, akan diprioritaskan di website.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Urutan</label>
                        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', 0) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    </div>
                    <div class="flex items-end">
                        <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" checked> Tampilkan di website
                        </label>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.color-samples.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Batal</a>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Simpan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
