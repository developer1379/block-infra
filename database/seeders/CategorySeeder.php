<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $main = Category::create([
            'name' => 'Construction',
            'slug' => Str::slug('Construction'),
        ]);

        Category::insert([
            [
                'parent_id' => $main->id,
                'name' => 'Civil Works',
                'slug' => Str::slug('Civil Works'),
            ],
            [
                'parent_id' => $main->id,
                'name' => 'Electrical',
                'slug' => Str::slug('Electrical'),
            ],
            [
                'parent_id' => $main->id,
                'name' => 'Plumbing',
                'slug' => Str::slug('Plumbing'),
            ],
        ]);
    }
}
