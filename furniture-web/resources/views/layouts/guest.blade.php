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
                                50: '#f6f6f3', 100: '#ecebe2', 200: '#d8d4c0',
                                600: '#786845', 700: '#5f5237', 800: '#453c29', 900: '#2f291c',
                            },
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="bg-brand-50 font-sans text-slate-900 antialiased">
        <div class="flex min-h-screen flex-col">
            <header class="border-b border-slate-200/60 bg-white/80 backdrop-blur">
                <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6">
                    <a href="{{ route('home') }}" class="text-sm font-semibold tracking-wide">FurniBest</a>
                    <a href="{{ route('home') }}" class="text-sm text-slate-600 hover:text-slate-900">← Kembali ke website</a>
                </div>
            </header>
            <main class="flex flex-1 items-center justify-center px-4 py-10">
                @yield('content')
            </main>
        </div>
    </body>
</html>
