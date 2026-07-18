@extends('layouts.guest')

@section('title', 'Masuk • FurniBest')

@section('content')
    <div class="w-full max-w-md">
        <h1 class="text-2xl font-bold tracking-tight">Masuk</h1>
        <p class="mt-2 text-sm text-slate-600">Login untuk melanjutkan checkout dan melihat pesanan.</p>

        @if (session('info'))
            <div class="mt-4 rounded-xl border border-brand-200 bg-brand-50 px-4 py-3 text-sm text-brand-900">{{ session('info') }}</div>
        @endif

        <div class="mt-6 rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('login') }}" class="grid gap-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Kata sandi</label>
                    <input type="password" name="password" required class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    Ingat saya
                </label>

                <button type="submit" class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Masuk
                </button>
            </form>

            <p class="mt-4 text-center text-sm text-slate-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-brand-800 hover:underline">Daftar sekarang</a>
            </p>
        </div>
    </div>
@endsection
