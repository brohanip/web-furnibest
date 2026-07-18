<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePromoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomePromoController extends Controller
{
    public function edit()
    {
        $promo = HomePromoSetting::current();

        return view('admin.home-promo.edit', compact('promo'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'package_label' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'discount_badge' => 'nullable|string|max:100',
            'discount_note' => 'nullable|string|max:255',
            'price_label' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'install_note' => 'nullable|string|max:255',
            'stat_rating_label' => 'required|string|max:100',
            'stat_rating_value' => 'required|string|max:50',
            'stat_sold_label' => 'required|string|max:100',
            'stat_sold_value' => 'required|string|max:50',
            'stat_support_label' => 'required|string|max:100',
            'stat_support_value' => 'required|string|max:50',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $promo = HomePromoSetting::current();

        if ($request->boolean('remove_image') && $promo->image) {
            Storage::disk('public')->delete($promo->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($promo->image) {
                Storage::disk('public')->delete($promo->image);
            }

            $validated['image'] = $request->file('image')->store('home-promo', 'public');
        }

        unset($validated['remove_image']);

        $promo->update($validated);

        return redirect()->route('admin.home-promo.edit')
            ->with('success', 'Kartu promo home berhasil diperbarui.');
    }
}
