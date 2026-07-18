@extends('layouts.guest')

@section('title', 'Daftar • FurniBest')

@section('content')
    <div class="w-full max-w-md">
        <h1 class="text-2xl font-bold tracking-tight">Daftar</h1>
        <p class="mt-2 text-sm text-slate-600">Buat akun untuk berbelanja dan checkout di FurniBest.</p>

        <div class="mt-6 rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('register') }}" class="grid gap-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">WhatsApp / Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm" placeholder="08xxxxxxxxxx">
                    @error('phone') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Kata sandi</label>
                    <input type="password" name="password" required class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    <p class="mt-1 text-xs text-slate-500">Minimal 8 karakter.</p>
                    @error('password') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Ulangi kata sandi</label>
                    <input type="password" name="password_confirmation" required class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                </div>

                <button type="submit" class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Daftar
                </button>
            </form>

            <p class="mt-4 text-center text-sm text-slate-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-brand-800 hover:underline">Masuk</a>
            </p>
        </div>
    </div>
@endsection
