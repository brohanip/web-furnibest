<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    private const SESSION_KEY = 'cart';

    public function items(): array
    {
        return session(self::SESSION_KEY, []);
    }

    public function count(): int
    {
        return (int) array_sum($this->items());
    }

    public function isEmpty(): bool
    {
        return empty($this->items());
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $quantity = max(1, $quantity);
        $cart = $this->items();
        $current = $cart[$product->id] ?? 0;
        $newQty = min($current + $quantity, max(0, (int) $product->stock));

        if ($newQty < 1) {
            return;
        }

        $cart[$product->id] = $newQty;
        session([self::SESSION_KEY => $cart]);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->items();

        if ($quantity < 1) {
            unset($cart[$productId]);
        } else {
            $product = Product::find($productId);
            if ($product) {
                $cart[$productId] = min($quantity, max(0, (int) $product->stock));
                if ($cart[$productId] < 1) {
                    unset($cart[$productId]);
                }
            }
        }

        session([self::SESSION_KEY => $cart]);
    }

    public function remove(int $productId): void
    {
        $cart = $this->items();
        unset($cart[$productId]);
        session([self::SESSION_KEY => $cart]);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function lines(): Collection
    {
        $ids = array_keys($this->items());

        if (empty($ids)) {
            return collect();
        }

        $products = Product::with('images')->whereIn('id', $ids)->get()->keyBy('id');

        return collect($this->items())->map(function ($quantity, $productId) use ($products) {
            $product = $products->get($productId);

            if (! $product) {
                return null;
            }

            $lineTotal = (float) $product->price * $quantity;

            return (object) [
                'product' => $product,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
                'formatted_line_total' => 'Rp ' . number_format($lineTotal, 0, ',', '.'),
                'stock_ok' => $product->stock >= $quantity,
                'max_quantity' => max(0, (int) $product->stock),
            ];
        })->filter()->values();
    }

    public function subtotal(): float
    {
        return (float) $this->lines()->sum('line_total');
    }

    public function formattedSubtotal(): string
    {
        return 'Rp ' . number_format($this->subtotal(), 0, ',', '.');
    }

  /**
     * @return array<int, string>
     */
    public function stockErrors(): array
    {
        $errors = [];

        foreach ($this->lines() as $line) {
            if (! $line->stock_ok) {
                $errors[] = "{$line->product->name}: stok tidak mencukupi (tersedia {$line->product->stock}).";
            }
            if ($line->product->stock <= 0) {
                $errors[] = "{$line->product->name}: stok habis.";
            }
        }

        return $errors;
    }

    public function pruneUnavailable(): void
    {
        $cart = $this->items();

        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);

            if (! $product || $product->stock <= 0) {
                unset($cart[$productId]);
                continue;
            }

            if ($qty > $product->stock) {
                $cart[$productId] = (int) $product->stock;
            }
        }

        session([self::SESSION_KEY => $cart]);
    }
}
