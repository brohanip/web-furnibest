<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use App\Models\BrandSetting;
use App\Models\HomeHeroSetting;
use App\Models\HomePromoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandingController extends Controller
{
    public function edit()
    {
        $brand = BrandSetting::current();
        $hero  = HomeHeroSetting::current();
        $promo = HomePromoSetting::current();
        $about = AboutSetting::current();

        return view('admin.branding.edit', compact('brand', 'hero', 'promo', 'about'));
    }

    // --- Logo ---
    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $brand = BrandSetting::current();

        if ($request->boolean('remove_logo') && $brand->logo_path) {
            Storage::disk('public')->delete($brand->logo_path);
            $brand->update(['logo_path' => null]);
        }

        if ($request->hasFile('logo')) {
            if ($brand->logo_path) Storage::disk('public')->delete($brand->logo_path);
            $brand->update(['logo_path' => $request->file('logo')->store('branding', 'public')]);
        }

        return redirect()->route('admin.branding.edit', ['tab' => 'logo'])
            ->with('success', 'Logo berhasil diperbarui.');
    }

    // --- Hero Home ---
    public function updateHero(Request $request)
    {
        $request->validate([
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $hero = HomeHeroSetting::current();
        $data = ['is_active' => $request->boolean('is_active')];

        if ($request->boolean('remove_background_image') && $hero->background_image) {
            Storage::disk('public')->delete($hero->background_image);
            $data['background_image'] = null;
        }

        if ($request->hasFile('background_image')) {
            if ($hero->background_image) Storage::disk('public')->delete($hero->background_image);
            $data['background_image'] = $request->file('background_image')->store('home-hero', 'public');
        }

        $hero->update($data);

        return redirect()->route('admin.branding.edit', ['tab' => 'hero'])
            ->with('success', 'Hero home berhasil diperbarui.');
    }

    // --- Promo Home ---
    public function updatePromo(Request $request)
    {
        $validated = $request->validate([
            'package_label'      => 'required|string|max:255',
            'title'              => 'required|string|max:255',
            'subtitle'           => 'nullable|string|max:255',
            'discount_badge'     => 'nullable|string|max:100',
            'discount_note'      => 'nullable|string|max:255',
            'price_label'        => 'required|string|max:100',
            'price'              => 'required|numeric|min:0',
            'install_note'       => 'nullable|string|max:255',
            'stat_rating_label'  => 'required|string|max:100',
            'stat_rating_value'  => 'required|string|max:50',
            'stat_sold_label'    => 'required|string|max:100',
            'stat_sold_value'    => 'required|string|max:50',
            'stat_support_label' => 'required|string|max:100',
            'stat_support_value' => 'required|string|max:50',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $promo = HomePromoSetting::current();

        if ($request->boolean('remove_image') && $promo->image) {
            Storage::disk('public')->delete($promo->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($promo->image) Storage::disk('public')->delete($promo->image);
            $validated['image'] = $request->file('image')->store('home-promo', 'public');
        }

        unset($validated['remove_image']);
        $promo->update($validated);

        return redirect()->route('admin.branding.edit', ['tab' => 'promo'])
            ->with('success', 'Kartu promo home berhasil diperbarui.');
    }

    // --- Tentang Kami ---
    public function updateAbout(Request $request)
    {
        $validated = $request->validate([
            'headline'        => 'required|string|max:255',
            'subtitle'        => 'nullable|string|max:255',
            'intro'           => 'nullable|string',
            'story'           => 'nullable|string',
            'materials_title' => 'required|string|max:100',
            'colors_title'    => 'required|string|max:100',
        ]);

        AboutSetting::current()->update($validated);

        return redirect()->route('admin.branding.edit', ['tab' => 'about'])
            ->with('success', 'Halaman Tentang Kami berhasil diperbarui.');
    }
}

