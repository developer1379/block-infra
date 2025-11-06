<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(): Collection
    {
        return Category::with('subcategories')->orderBy('name')->get();
    }

    public function active(): Collection
    {
        return Category::where('is_active', true)->orderBy('name')->get();
    }

    public function find(int $id): ?Category
    {
        return Category::with('subcategories')->find($id);
    }

    public function create(array $data): Category
    {
        $data['slug'] = Str::slug($data['name']);
        return Category::create($data);
    }

    public function update(Category $category, array $data): bool
    {
        $data['slug'] = Str::slug($data['name']);
        return $category->update($data);
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function getParentCategories(): Collection
    {
        return Category::whereNull('parent_id')->orderBy('name')->get();
    }

    public function getSubcategories(int $parentId): Collection
    {
        return Category::where('parent_id', $parentId)->orderBy('name')->get();
    }
}
