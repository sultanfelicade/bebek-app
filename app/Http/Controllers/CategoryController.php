<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()->orderBy('id_category')->get();
        return view('master.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('master.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => ['required', 'string', 'max:50'],
        ]);

        Category::query()->create([
            'category_name' => $validated['category_name'],
        ]);

        return redirect('/master/categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $category = Category::query()->where('id_category', $id)->firstOrFail();
        return view('master.categories.edit', compact('category'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'category_name' => ['required', 'string', 'max:50'],
        ]);

        $category = Category::query()->where('id_category', $id)->firstOrFail();
        $category->update([
            'category_name' => $validated['category_name'],
        ]);

        return redirect('/master/categories')->with('success', 'Kategori berhasil diperbarui.');
    }
}
