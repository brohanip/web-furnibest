@extends('admin.layouts.app')

@section('title', 'Edit Bahan • Admin')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="mb-6 text-2xl font-bold">Edit Bahan</h1>
        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.materials.update', $material) }}" method="POST" enctype="multipart/form-data" class="grid gap-4">
                @csrf @method('PUT')
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nama bahan</label>
                    <input type="text" name="name" value="{{ old('name', $material->name) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">{{ old('description', $material->description) }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Gambar</label>
                    @if ($material->image_url)
                        <img src="{{ $material->image_url }}" alt="" class="mb-3 h-24 w-24 rounded-xl object-cover">
                    @endif
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm">
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Urutan</label>
                        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $material->sort_order) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    </div>
                    <div class="flex items-end">
                        <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $material->is_active) ? 'checked' : '' }}> Tampilkan di website
                        </label>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.materials.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Batal</a>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Update</button>
                </div>
            </form>
        </div>
    </section>
@endsection
