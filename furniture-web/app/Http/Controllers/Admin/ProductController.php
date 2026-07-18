<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $categoryIds = $validated['category_ids'];
        unset($validated['category_ids'], $validated['images']);

        $validated['slug'] = $this->uniqueSlug($validated['name']);

        $product = Product::create($validated);
        $product->categories()->sync($categoryIds);

        $this->storeUploadedImages($product, $request->file('images', []));

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load(['categories', 'images']);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'remove_image_ids' => 'nullable|array',
            'remove_image_ids.*' => 'integer|exists:product_images,id',
        ]);

        if ($product->name !== $validated['name']) {
            $validated['slug'] = $this->uniqueSlug($validated['name'], $product->id);
        }

        $categoryIds = $validated['category_ids'];
        unset($validated['category_ids'], $validated['images'], $validated['remove_image_ids']);

        $product->update($validated);
        $product->categories()->sync($categoryIds);

        if ($request->filled('remove_image_ids')) {
            $this->deleteImages(
                $product,
                ProductImage::where('product_id', $product->id)
                    ->whereIn('id', $request->remove_image_ids)
                    ->get()
            );
        }

        if ($request->hasFile('images')) {
            $this->storeUploadedImages($product, $request->file('images', []));
        }

        $this->syncPrimaryImage($product);

        if (! $product->images()->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['images' => 'Produk harus memiliki minimal satu gambar.']);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $this->deleteImages($product, $product->images()->get());

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $i = 1;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    private function storeUploadedImages(Product $product, array $files): void
    {
        $sortOrder = (int) $product->images()->max('sort_order') + 1;

        foreach ($files as $file) {
            if (! $file) {
                continue;
            }

            $path = $file->store('products', 'public');

            $product->images()->create([
                'path' => $path,
                'sort_order' => $sortOrder++,
            ]);
        }

        $this->syncPrimaryImage($product->fresh());
    }

    private function syncPrimaryImage(Product $product): void
    {
        $first = $product->images()->orderBy('sort_order')->first();

        $product->update([
            'image' => $first?->path,
        ]);
    }

    private function deleteImages(Product $product, $images): void
    {
        foreach ($images as $image) {
            if ($image->product_id !== $product->id) {
                continue;
            }

            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
    }
}
