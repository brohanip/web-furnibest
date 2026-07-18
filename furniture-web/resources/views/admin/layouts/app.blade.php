<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin Panel')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] }
                    }
                }
            }
        </script>
    </head>
    <body class="bg-slate-100 font-sans text-slate-900 antialiased">
        <div class="min-h-screen">
            <header class="border-b border-slate-200 bg-slate-900 text-slate-100">
                <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <h1 class="text-lg font-semibold">FurniBest Admin</h1>
                        <p class="text-xs text-slate-300">Backend management</p>
                    </div>
                    <nav class="flex items-center gap-2 text-sm">
                        <a href="{{ route('admin.categories.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.categories.*') ? 'bg-slate-700 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
                            Kategori
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.products.*') ? 'bg-slate-700 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
                            Produk
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.orders.*') ? 'bg-slate-700 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
                            Pesanan
                        </a>
                        <a href="{{ route('admin.bank-accounts.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.bank-accounts.*') ? 'bg-slate-700 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
                            Rekening Bank
                        </a>
                        <a href="{{ route('admin.branding.edit') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.branding.*') ? 'bg-slate-700 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
                            Branding & Konten
                        </a>
                        <a href="{{ route('home') }}" class="rounded-lg px-3 py-1.5 text-slate-200 hover:bg-slate-800">
                            Lihat Website
                        </a>
                    </nav>
                </div>
            </header>

            @yield('content')
        </div>
    </body>
</html>
