@extends('layouts.app')

@section('title', 'Bayar • ' . $order->order_number)

@section('content')
<section class="mx-auto max-w-lg px-4 py-10 sm:px-6">

    {{-- Header --}}
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold tracking-tight">Pembayaran</h1>
        <p class="mt-1 text-sm text-slate-500">Pesanan <span class="font-semibold text-slate-800">{{ $order->order_number }}</span></p>
    </div>

    {{-- Nominal --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm mb-6">
        <div class="text-xs text-slate-500 uppercase tracking-wide">{{ $order->payment_type_label }}</div>
        <div class="mt-1 text-3xl font-bold text-slate-900">{{ $order->formatted_amount_to_pay }}</div>
        @if($order->isDp() && $order->remaining_amount > 0)
            <p class="mt-1 text-sm text-amber-600">Sisa pelunasan: {{ $order->formatted_remaining_amount }}</p>
        @endif
    </div>

    @if(!$demoMode && $snapToken)
        {{-- ===== MODE MIDTRANS ASLI ===== --}}
        <p class="text-center text-sm text-slate-600 mb-4">Jendela pembayaran akan terbuka otomatis. Jika tidak muncul, klik tombol di bawah.</p>
        <button id="payButton" class="w-full rounded-xl bg-slate-900 py-3 text-sm font-semibold text-white hover:bg-slate-800">
            Buka Pembayaran
        </button>
        <div class="mt-3 text-center">
            <a href="{{ route('checkout.show', $order) }}" class="text-sm text-slate-400 hover:text-slate-600">Lihat detail pesanan</a>
        </div>
    @else
        {{-- ===== MODE DEMO / SIMULASI ===== --}}
        <p class="text-center text-xs text-slate-400 mb-5 bg-amber-50 border border-amber-100 rounded-lg py-2 px-3">
            <strong></strong> — Pilih metode pembayaran di bawah
        </p>

        {{-- Tab Pilih Metode --}}
        <div class="flex gap-2 mb-5 overflow-x-auto pb-1">
            <button onclick="showTab('tab-bca')" id="btn-bca" class="tab-btn active-tab shrink-0 rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:border-slate-900 focus:outline-none">BCA VA</button>
            <button onclick="showTab('tab-bni')" id="btn-bni" class="tab-btn shrink-0 rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:border-slate-900 focus:outline-none">BNI VA</button>
            <button onclick="showTab('tab-bri')" id="btn-bri" class="tab-btn shrink-0 rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:border-slate-900 focus:outline-none">BRI VA</button>
            <button onclick="showTab('tab-mandiri')" id="btn-mandiri" class="tab-btn shrink-0 rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:border-slate-900 focus:outline-none">Mandiri</button>
            <button onclick="showTab('tab-qris')" id="btn-qris" class="tab-btn shrink-0 rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:border-slate-900 focus:outline-none">QRIS</button>
        </div>

        {{-- BCA VA --}}
        <div id="tab-bca" class="tab-panel">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-white font-bold text-sm">BCA</div>
                    <div>
                        <div class="font-semibold text-slate-800">BCA Virtual Account</div>
                        <div class="text-xs text-slate-500">Berlaku 24 jam</div>
                    </div>
                </div>
                <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 text-center">
                    <div class="text-xs text-slate-500 mb-1">Nomor Virtual Account</div>
                    <div class="text-2xl font-mono font-bold tracking-wider text-slate-900" id="bca-number">{{ $simulasi['bca_va'] }}</div>
                    <button onclick="copyText('{{ $simulasi['bca_va'] }}', 'bca-copy')" class="mt-2 text-xs text-blue-600 hover:underline" id="bca-copy">Salin nomor</button>
                </div>
                <div class="mt-4 text-xs text-slate-500 space-y-1">
                    <div class="font-semibold text-slate-700 mb-2">Cara Bayar via ATM BCA:</div>
                    <div>1. Pilih menu <strong>Transaksi Lainnya</strong> → <strong>Transfer</strong> → <strong>Ke Rekening BCA Virtual Account</strong></div>
                    <div>2. Masukkan nomor VA di atas</div>
                    <div>3. Masukkan nominal <strong>{{ $order->formatted_amount_to_pay }}</strong></div>
                    <div>4. Konfirmasi dan selesaikan pembayaran</div>
                </div>
                @include('pages.checkout._sim-pay-button', ['method' => 'bca_virtual_account'])
            </div>
        </div>

        {{-- BNI VA --}}
        <div id="tab-bni" class="tab-panel hidden">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-500 text-white font-bold text-sm">BNI</div>
                    <div>
                        <div class="font-semibold text-slate-800">BNI Virtual Account</div>
                        <div class="text-xs text-slate-500">Berlaku 24 jam</div>
                    </div>
                </div>
                <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 text-center">
                    <div class="text-xs text-slate-500 mb-1">Nomor Virtual Account</div>
                    <div class="text-2xl font-mono font-bold tracking-wider text-slate-900">{{ $simulasi['bni_va'] }}</div>
                    <button onclick="copyText('{{ $simulasi['bni_va'] }}', 'bni-copy')" class="mt-2 text-xs text-blue-600 hover:underline" id="bni-copy">Salin nomor</button>
                </div>
                <div class="mt-4 text-xs text-slate-500 space-y-1">
                    <div class="font-semibold text-slate-700 mb-2">Cara Bayar via ATM BNI:</div>
                    <div>1. Pilih menu <strong>Transfer</strong> → <strong>Virtual Account Billing</strong></div>
                    <div>2. Masukkan nomor VA di atas</div>
                    <div>3. Nominal <strong>{{ $order->formatted_amount_to_pay }}</strong> akan muncul otomatis</div>
                    <div>4. Konfirmasi dan selesaikan pembayaran</div>
                </div>
                @include('pages.checkout._sim-pay-button', ['method' => 'bni_virtual_account'])
            </div>
        </div>

        {{-- BRI VA --}}
        <div id="tab-bri" class="tab-panel hidden">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-sky-600 text-white font-bold text-sm">BRI</div>
                    <div>
                        <div class="font-semibold text-slate-800">BRI Virtual Account</div>
                        <div class="text-xs text-slate-500">Berlaku 24 jam</div>
                    </div>
                </div>
                <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 text-center">
                    <div class="text-xs text-slate-500 mb-1">Nomor Virtual Account</div>
                    <div class="text-2xl font-mono font-bold tracking-wider text-slate-900">{{ $simulasi['bri_va'] }}</div>
                    <button onclick="copyText('{{ $simulasi['bri_va'] }}', 'bri-copy')" class="mt-2 text-xs text-blue-600 hover:underline" id="bri-copy">Salin nomor</button>
                </div>
                <div class="mt-4 text-xs text-slate-500 space-y-1">
                    <div class="font-semibold text-slate-700 mb-2">Cara Bayar via ATM BRI:</div>
                    <div>1. Pilih menu <strong>Transaksi Lain</strong> → <strong>Pembayaran</strong> → <strong>BRIVA</strong></div>
                    <div>2. Masukkan nomor VA di atas</div>
                    <div>3. Konfirmasi nominal <strong>{{ $order->formatted_amount_to_pay }}</strong></div>
                    <div>4. Selesaikan pembayaran</div>
                </div>
                @include('pages.checkout._sim-pay-button', ['method' => 'bri_virtual_account'])
            </div>
        </div>

        {{-- Mandiri --}}
        <div id="tab-mandiri" class="tab-panel hidden">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-500 text-white font-bold text-xs">MDR</div>
                    <div>
                        <div class="font-semibold text-slate-800">Mandiri Bill Payment</div>
                        <div class="text-xs text-slate-500">Berlaku 24 jam</div>
                    </div>
                </div>
                <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 text-center">
                    <div class="text-xs text-slate-500 mb-1">Kode Pembayaran</div>
                    <div class="text-2xl font-mono font-bold tracking-wider text-slate-900">{{ $simulasi['mandiri'] }}</div>
                    <button onclick="copyText('{{ $simulasi['mandiri'] }}', 'mandiri-copy')" class="mt-2 text-xs text-blue-600 hover:underline" id="mandiri-copy">Salin kode</button>
                </div>
                <div class="mt-4 text-xs text-slate-500 space-y-1">
                    <div class="font-semibold text-slate-700 mb-2">Cara Bayar via ATM Mandiri:</div>
                    <div>1. Pilih menu <strong>Bayar/Beli</strong> → <strong>Lainnya</strong> → <strong>Multi Payment</strong></div>
                    <div>2. Isi kode perusahaan: <strong>70014</strong></div>
                    <div>3. Isi nomor VA di atas</div>
                    <div>4. Konfirmasi dan selesaikan</div>
                </div>
                @include('pages.checkout._sim-pay-button', ['method' => 'mandiri_bill'])
            </div>
        </div>

        {{-- QRIS --}}
        <div id="tab-qris" class="tab-panel hidden">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm text-center">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-500 text-white font-bold text-xs">QR</div>
                    <div class="text-left">
                        <div class="font-semibold text-slate-800">QRIS</div>
                        <div class="text-xs text-slate-500">Scan dengan GoPay, OVO, DANA, LinkAja, ShopeePay, dll</div>
                    </div>
                </div>
                <div class="inline-block rounded-2xl border-2 border-slate-200 p-3 bg-white">
                    <img src="{{ $simulasi['qris_url'] }}" alt="QRIS Code" class="w-48 h-48" />
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    Nominal: <strong class="text-slate-800">{{ $order->formatted_amount_to_pay }}</strong>
                </div>
                <div class="mt-4 text-xs text-slate-500 space-y-1 text-left">
                    <div class="font-semibold text-slate-700 mb-2">Cara Bayar:</div>
                    <div>1. Buka aplikasi e-wallet (GoPay, OVO, DANA, ShopeePay, dll)</div>
                    <div>2. Pilih menu <strong>Scan QR</strong> / <strong>Bayar</strong></div>
                    <div>3. Scan QR Code di atas</div>
                    <div>4. Konfirmasi nominal dan selesaikan</div>
                </div>
                @include('pages.checkout._sim-pay-button', ['method' => 'qris'])
            </div>
        </div>

    @endif

    <div class="mt-4 text-center">
        <a href="{{ route('checkout.show', $order) }}" class="text-sm text-slate-400 hover:text-slate-600">Lihat detail pesanan</a>
    </div>
</section>

@if(!$demoMode && $snapToken)
    <script src="{{ $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $clientKey }}"></script>
    <script>
        function openSnap() {
            snap.pay(@json($snapToken), {
                onSuccess: function () { window.location.href = @json(route('checkout.finish', $order)); },
                onPending: function () { window.location.href = @json(route('checkout.finish', $order)); },
                onError: function () { window.location.href = @json(route('checkout.show', $order)); },
                onClose: function () { window.location.href = @json(route('checkout.show', $order)); }
            });
        }
        document.getElementById('payButton').addEventListener('click', openSnap);
        setTimeout(openSnap, 500);
    </script>
@else
    <script>
        function showTab(id) {
            document.querySelectorAll('.tab-panel').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('active-tab', 'border-slate-900', 'bg-slate-900', 'text-white');
            });
            document.getElementById(id).classList.remove('hidden');
            const btnId = 'btn-' + id.replace('tab-', '');
            const btn = document.getElementById(btnId);
            if (btn) {
                btn.classList.add('active-tab', 'border-slate-900', 'bg-slate-900', 'text-white');
            }
        }

        function copyText(text, btnId) {
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.getElementById(btnId);
                if (btn) { btn.textContent = '✓ Tersalin!'; setTimeout(() => btn.textContent = 'Salin nomor', 2000); }
            });
        }

        // Set active tab on load
        document.getElementById('btn-bca').classList.add('border-slate-900', 'bg-slate-900', 'text-white');
    </script>
@endif
@endsection
