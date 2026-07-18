@extends('admin.layouts.app')

@section('title', 'Tambah Kategori • Admin')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight">Tambah Kategori</h1>
            <p class="mt-1 text-sm text-slate-600">Isi data kategori baru.</p>
        </div>

        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nama kategori</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                    @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Gambar kategori</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
                    <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                    @error('image') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.categories.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Simpan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
