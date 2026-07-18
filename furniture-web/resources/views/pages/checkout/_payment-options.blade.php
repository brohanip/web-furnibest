@php
    // Tampilkan opsi Midtrans untuk demo UI, meskipun belum dikonfigurasi
    $midtransEnabled = true; // Selalu tampilkan opsi Midtrans
    $midtransConfigured = ! empty(config('midtrans.server_key')); // Cek apakah sudah dikonfigurasi
    $hasBanks = $bankAccounts->isNotEmpty();
@endphp

<div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
    <div class="mb-3 text-sm font-semibold text-slate-800">Metode pembayaran</div>
    <div class="grid gap-2">
        @if ($hasBanks)
            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-white p-3">
                <input type="radio" name="payment_method" value="transfer" class="mt-1" {{ old('payment_method', $midtransEnabled ? 'midtrans' : 'transfer') === 'transfer' ? 'checked' : '' }} onchange="togglePaymentMethod()">
                <div class="flex-1">
                    <div class="font-semibold text-slate-900">Transfer bank manual</div>
                    <div class="text-sm text-slate-600">Transfer ke rekening kami, konfirmasi oleh admin</div>
                </div>
            </label>
        @endif
        @if ($midtransEnabled)
            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-white p-3">
                <input type="radio" name="payment_method" value="midtrans" class="mt-1" {{ old('payment_method', 'midtrans') === 'midtrans' ? 'checked' : '' }} onchange="togglePaymentMethod()">
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-slate-900">Bayar online (Midtrans)</span>
                        @if (!$midtransConfigured)
                            <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800">Perlu Setup</span>
                        @else
                            <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">✓ Aktif</span>
                        @endif
                    </div>
                    <div class="text-sm text-slate-600">💳 Kartu Kredit/Debit • 🏦 Bank Transfer (BCA, BNI, BRI, Permata, Mandiri) • 📱 E-wallet (GoPay, ShopeePay, QRIS) • 🏪 Indomaret, Alfamart • 💰 Akulaku</div>
                    @if (!$midtransConfigured)
                        <div class="mt-2 rounded-lg bg-amber-50 p-2 text-xs text-amber-800">
                           
                        </div>
                    @endif
                </div>
            </label>
        @endif
    </div>
    @error('payment_method') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror

    @if ($hasBanks)
        <div id="bankSelect" class="mt-4 {{ old('payment_method', $midtransEnabled ? 'midtrans' : 'transfer') === 'transfer' ? '' : 'hidden' }}">
            <div class="mb-2 text-xs font-semibold text-slate-600">Pilih rekening tujuan</div>
            <div class="grid gap-2">
                @foreach ($bankAccounts as $bank)
                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm">
                        <input type="radio" name="bank_account_id" value="{{ $bank->id }}" {{ (int) old('bank_account_id') === $bank->id ? 'checked' : '' }} {{ $loop->first && ! old('bank_account_id') ? 'checked' : '' }}>
                        <span><strong>{{ $bank->bank_name }}</strong> — {{ $bank->account_number }} ({{ $bank->account_holder }})</span>
                    </label>
                @endforeach
            </div>
            @error('bank_account_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>
    @endif
</div>

<div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
    <div class="mb-3 text-sm font-semibold text-slate-800">Skema pembayaran</div>
    <div class="grid gap-2">
        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-white p-3">
            <input type="radio" name="payment_type" value="full" class="mt-1" {{ old('payment_type', 'full') === 'full' ? 'checked' : '' }} onchange="toggleDp(false)">
            <div>
                <div class="font-semibold text-slate-900">Bayar penuh</div>
                <div class="text-sm text-slate-600">{{ $formattedSubtotal ?? $product->formatted_price }} — lunas</div>
            </div>
        </label>
        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-white p-3">
            <input type="radio" name="payment_type" value="dp" class="mt-1" {{ old('payment_type') === 'dp' ? 'checked' : '' }} onchange="toggleDp(true)">
            <div class="flex-1">
                <div class="font-semibold text-slate-900">Uang muka (DP)</div>
                <div id="dpSelect" class="mt-3 {{ old('payment_type') === 'dp' ? '' : 'hidden' }}">
                    <select name="dp_percent" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        @foreach ($dpOptions as $pct)
                            @php $base = $subtotal ?? $product->price; @endphp
                            <option value="{{ $pct }}" {{ (int) old('dp_percent', $dpOptions[0] ?? 30) === $pct ? 'selected' : '' }}>
                                DP {{ $pct }}% — Rp {{ number_format(floor($base * $pct / 100), 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </label>
    </div>
</div>

<script>
    function toggleDp(show) {
        var el = document.getElementById('dpSelect');
        if (el) el.classList.toggle('hidden', !show);
    }
    function togglePaymentMethod() {
        var transfer = document.querySelector('input[name="payment_method"][value="transfer"]');
        var bankSelect = document.getElementById('bankSelect');
        if (bankSelect && transfer) {
            bankSelect.classList.toggle('hidden', !transfer.checked);
        }
    }
</script>
