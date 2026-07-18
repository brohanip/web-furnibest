@extends('admin.layouts.app')

@section('title', 'Tambah Produk • Admin')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight">Tambah Produk</h1>
            <p class="mt-1 text-sm text-slate-600">Isi data produk baru.</p>
        </div>

        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Kategori (boleh centang lebih dari satu)</label>

                    @if ($categories->isEmpty())
                        <p class="mt-1 text-xs text-amber-600">Belum ada kategori. <a href="{{ route('admin.categories.create') }}" class="underline">Tambah kategori dulu</a>.</p>
                    @else
                        @php
                            $selectedCategoryIds = old('category_ids', []);
                        @endphp

                        <div class="grid gap-2 sm:grid-cols-2">
                            @foreach ($categories as $category)
                                <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-sm hover:bg-slate-50">
                                    <input
                                        type="checkbox"
                                        name="category_ids[]"
                                        value="{{ $category->id }}"
                                        {{ in_array($category->id, $selectedCategoryIds, true) ? 'checked' : '' }}
                                    />
                                    <span class="font-medium text-slate-700">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>

                        @error('category_ids')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                        @error('category_ids.*')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nama produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                    @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Ukuran</label>
                    <input type="text" name="size" value="{{ old('size') }}" placeholder="Contoh: 200 x 90 x 85 cm" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                    @error('size') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Harga</label>
                        <input type="number" name="price" min="0" step="0.01" value="{{ old('price') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                        @error('price') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Stok</label>
                        <input type="number" name="stock" min="0" value="{{ old('stock', 0) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                        @error('stock') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Gambar produk (bisa lebih dari satu)</label>
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
                    <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, WEBP. Maks 5MB per gambar. Gambar pertama jadi thumbnail.</p>
                    @error('images') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    @error('images.*') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.products.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Simpan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
