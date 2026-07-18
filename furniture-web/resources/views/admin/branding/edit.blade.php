@extends('admin.layouts.app')

@section('title', 'Branding & Konten • Admin')

@section('content')
<section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight">Branding & Konten</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola logo, tampilan halaman depan, dan halaman Tentang Kami.</p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabs --}}
    @php $activeTab = request('tab', 'logo'); @endphp
    <div class="mb-6 flex gap-1 rounded-xl border border-slate-200 bg-slate-100 p-1">
        @foreach(['logo' => 'Logo Navbar', 'hero' => 'Hero Home', 'promo' => 'Promo Home', 'about' => 'Tentang Kami'] as $tab => $label)
            <a href="{{ route('admin.branding.edit', ['tab' => $tab]) }}"
               class="flex-1 rounded-lg py-2 text-center text-xs font-semibold transition
                      {{ $activeTab === $tab ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- ===== TAB: LOGO ===== --}}
    @if($activeTab === 'logo')
    <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
        <p class="mb-5 text-sm text-slate-500">Logo yang tampil di navbar website.</p>
        <form action="{{ route('admin.branding.update') }}" method="POST" enctype="multipart/form-data" class="grid gap-5">
            @csrf @method('PUT')

            <div class="rounded-xl border border-slate-200 p-4">
                <label class="mb-1 block text-sm font-semibold text-slate-700">Logo navbar</label>
                <p class="mb-3 text-xs text-slate-500">Rekomendasi: PNG/WebP background transparan, tinggi 64–128 px.</p>

                @if ($brand->logo_url)
                    <div class="mb-3 rounded-xl border border-slate-200 bg-slate-50 p-4 flex items-center gap-3">
                        <img src="{{ $brand->logo_url }}" alt="Logo" class="h-10 w-10 rounded-xl object-contain bg-white border border-slate-200 p-1">
                        <span class="text-sm font-semibold text-slate-800">Logo aktif</span>
                    </div>
                    <label class="mb-3 flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remove_logo" value="1"> Hapus logo saat ini
                    </label>
                @endif

                <input type="file" name="logo" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
                @error('logo') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2">
                <a href="{{ route('home') }}" target="_blank" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat website</a>
                <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Simpan</button>
            </div>
        </form>
    </div>
    @endif

    {{-- ===== TAB: HERO ===== --}}
    @if($activeTab === 'hero')
    <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
        <p class="mb-5 text-sm text-slate-500">Gambar background bagian hero di halaman depan.</p>
        <form action="{{ route('admin.branding.hero') }}" method="POST" enctype="multipart/form-data" class="grid gap-5">
            @csrf @method('PUT')

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <label class="flex cursor-pointer items-center gap-2 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $hero->is_active) ? 'checked' : '' }}>
                    Tampilkan gambar background hero
                </label>
                <p class="mt-1 text-xs text-slate-500">Jika dimatikan, hero memakai gradien default tanpa foto.</p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <label class="mb-1 block text-sm font-semibold text-slate-700">Gambar background hero</label>
                <p class="mb-3 text-xs text-slate-500">Landscape 1920×1080 px atau lebih besar.</p>

                @if ($hero->background_image_url)
                    <div class="mb-3 overflow-hidden rounded-xl border border-slate-200">
                        <img src="{{ $hero->background_image_url }}" alt="Hero" class="h-40 w-full object-cover">
                    </div>
                    <label class="mb-3 flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remove_background_image" value="1"> Hapus gambar saat ini
                    </label>
                @endif

                <input type="file" name="background_image" accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
                @error('background_image') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2">
                <a href="{{ route('home') }}" target="_blank" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat website</a>
                <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Simpan</button>
            </div>
        </form>
    </div>
    @endif

    {{-- ===== TAB: PROMO ===== --}}
    @if($activeTab === 'promo')
    <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
        <p class="mb-5 text-sm text-slate-500">Kartu promo di bagian kanan halaman depan.</p>
        <form action="{{ route('admin.branding.promo') }}" method="POST" enctype="multipart/form-data" class="grid gap-5">
            @csrf @method('PUT')

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <label class="flex cursor-pointer items-center gap-2 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }}>
                    Tampilkan kartu promo di halaman home
                </label>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Label paket</label>
                    <input type="text" name="package_label" value="{{ old('package_label', $promo->package_label) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('package_label') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Judul paket</label>
                    <input type="text" name="title" value="{{ old('title', $promo->title) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('title') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Isi paket</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $promo->subtitle) }}" placeholder="Sofa + meja + karpet" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Badge diskon</label>
                    <input type="text" name="discount_badge" value="{{ old('discount_badge', $promo->discount_badge) }}" placeholder="Diskon 20%" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Catatan promo</label>
                    <input type="text" name="discount_note" value="{{ old('discount_note', $promo->discount_note) }}" placeholder="hingga akhir bulan" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Label harga</label>
                    <input type="text" name="price_label" value="{{ old('price_label', $promo->price_label) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('price_label') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Harga (angka)</label>
                    <input type="number" name="price" min="0" value="{{ old('price', $promo->price) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('price') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Info pemasangan</label>
                <input type="text" name="install_note" value="{{ old('install_note', $promo->install_note) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <label class="mb-1 block text-sm font-semibold text-slate-700">Gambar background area harga</label>
                <p class="mb-3 text-xs text-slate-500">Min. 800×600 px, foto furniture landscape.</p>
                @if ($promo->image_url)
                    <div class="mb-3 overflow-hidden rounded-xl border border-slate-200">
                        <img src="{{ $promo->image_url }}" alt="Promo" class="h-32 w-full object-cover">
                    </div>
                    <label class="mb-3 flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remove_image" value="1"> Hapus gambar saat ini
                    </label>
                @endif
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
                @error('image') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="border-t border-slate-200 pt-4">
                <div class="mb-3 text-sm font-semibold text-slate-800">Statistik bawah kartu</div>
                <div class="grid gap-4 sm:grid-cols-3">
                    @foreach([['rating', 'Rating'], ['sold', 'Terjual'], ['support', 'Support']] as [$key, $label])
                    <div class="space-y-2 rounded-xl border border-slate-200 p-3">
                        <div class="text-xs font-medium text-slate-500">{{ $label }}</div>
                        <input type="text" name="stat_{{ $key }}_label" value="{{ old('stat_'.$key.'_label', $promo->{'stat_'.$key.'_label'}) }}" placeholder="Label" class="w-full rounded-lg border border-slate-200 px-3 py-1.5 text-xs">
                        <input type="text" name="stat_{{ $key }}_value" value="{{ old('stat_'.$key.'_value', $promo->{'stat_'.$key.'_value'}) }}" placeholder="Nilai" class="w-full rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-semibold">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('home') }}" target="_blank" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat website</a>
                <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Simpan</button>
            </div>
        </form>
    </div>
    @endif

    {{-- ===== TAB: TENTANG KAMI ===== --}}
    @if($activeTab === 'about')
    <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm">
        <p class="mb-5 text-sm text-slate-500">Teks utama halaman Tentang Kami.</p>
        <form action="{{ route('admin.branding.about') }}" method="POST" class="grid gap-4">
            @csrf @method('PUT')

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Judul halaman</label>
                <input type="text" name="headline" value="{{ old('headline', $about->headline) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                @error('headline') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Subjudul</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $about->subtitle) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Intro (paragraf pembuka)</label>
                <textarea name="intro" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">{{ old('intro', $about->intro) }}</textarea>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Cerita kami</label>
                <textarea name="story" rows="6" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">{{ old('story', $about->story) }}</textarea>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Judul section bahan</label>
                    <input type="text" name="materials_title" value="{{ old('materials_title', $about->materials_title) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('materials_title') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Judul section sampel warna</label>
                    <input type="text" name="colors_title" value="{{ old('colors_title', $about->colors_title) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    @error('colors_title') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.materials.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kelola Bahan</a>
                <a href="{{ route('admin.color-samples.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kelola Sampel Warna</a>
                <a href="{{ route('about') }}" target="_blank" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat halaman</a>
                <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Simpan</button>
            </div>
        </form>
    </div>
    @endif

</section>
@endsection
