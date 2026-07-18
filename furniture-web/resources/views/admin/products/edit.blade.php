@extends('admin.layouts.app')

@section('title', 'Edit Produk • Admin')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight">Edit Produk</h1>
            <p class="mt-1 text-sm text-slate-600">Perbarui data produk.</p>
        </div>

        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="grid gap-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Kategori (boleh centang lebih dari satu)</label>

                    @php
                        $selectedCategoryIds = old(
                            'category_ids',
                            $product->categories?->pluck('id')->all() ?? []
                        );
                    @endphp

                    @if ($categories->isEmpty())
                        <p class="mt-1 text-xs text-amber-600">Belum ada kategori.</p>
                    @else
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
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                    @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Ukuran</label>
                    <input type="text" name="size" value="{{ old('size', $product->size) }}" placeholder="Contoh: 200 x 90 x 85 cm" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                    @error('size') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Harga</label>
                        <input type="number" name="price" min="0" step="0.01" value="{{ old('price', $product->price) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                        @error('price') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Stok</label>
                        <input type="number" name="stock" min="0" value="{{ old('stock', $product->stock) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                        @error('stock') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Gambar produk</label>
                    @if ($product->images->isNotEmpty())
                        <div class="mb-3 grid grid-cols-3 gap-3 sm:grid-cols-4">
                            @foreach ($product->images as $image)
                                <label class="relative block cursor-pointer overflow-hidden rounded-xl border border-slate-200">
                                    <img src="{{ $image->url }}" alt="" class="aspect-square w-full object-contain bg-white">
                                    <span class="absolute inset-x-0 bottom-0 bg-slate-900/80 px-2 py-1 text-center text-[10px] text-white">
                                        <input type="checkbox" name="remove_image_ids[]" value="{{ $image->id }}" class="mr-1">
                                        Hapus
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
                    <p class="mt-1 text-xs text-slate-500">Tambah gambar baru atau centang Hapus. Minimal satu gambar harus tersisa.</p>
                    @error('images') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    @error('images.*') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none ring-brand-200 focus:ring-4">{{ old('description', $product->description) }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.products.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Update</button>
                </div>
            </form>
        </div>
    </section>
@endsection
