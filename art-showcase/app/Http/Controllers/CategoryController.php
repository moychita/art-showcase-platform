<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(12);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori baru berhasil dibuat.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validatedData($request, $category);
        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    protected function validatedData(Request $request, ?Category $category = null): array
    {
        $request->merge([
            'slug' => Str::slug($request->input('slug') ?: $request->input('name')),
        ]);

        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'slug' => [
                'required',
                'string',
                'max:120',
                Rule::unique('categories', 'slug')->ignore($category?->id),
            ],
            'description' => ['nullable', 'string', 'max:500'],
        ];

        return $request->validate($rules);
    }
}
