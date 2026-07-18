<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartService $cart)
    {
        $cart->pruneUnavailable();

        return view('pages.cart.index', [
            'lines' => $cart->lines(),
            'subtotal' => $cart->subtotal(),
            'formattedSubtotal' => $cart->formattedSubtotal(),
        ]);
    }

    public function store(Request $request, CartService $cart)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock <= 0) {
            return back()->with('error', 'Produk sedang habis stok.');
        }

        $quantity = (int) ($validated['quantity'] ?? 1);
        $cart->add($product, $quantity);

        if ($request->boolean('redirect_cart')) {
            return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, Product $product, CartService $cart)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $cart->update($product->id, (int) $validated['quantity']);

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(Product $product, CartService $cart)
    {
        $cart->remove($product->id);

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }
}
