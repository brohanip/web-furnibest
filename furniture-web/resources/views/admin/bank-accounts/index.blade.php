@extends('admin.layouts.app')

@section('title', 'Rekening Bank • Admin')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Rekening Bank</h1>
                <p class="mt-1 text-sm text-slate-600">Kelola rekening untuk pembayaran transfer manual.</p>
            </div>
            <a href="{{ route('admin.bank-accounts.create') }}" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">+ Tambah Rekening</a>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-slate-200/70 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Bank</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">No. Rekening</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Atas Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($bankAccounts as $account)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $account->bank_name }}</td>
                            <td class="px-4 py-3 font-mono text-xs">{{ $account->account_number }}</td>
                            <td class="px-4 py-3">{{ $account->account_holder }}</td>
                            <td class="px-4 py-3">{{ $account->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.bank-accounts.edit', $account) }}" class="text-brand-800 hover:underline">Edit</a>
                                <form action="{{ route('admin.bank-accounts.destroy', $account) }}" method="POST" class="inline" onsubmit="return confirm('Hapus rekening ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="ml-2 text-rose-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada rekening. Tambahkan minimal satu rekening untuk transfer manual.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $bankAccounts->links() }}</div>
    </section>
@endsection
