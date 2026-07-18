@extends('admin.layouts.app')

@section('title', 'Pesanan • Admin')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Pesanan</h1>
                <p class="mt-1 text-sm text-slate-600">Daftar pesanan — transfer manual & Midtrans.</p>
            </div>
            <form method="GET" class="flex gap-2">
                <select name="status" class="rounded-xl border border-slate-200 px-3 py-2 text-sm" onchange="this.form.submit()">
                    <option value="">Semua status</option>
                    @foreach (['pending', 'paid', 'failed', 'expired', 'cancelled'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200/70 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">No. Pesanan</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Pelanggan</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Bayar</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $order->order_number }}</td>
                            <td class="px-4 py-3">{{ $order->customer_name }}<br><span class="text-xs text-slate-500">{{ $order->customer_phone }}</span></td>
                            <td class="px-4 py-3">
                                <span class="text-xs text-slate-500">{{ $order->payment_method_label }}</span><br>
                                {{ $order->payment_type_label }}<br>
                                <span class="font-semibold">{{ $order->formatted_amount_to_pay }}</span>
                                @if ($order->remaining_amount > 0)
                                    <br><span class="text-xs text-amber-700">Sisa {{ $order->formatted_remaining_amount }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 capitalize">{{ $order->status }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-brand-800 hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $orders->links() }}</div>
    </section>
@endsection
