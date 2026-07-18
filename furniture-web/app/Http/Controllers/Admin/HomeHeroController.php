<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeHeroSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeHeroController extends Controller
{
    public function edit()
    {
        $hero = HomeHeroSetting::current();

        return view('admin.home-hero.edit', compact('hero'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'is_active' => 'nullable|boolean',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'remove_background_image' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $hero = HomeHeroSetting::current();

        if ($request->boolean('remove_background_image') && $hero->background_image) {
            Storage::disk('public')->delete($hero->background_image);
            $validated['background_image'] = null;
        }

        if ($request->hasFile('background_image')) {
            if ($hero->background_image) {
                Storage::disk('public')->delete($hero->background_image);
            }

            $validated['background_image'] = $request->file('background_image')->store('home-hero', 'public');
        }

        unset($validated['remove_background_image']);

        $hero->update($validated);

        return redirect()->route('admin.home-hero.edit')
            ->with('success', 'Background hero home berhasil diperbarui.');
    }
}
