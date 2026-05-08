<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = DB::table('m_products as p')
            ->leftJoin('m_categories as c', 'c.id_category', '=', 'p.id_category')
            ->select([
                'p.id_product',
                'p.id_category',
                'p.product_name',
                'p.price',
                'c.category_name',
            ])
            ->orderBy('p.id_product', 'desc')
            ->get();

        return view('master.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::query()->orderBy('category_name')->get();
        return view('master.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:100'],
            'id_category' => ['nullable', 'integer', 'exists:m_categories,id_category'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        Product::query()->create([
            'product_name' => $validated['product_name'],
            'id_category' => $validated['id_category'] ?? null,
            'price' => number_format((float) $validated['price'], 2, '.', ''),
        ]);

        return redirect('/master/products')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $product = Product::query()->where('id_product', $id)->firstOrFail();
        $categories = Category::query()->orderBy('category_name')->get();
        return view('master.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:100'],
            'id_category' => ['nullable', 'integer', 'exists:m_categories,id_category'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $product = Product::query()->where('id_product', $id)->firstOrFail();
        $product->update([
            'product_name' => $validated['product_name'],
            'id_category' => $validated['id_category'] ?? null,
            'price' => number_format((float) $validated['price'], 2, '.', ''),
        ]);

        return redirect('/master/products')->with('success', 'Menu berhasil diperbarui.');
    }
}
