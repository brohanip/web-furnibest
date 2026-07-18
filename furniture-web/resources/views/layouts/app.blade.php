<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'FurniBest')</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
                        colors: {
                            brand: {
                                50: '#f6f6f3',
                                100: '#ecebe2',
                                200: '#d8d4c0',
                                300: '#c0b79a',
                                400: '#a89a75',
                                500: '#917f55',
                                600: '#786845',
                                700: '#5f5237',
                                800: '#453c29',
                                900: '#2f291c',
                            },
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="bg-white text-slate-900 antialiased">
        <div class="min-h-screen">
            <header class="sticky top-0 z-40 border-b border-slate-200/60 bg-white/80 backdrop-blur">
                <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            @php($brandLogo = \App\Models\BrandSetting::current()->logo_url)
                            @if ($brandLogo)
                                <img src="{{ $brandLogo }}" alt="Logo" class="h-9 w-9 rounded-xl border border-slate-200 bg-white object-contain p-1 shadow-sm">
                            @else
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-800 text-white shadow-sm">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M4 10.5 12 6l8 4.5v8A2.5 2.5 0 0 1 17.5 21h-11A2.5 2.5 0 0 1 4 18.5v-8Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 21v-7a1.5 1.5 0 0 1 1.5-1.5h3A1.5 1.5 0 0 1 15 14v7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="leading-tight">
                                <div class="text-sm font-semibold tracking-wide">FurniBest</div>
                                <div class="text-xs text-slate-500"></div>
                            </div>
                        </a>

                        <nav class="hidden items-center gap-6 text-sm font-medium text-slate-700 md:flex">
                            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-slate-900' : 'hover:text-slate-900' }}">Home</a>
                            <a href="{{ route('products') }}" class="{{ request()->routeIs('products') ? 'text-slate-900' : 'hover:text-slate-900' }}">Produk</a>
                            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-slate-900' : 'hover:text-slate-900' }}">Tentang Kami</a>
                            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-slate-900' : 'hover:text-slate-900' }}">Kontak</a>
                            <a href="{{ route('cart.index') }}" class="relative {{ request()->routeIs('cart.*') ? 'text-slate-900' : 'hover:text-slate-900' }}">
                                Keranjang
                                @if (($cartCount ?? 0) > 0)
                                    <span class="absolute -right-3 -top-2 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-slate-900 px-1 text-[10px] font-bold text-white">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </nav>

                        <div class="hidden items-center gap-3 md:flex">
                            @auth
                                <a href="{{ route('orders.mine') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900">Pesanan saya</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Keluar</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Masuk</a>
                                <a href="{{ route('register') }}" class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-800">Daftar</a>
                            @endauth
                        </div>

                        <button type="button" class="inline-flex items-center justify-center rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 md:hidden" aria-label="Buka menu" onclick="document.getElementById('mobileNav').classList.toggle('hidden')">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>

                    <div id="mobileNav" class="hidden border-t border-slate-200/60 py-3 md:hidden">
                        <div class="flex flex-col gap-2 text-sm font-medium text-slate-700">
                            <a href="{{ route('home') }}" class="rounded-lg px-2 py-2 hover:bg-slate-50">Home</a>
                            <a href="{{ route('products') }}" class="rounded-lg px-2 py-2 hover:bg-slate-50">Produk</a>
                            <a href="{{ route('about') }}" class="rounded-lg px-2 py-2 hover:bg-slate-50">Tentang Kami</a>
                            <a href="{{ route('contact') }}" class="rounded-lg px-2 py-2 hover:bg-slate-50">Kontak</a>
                            <a href="{{ route('cart.index') }}" class="rounded-lg px-2 py-2 hover:bg-slate-50">Keranjang @if(($cartCount ?? 0) > 0)({{ $cartCount }})@endif</a>
                            @auth
                                <a href="{{ route('orders.mine') }}" class="rounded-lg px-2 py-2 hover:bg-slate-50">Pesanan saya</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full rounded-lg px-2 py-2 text-left hover:bg-slate-50">Keluar</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="rounded-lg px-2 py-2 hover:bg-slate-50">Masuk</a>
                                <a href="{{ route('register') }}" class="rounded-lg px-2 py-2 hover:bg-slate-50">Daftar</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </header>

            <main>
                @yield('content')
            </main>

            <footer class="border-t border-slate-200/60 bg-white">
                <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
                    <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center">
                        <div>
                            <div class="text-sm font-semibold text-slate-900">FurniBest</div>
                            <div class="mt-1 text-sm text-slate-600">Jam operasional: 09.00–20.00 • Senin–Sabtu</div>
                        </div>
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                            <a href="{{ route('products') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat katalog</a>
                            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800">Hubungi</a>
                        </div>
                    </div>
                    <div class="mt-8 flex flex-col gap-2 border-t border-slate-200/60 pt-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                        <div>© {{ date('Y') }} FurniBest. By. Cacam Furniture Jepara {{ Illuminate\Foundation\Application::VERSION }}.</div>
                        <div>PHP v{{ PHP_VERSION }}</div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
