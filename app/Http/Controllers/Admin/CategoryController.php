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
        try {
            $categories = $this->categories->all();
            return view('admin.category.index', compact('categories'));
        } catch (\Exception $e) {
            \Log::error('Category Index Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load categories.');
        }
    }

    public function create()
    {
        try {
            $parents = $this->categories->getParentCategories();
            $categories = $this->categories->all();
            return view('admin.category.create', compact('parents', 'categories'));
        } catch (\Exception $e) {
            \Log::error('Category Create Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load category creation form.');
        }
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

        try {
            $this->categories->create($validated);
            return redirect()->route('admin.categories.index')
                ->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            \Log::error('Category Store Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create category.');
        }
    }

    public function edit(Category $category)
    {
        try {
            $parents = $this->categories->getParentCategories()
                ->where('id', '!=', $category->id);
            return view('admin.category.edit', compact('category', 'parents'));
        } catch (\Exception $e) {
            \Log::error('Category Edit Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load category details.');
        }
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

        try {
            $this->categories->update($category, $validated);
            return redirect()->route('admin.categories.index')
                ->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Category Update Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update category.');
        }
    }

    public function destroy(Category $category)
    {
        try {
            $this->categories->delete($category);
            return back()->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Category Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete category.');
        }
    }

    public function getSubcategories($parentId)
    {
        try {
            $subcategories = $this->categories->getSubcategories($parentId);
            return response()->json($subcategories);
        } catch (\Exception $e) {
            \Log::error('Get Subcategories Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch subcategories'], 500);
        }
    }
}

