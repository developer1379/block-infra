<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected Category $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * Fetch all categories with their subcategories.
     */
    public function all(): Collection
    {
        return $this->model->with('subcategories')->get();
    }

    /**
     * Fetch only active categories.
     */
    public function active(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Find category by ID.
     */
    public function find(int $id): ?Category
    {
        return $this->model->find($id);
    }

    /**
     * Create a new category.
     */
    public function create(array $data): Category
    {
        return $this->model->create($data);
    }

    /**
     * Update a category.
     */
    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    /**
     * Delete a category.
     */
    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    /**
     * Fetch top-level (parent) categories.
     */
    public function getParentCategories(): Collection
    {
        return $this->model
            ->whereNull('parent_id')
            ->orWhere('parent_id', 0)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);
    }

    /**
     * Fetch subcategories for a specific parent category.
     */
    public function getSubcategories(int $parentId): Collection
    {
        return $this->model
            ->where('parent_id', $parentId)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);
    }

    /**
     * ✅ Return parent options for dropdowns (used in forms).
     * Shortcut to getParentCategories(), but separated for clarity.
     */
    public function getParentOptions(): Collection
    {
        return $this->getParentCategories();
    }
}
