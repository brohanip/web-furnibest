<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ColorSample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ColorSampleController extends Controller
{
    public function index()
    {
        $colorSamples = ColorSample::ordered()->paginate(12);

        return view('admin.color-samples.index', compact('colorSamples'));
    }

    public function create()
    {
        return view('admin.color-samples.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->filled('color_code')) {
            $validated['color_code'] = '#' . ltrim($request->color_code, '#');
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('color-samples', 'public');
        }

        ColorSample::create($validated);

        return redirect()->route('admin.color-samples.index')
            ->with('success', 'Sampel warna berhasil ditambahkan.');
    }

    public function edit(ColorSample $colorSample)
    {
        return view('admin.color-samples.edit', compact('colorSample'));
    }

    public function update(Request $request, ColorSample $colorSample)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->filled('color_code')) {
            $validated['color_code'] = '#' . ltrim($request->color_code, '#');
        } else {
            $validated['color_code'] = null;
        }

        if ($request->hasFile('image')) {
            if ($colorSample->image) {
                Storage::disk('public')->delete($colorSample->image);
            }

            $validated['image'] = $request->file('image')->store('color-samples', 'public');
        }

        $colorSample->update($validated);

        return redirect()->route('admin.color-samples.index')
            ->with('success', 'Sampel warna berhasil diperbarui.');
    }

    public function destroy(ColorSample $colorSample)
    {
        if ($colorSample->image) {
            Storage::disk('public')->delete($colorSample->image);
        }

        $colorSample->delete();

        return redirect()->route('admin.color-samples.index')
            ->with('success', 'Sampel warna berhasil dihapus.');
    }
}
