<div class="mt-5 border-t border-dashed border-slate-200 pt-4">
    <p class="text-center text-xs text-slate-400 mb-3"></p>
    <form method="POST" action="{{ route('checkout.simulate-pay', $order) }}">
        @csrf
        <input type="hidden" name="method" value="{{ $method }}">
        <button type="submit"
            class="w-full rounded-xl bg-green-600 py-3 text-sm font-semibold text-white hover:bg-green-700 transition"
            onclick="return confirm('Simulasi pembayaran berhasil? Order akan ditandai LUNAS.')">
            Konfirmasi Bayar
        </button>
    </form>
</div>
