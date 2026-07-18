@extends('admin.layouts.app')

@section('title', 'Tambah Rekening • Admin')

@section('content')
    <section class="mx-auto max-w-xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="mb-6 text-2xl font-bold">Tambah Rekening Bank</h1>
        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.bank-accounts.store') }}" method="POST" class="grid gap-4">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nama bank</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="BCA, Mandiri, BRI" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('bank_name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nomor rekening</label>
                    <input type="text" name="account_number" value="{{ old('account_number') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('account_number') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Atas nama</label>
                    <input type="text" name="account_holder" value="{{ old('account_holder') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('account_holder') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Urutan</label>
                    <input type="number" name="sort_order" min="0" value="{{ old('sort_order', 0) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                </div>
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" checked> Aktif (tampil di checkout)
                </label>
                <div class="flex gap-2">
                    <a href="{{ route('admin.bank-accounts.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold">Batal</a>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Simpan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
