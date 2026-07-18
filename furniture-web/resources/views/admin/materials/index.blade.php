@extends('admin.layouts.app')

@section('title', 'Bahan • Admin')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Bahan</h1>
                <p class="mt-1 text-sm text-slate-600">Kelola daftar bahan di halaman Tentang Kami.</p>
            </div>
            <a href="{{ route('admin.materials.create') }}" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">+ Tambah Bahan</a>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-slate-200/70 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Gambar</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Urutan</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($materials as $material)
                        <tr>
                            <td class="px-4 py-3">
                                @if ($material->image_url)
                                    <img src="{{ $material->image_url }}" alt="" class="h-12 w-12 rounded-lg object-cover">
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-400">-</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium">{{ $material->name }}</td>
                            <td class="px-4 py-3">{{ $material->sort_order }}</td>
                            <td class="px-4 py-3">{{ $material->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.materials.edit', $material) }}" class="text-brand-800 hover:underline">Edit</a>
                                <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Hapus bahan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="ml-2 text-rose-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada bahan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $materials->links() }}</div>
    </section>
@endsection
