<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function edit()
    {
        $about = AboutSetting::current();

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'headline' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'intro' => 'nullable|string',
            'story' => 'nullable|string',
            'materials_title' => 'required|string|max:100',
            'colors_title' => 'required|string|max:100',
        ]);

        AboutSetting::current()->update($validated);

        return redirect()->route('admin.about.edit')
            ->with('success', 'Halaman Tentang Kami berhasil diperbarui.');
    }
}
