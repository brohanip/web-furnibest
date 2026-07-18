@extends('layouts.app')

@section('title', 'Kontak • FurniBest')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-2 lg:items-start">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Kontak</h1>
                <p class="mt-2 text-sm text-slate-600">
                    @if ($consultProduct ?? null)
                        Konsultasi untuk produk <span class="font-semibold">{{ $consultProduct->name }}</span>.
                    @else
                        Silakan isi form di bawah. 
                    @endif
                </p>

                @if ($consultProduct ?? null)
                    <div class="mt-4 flex items-center gap-3 rounded-xl border border-brand-200/60 bg-brand-50 p-4">
                        @if ($consultProduct->image_url)
                            <img src="{{ $consultProduct->image_url }}" alt="" class="h-14 w-14 rounded-lg object-cover">
                        @endif
                        <div>
                            <div class="text-sm font-semibold text-slate-900">{{ $consultProduct->name }}</div>
                            <div class="text-sm text-slate-600">{{ $consultProduct->formatted_price }}</div>
                            @if ($consultProduct->size)
                                <div class="text-xs text-slate-500">Ukuran: {{ $consultProduct->size }}</div>
                            @endif
                        </div>
                    </div>
                @endif

                <dl class="mt-6 grid gap-4 rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm">
                    <div>
                        <dt class="text-xs font-semibold text-slate-500">Alamat</dt>
                        <dd class="mt-1 text-sm text-slate-900">Jepara, Indonesia</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-slate-500">Jam</dt>
                        <dd class="mt-1 text-sm text-slate-900">09.00–20.00 (Senin–Sabtu)</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-slate-500">Email</dt>
                        <dd class="mt-1 text-sm text-slate-900">cacamfurniture@gmail.com</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-3xl border border-slate-200/60 bg-gradient-to-br from-white to-brand-50 p-6 shadow-sm">
                <form class="grid gap-3 sm:grid-cols-2">
                    <label class="grid gap-1">
                        <span class="text-xs font-semibold text-slate-600">Nama</span>
                        <input type="text" placeholder="Nama kamu" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                    </label>
                    <label class="grid gap-1">
                        <span class="text-xs font-semibold text-slate-600">WhatsApp</span>
                        <input type="text" placeholder="08xxxxxxxxxx" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                    </label>
                    <label class="grid gap-1 sm:col-span-2">
                        <span class="text-xs font-semibold text-slate-600">Pesan</span>
                        <textarea rows="4" placeholder="Tulis kebutuhan kamu…" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none ring-brand-200 focus:ring-4">@if ($consultProduct ?? null)Halo, saya tertarik dengan produk {{ $consultProduct->name }} ({{ $consultProduct->formatted_price }}). Mohon info lebih lanjut.@endif</textarea>
                    </label>
                    <div class="sm:col-span-2">
                        <button type="button" class="w-full rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                            Kirim (dummy)
                        </button>
                        <div class="mt-2 text-center text-xs text-slate-500">Form ini belum tersambung ke backend.</div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

