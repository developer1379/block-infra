<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $categories;

    public function __construct(CategoryRepositoryInterface $categories)
    {
        $this->categories = $categories;
    }

    public function index()
    {
        $categories = $this->categories->all();
        return view('admin.pages.category.index', compact('categories'));
    }

    public function create()
    {
        $parents = $this->categories->getParentCategories();
        $categories = $this->categories->all();

        return view('admin.pages.category.create', compact('parents', 'categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $this->categories->create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $parents = $this->categories->getParentCategories()
            ->where('id', '!=', $category->id);
        return view('admin.pages.category.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $this->categories->update($category, $validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $this->categories->delete($category);
        return back()->with('success', 'Category deleted successfully!');
    }

    public function getSubcategories($parentId)
    {
        $subcategories = $this->categories->getSubcategories($parentId);
        return response()->json($subcategories);
    }
}
