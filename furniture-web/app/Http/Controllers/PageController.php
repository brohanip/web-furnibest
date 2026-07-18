<?php

namespace App\Http\Controllers;

use App\Models\AboutSetting;
use App\Models\Category;
use App\Models\ColorSample;
use App\Models\HomeHeroSetting;
use App\Models\HomePromoSetting;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $featuredCategory = Category::where('slug', 'produk-unggulan')->first();

        $featuredProducts = collect();
        if ($featuredCategory) {
            $featuredProducts = Product::with(['categories', 'images'])
                ->whereHas('categories', function ($c) use ($featuredCategory) {
                    $c->where('categories.id', $featuredCategory->id);
                })
                ->latest()
                ->take(8)
                ->get();
        }

        $categories = Category::orderBy('name')->get();
        $homePromo = HomePromoSetting::current();
        $homeHero = HomeHeroSetting::current();

        return view('pages.home', compact('featuredProducts', 'categories', 'featuredCategory', 'homePromo', 'homeHero'));
    }

    public function products(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $activeCategory = null;
        if ($request->filled('kategori')) {
            $activeCategory = Category::where('slug', $request->kategori)->first();
        }

        $keyword = trim($request->input('cari', ''));

        // Ambil semua produk (dengan relasi)
        $allProducts = Product::with(['categories', 'images'])->latest()->get();

        // --- Sequential Search berdasarkan nama ---
        if ($keyword !== '') {
            $keywordLower = mb_strtolower($keyword);
            $searchResult = collect();

            foreach ($allProducts as $product) {
                // Telusuri satu per satu, cocokkan nama secara case-insensitive
                if (mb_strpos(mb_strtolower($product->name), $keywordLower) !== false) {
                    $searchResult->push($product);
                }
            }

            $allProducts = $searchResult;
        }

        // Filter kategori (setelah sequential search)
        if ($activeCategory) {
            $allProducts = $allProducts->filter(function ($product) use ($activeCategory) {
                return $product->categories->contains('id', $activeCategory->id);
            });
        }

        // Paginasi manual
        $page      = $request->input('page', 1);
        $perPage   = 12;
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $allProducts->forPage($page, $perPage)->values(),
            $allProducts->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $products = $paginator;

        return view('pages.products', compact('products', 'categories', 'activeCategory', 'keyword'));
    }

    public function about()
    {
        $about = AboutSetting::current();
        $materials = Material::active()->ordered()->get();
        $colorSamples = ColorSample::active()->ordered()->get();

        return view('pages.about', compact('about', 'materials', 'colorSamples'));
    }

    public function productShow(Product $product)
    {
        $product->load(['categories', 'images']);

        return view('pages.product-show', compact('product'));
    }

    public function contact(Request $request)
    {
        $consultProduct = null;

        if ($request->filled('produk')) {
            $consultProduct = Product::where('slug', $request->produk)->first();
        }

        return view('pages.contact', compact('consultProduct'));
    }
}
