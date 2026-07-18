@extends('admin.layouts.app')

@section('title', 'Admin Kategori • FurniBest')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Admin Kategori</h1>
                <p class="mt-1 text-sm text-slate-600">Kelola kategori produk furniture.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                + Tambah Kategori
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-slate-200/70 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Gambar</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Slug</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Produk</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Deskripsi</th>
                            <th class="px-4 py-3 text-right font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($categories as $category)
                            <tr>
                                <td class="px-4 py-3">
                                    @if ($category->image_url)
                                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-12 w-12 rounded-lg object-cover">
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-400">-</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $category->name }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $category->slug }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $category->products_count }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ \Illuminate\Support\Str::limit($category->description, 60) ?: '-' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada data kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 px-4 py-3">
                {{ $categories->links() }}
            </div>
        </div>
    </section>
@endsection
