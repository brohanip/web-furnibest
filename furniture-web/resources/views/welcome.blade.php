<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FurniBest</title>

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
        @php
            $categories = [
                ['name' => 'Sofa', 'desc' => 'Nyaman untuk ruang keluarga', 'accent' => 'from-brand-600 to-brand-800'],
                ['name' => 'Meja', 'desc' => 'Minimalis & fungsional', 'accent' => 'from-slate-600 to-slate-800'],
                ['name' => 'Kursi', 'desc' => 'Ergonomis untuk kerja', 'accent' => 'from-emerald-600 to-emerald-800'],
                ['name' => 'Lemari', 'desc' => 'Rapi, kuat, dan luas', 'accent' => 'from-amber-600 to-amber-800'],
            ];
            $featured = [
                ['name' => 'Sofa L-Shape Nordic', 'price' => 3499000, 'tag' => 'Best Seller'],
                ['name' => 'Meja Makan Kayu Jati', 'price' => 2899000, 'tag' => 'Limited'],
                ['name' => 'Kursi Kerja Ergonomic', 'price' => 1199000, 'tag' => 'New'],
                ['name' => 'Lemari 2 Pintu Modern', 'price' => 1999000, 'tag' => 'Hot'],
            ];
            $formatRupiah = fn (int $n) => 'Rp ' . number_format($n, 0, ',', '.');
        @endphp

        <div class="min-h-screen">
            <header class="sticky top-0 z-40 border-b border-slate-200/60 bg-white/80 backdrop-blur">
                <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-800 text-white shadow-sm">
                                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                    <path d="M4 10.5 12 6l8 4.5v8A2.5 2.5 0 0 1 17.5 21h-11A2.5 2.5 0 0 1 4 18.5v-8Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 21v-7a1.5 1.5 0 0 1 1.5-1.5h3A1.5 1.5 0 0 1 15 14v7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="leading-tight">
                                <div class="text-sm font-semibold tracking-wide">FurniBest</div>
                                <div class="text-xs text-slate-500">Craft Modern Furniture For Your Comfort Zone</div>
                            </div>
                        </div>

                        <nav class="hidden items-center gap-6 text-sm font-medium text-slate-700 md:flex">
                            <a href="#kategori" class="hover:text-slate-900">Kategori</a>
                            <a href="#unggulan" class="hover:text-slate-900">Produk unggulan</a>
                            <a href="#testimoni" class="hover:text-slate-900">Testimoni</a>
                            <a href="#kontak" class="hover:text-slate-900">Kontak</a>
                        </nav>

                        <div class="hidden items-center gap-3 md:flex">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/home') }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Masuk</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-800">Daftar</a>
                                    @endif
                                @endauth
                            @endif
                        </div>

                        <button type="button" class="inline-flex items-center justify-center rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 md:hidden" aria-label="Buka menu" onclick="document.getElementById('mobileNav').classList.toggle('hidden')">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>

                    <div id="mobileNav" class="hidden border-t border-slate-200/60 py-3 md:hidden">
                        <div class="flex flex-col gap-2 text-sm font-medium text-slate-700">
                            <a href="#kategori" class="rounded-lg px-2 py-2 hover:bg-slate-50">Kategori</a>
                            <a href="#unggulan" class="rounded-lg px-2 py-2 hover:bg-slate-50">Produk unggulan</a>
                            <a href="#testimoni" class="rounded-lg px-2 py-2 hover:bg-slate-50">Testimoni</a>
                            <a href="#kontak" class="rounded-lg px-2 py-2 hover:bg-slate-50">Kontak</a>
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/home') }}" class="rounded-lg px-2 py-2 hover:bg-slate-50">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="rounded-lg px-2 py-2 hover:bg-slate-50">Masuk</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="rounded-lg px-2 py-2 hover:bg-slate-50">Daftar</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <main>
                <section class="relative overflow-hidden">
                    <div class="absolute inset-0 -z-10 bg-gradient-to-b from-brand-50 via-white to-white"></div>
                    <div class="absolute -top-24 right-0 -z-10 h-72 w-72 rounded-full bg-brand-200/40 blur-3xl"></div>
                    <div class="absolute -bottom-24 left-0 -z-10 h-72 w-72 rounded-full bg-slate-200/50 blur-3xl"></div>

                    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
                        <div class="grid items-center gap-10 lg:grid-cols-2">
                            <div>
                                <div class="inline-flex items-center gap-2 rounded-full border border-brand-200/60 bg-white px-3 py-1 text-xs font-semibold text-brand-800 shadow-sm">
                                    <span class="inline-block h-2 w-2 rounded-full bg-brand-600"></span>
                                    Baru: koleksi minimalis 2026
                                </div>
                                <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl">
                                    Buat rumah terasa <span class="text-brand-700">hangat</span> dengan furniture pilihan.
                                </h1>
                                <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-600">
                                    Desain modern, material berkualitas, dan harga masuk akal. Mulai dari sofa, meja, kursi kerja, sampai lemari—semua siap mempercantik ruangmu.
                                </p>
                                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                                    <a href="#unggulan" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                                        Lihat produk unggulan
                                    </a>
                                    <a href="#kontak" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                        Konsultasi gratis
                                    </a>
                                </div>

                                <dl class="mt-8 grid grid-cols-3 gap-4 rounded-2xl border border-slate-200/60 bg-white/70 p-4 shadow-sm">
                                    <div>
                                        <dt class="text-xs font-medium text-slate-500">Garansi</dt>
                                        <dd class="mt-1 text-sm font-semibold text-slate-900">12 bulan</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-medium text-slate-500">Pengiriman</dt>
                                        <dd class="mt-1 text-sm font-semibold text-slate-900">Jepara</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-medium text-slate-500">Material</dt>
                                        <dd class="mt-1 text-sm font-semibold text-slate-900">Premium</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="relative">
                                <div class="absolute -inset-4 -z-10 rounded-3xl bg-gradient-to-br from-brand-200/60 to-slate-200/50 blur-2xl"></div>
                                <div class="overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-sm">
                                    <div class="grid gap-0 lg:grid-cols-2">
                                        <div class="p-6">
                                            <div class="text-xs font-semibold text-slate-500">Paket ruang tamu</div>
                                            <div class="mt-2 text-lg font-semibold text-slate-900">Nordic Living Set</div>
                                            <div class="mt-1 text-sm text-slate-600">Sofa + meja + karpet</div>
                                            <div class="mt-4 flex items-center gap-2">
                                                <span class="rounded-full bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">Diskon 20%</span>
                                                <span class="text-xs text-slate-500">hingga akhir bulan</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center bg-gradient-to-br from-brand-700 to-slate-900 p-6 text-white">
                                            <div class="text-center">
                                                <div class="text-xs font-semibold text-white/80">Mulai dari</div>
                                                <div class="mt-1 text-3xl font-bold">{{ $formatRupiah(3999000) }}</div>
                                                <div class="mt-2 text-xs text-white/80">Pasang di rumah dalam 2–3 hari</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 border-t border-slate-200/60 bg-white">
                                        <div class="p-4 text-center">
                                            <div class="text-xs text-slate-500">Rating</div>
                                            <div class="mt-1 text-sm font-semibold">4.8/5</div>
                                        </div>
                                        <div class="border-x border-slate-200/60 p-4 text-center">
                                            <div class="text-xs text-slate-500">Terjual</div>
                                            <div class="mt-1 text-sm font-semibold">1.2k+</div>
                                        </div>
                                        <div class="p-4 text-center">
                                            <div class="text-xs text-slate-500">Support</div>
                                            <div class="mt-1 text-sm font-semibold">7 hari</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="kategori" class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
                    <div class="flex items-end justify-between gap-6">
                        <div>
                            <h2 class="text-2xl font-bold tracking-tight">Belanja berdasarkan kategori</h2>
                            <p class="mt-2 text-sm text-slate-600">Mulai dari yang paling kamu butuhkan.</p>
                        </div>
                        <a href="#unggulan" class="hidden text-sm font-semibold text-brand-800 hover:text-brand-900 sm:inline">Lihat produk unggulan →</a>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($categories as $c)
                            <a href="#unggulan" class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                <div class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-gradient-to-br {{ $c['accent'] }} opacity-20 blur-2xl"></div>
                                <div class="flex items-center justify-between">
                                    <div class="text-lg font-semibold text-slate-900">{{ $c['name'] }}</div>
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-900 text-white transition group-hover:bg-brand-800">
                                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                            <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-2 text-sm text-slate-600">{{ $c['desc'] }}</div>
                                <div class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-slate-700">
                                    Jelajahi
                                    <span class="text-slate-400">•</span>
                                    Pilihan terbaik
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                <section id="unggulan" class="bg-slate-50/70">
                    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
                        <div class="flex items-end justify-between gap-6">
                            <div>
                                <h2 class="text-2xl font-bold tracking-tight">Produk unggulan</h2>
                                <p class="mt-2 text-sm text-slate-600">Data masih dummy—nanti kita ambil dari database `products`.</p>
                            </div>
                            <a href="#kontak" class="hidden text-sm font-semibold text-slate-900 hover:text-slate-700 sm:inline">Minta rekomendasi →</a>
                        </div>

                        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach ($featured as $p)
                                <div class="overflow-hidden rounded-2xl border border-slate-200/60 bg-white shadow-sm">
                                    <div class="relative h-36 bg-gradient-to-br from-slate-200 to-slate-100">
                                        <div class="absolute left-4 top-4 rounded-full bg-slate-900 px-2 py-1 text-[11px] font-semibold text-white">{{ $p['tag'] }}</div>
                                        <div class="absolute bottom-3 left-4 right-4 text-xs text-slate-500">Gambar produk (placeholder)</div>
                                    </div>
                                    <div class="p-5">
                                        <div class="text-sm font-semibold text-slate-900">{{ $p['name'] }}</div>
                                        <div class="mt-1 text-sm text-slate-600">{{ $formatRupiah($p['price']) }}</div>
                                        <div class="mt-4 flex items-center justify-between">
                                            <button type="button" class="rounded-xl bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800">
                                                Tambah ke keranjang
                                            </button>
                                            <button type="button" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                                Detail
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section id="testimoni" class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
                    <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
                        <div>
                            <h2 class="text-2xl font-bold tracking-tight">Dipercaya banyak pelanggan</h2>
                            <p class="mt-2 text-sm text-slate-600">Kita fokus pada kualitas material dan finishing, supaya furniture awet dipakai bertahun-tahun.</p>

                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
                                    <div class="text-sm font-semibold">“Sofanya empuk dan rapi.”</div>
                                    <div class="mt-2 text-sm text-slate-600">Pengiriman cepat, warna sesuai foto. Recommended!</div>
                                    <div class="mt-4 text-xs font-semibold text-slate-500">— Rani, Depok</div>
                                </div>
                                <div class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
                                    <div class="text-sm font-semibold">“Meja makan solid banget.”</div>
                                    <div class="mt-2 text-sm text-slate-600">Kayunya tebal dan finishing halus. Mantap.</div>
                                    <div class="mt-4 text-xs font-semibold text-slate-500">— Dimas, Jakarta</div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200/60 bg-gradient-to-br from-white to-brand-50 p-6 shadow-sm">
                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-white">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                                        <path d="M7 11a3 3 0 1 1 3-3M7 21h6a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4h0Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14 3h7M14 7h7M14 11h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold">Butuh rekomendasi untuk ruanganmu?</div>
                                    <div class="mt-1 text-sm text-slate-600">Kirim ukuran ruangan + style yang kamu suka, nanti saya buatkan saran produk.</div>
                                </div>
                            </div>

                            <form class="mt-6 grid gap-3 sm:grid-cols-2">
                                <label class="grid gap-1">
                                    <span class="text-xs font-semibold text-slate-600">Nama</span>
                                    <input type="text" placeholder="Nama kamu" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                                </label>
                                <label class="grid gap-1">
                                    <span class="text-xs font-semibold text-slate-600">WhatsApp</span>
                                    <input type="text" placeholder="08xxxxxxxxxx" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none ring-brand-200 focus:ring-4">
                                </label>
                                <label class="grid gap-1 sm:col-span-2">
                                    <span class="text-xs font-semibold text-slate-600">Kebutuhan</span>
                                    <textarea rows="3" placeholder="Contoh: ruang tamu 3x4m, warna kayu natural, ingin sofa L" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none ring-brand-200 focus:ring-4"></textarea>
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

                <section id="kontak" class="border-t border-slate-200/60 bg-white">
                    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
                        <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center">
                            <div>
                                <div class="text-sm font-semibold text-slate-900">FurniBest</div>
                                <div class="mt-1 text-sm text-slate-600">Jam operasional: 09.00–20.00 • Senin–Sabtu</div>
                            </div>
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                                <a href="#unggulan" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat katalog</a>
                                <a href="#" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800">Chat WhatsApp</a>
                            </div>
                        </div>
                        <div class="mt-8 flex flex-col gap-2 border-t border-slate-200/60 pt-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                            <div>© {{ date('Y') }} FurniBest. Dibuat dengan Laravel {{ Illuminate\Foundation\Application::VERSION }}.</div>
                            <div>PHP v{{ PHP_VERSION }}</div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
