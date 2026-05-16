<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories', ['categories' => Category::latest()->paginate(15)]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'max:80'], 'description' => ['nullable', 'max:500']]);
        Category::create($data + ['slug' => Str::slug($data['name'])]);

        return back()->with('success', 'Category created.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate(['name' => ['required', 'max:80'], 'description' => ['nullable', 'max:500'], 'is_active' => ['nullable']]);
        $category->update($data + ['slug' => Str::slug($data['name']), 'is_active' => $request->boolean('is_active')]);

        return back()->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
}
