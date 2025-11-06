<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;
use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function all(): Collection;
    public function active(): Collection;
    public function find(int $id): ?Category;
    public function create(array $data): Category;
    public function update(Category $category, array $data): bool;
    public function delete(Category $category): bool;
    public function getParentCategories(): Collection;
    public function getSubcategories(int $parentId): Collection;
}
