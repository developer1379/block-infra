<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Work;
use App\Models\Unit;

class WorkSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Excavation and Earthwork' => [
                ['name' => 'Site Clearing and Grubbing', 'labor' => '8–15', 'labor_material' => '20–35', 'unit' => 'per sqft'],
                ['name' => 'Manual Excavation', 'labor' => '12–25', 'labor_material' => '30–60', 'unit' => 'per sqft'],
                ['name' => 'Mechanical Excavation', 'labor' => '15–40', 'labor_material' => '50–100', 'unit' => 'per sqft'],
                ['name' => 'Earth Filling and Compaction', 'labor' => '10–25', 'labor_material' => '30–70', 'unit' => 'per sqft'],
                ['name' => 'Dewatering and Temporary Drainage', 'labor' => null, 'labor_material' => '40000–100000', 'unit' => 'project-wise'],
            ],
            'Foundation Works' => [
                ['name' => 'Strip/Trench Foundations', 'labor' => '20–50', 'labor_material' => '80–150', 'unit' => 'per sqft'],
                ['name' => 'Pad/Isolated Footings', 'labor' => '25–60', 'labor_material' => '100–180', 'unit' => 'per sqft'],
                ['name' => 'Raft Foundations', 'labor' => '30–70', 'labor_material' => '120–220', 'unit' => 'per sqft'],
                ['name' => 'Pile Foundation Installation', 'labor' => null, 'labor_material' => '1200–1800', 'unit' => 'per linear foot'],
                ['name' => 'Foundation Waterproofing/DPC', 'labor' => '15–40', 'labor_material' => '60–120', 'unit' => 'per sqft'],
            ],
            'Concrete Works' => [
                ['name' => 'Formwork and Shuttering', 'labor' => '25–60', 'labor_material' => '100–200', 'unit' => 'per sqft'],
                ['name' => 'Reinforcement Placement', 'labor' => '20–50', 'labor_material' => '80–150', 'unit' => 'per sqft'],
                ['name' => 'Concrete Pouring & Finishing', 'labor' => '25–55', 'labor_material' => '100–200', 'unit' => 'per sqft'],
                ['name' => 'Curing', 'labor' => '3–7', 'labor_material' => null, 'unit' => 'per sqft'],
                ['name' => 'Concrete Repair', 'labor' => null, 'labor_material' => '50–150', 'unit' => 'per sqft'],
            ],
            'Masonry Works' => [
                ['name' => 'Brick Masonry', 'labor' => '20–35', 'labor_material' => '60–120', 'unit' => 'per sqft'],
                ['name' => 'Concrete Block Masonry', 'labor' => '15–30', 'labor_material' => '50–100', 'unit' => 'per sqft'],
                ['name' => 'Stone Masonry', 'labor' => '35–60', 'labor_material' => '120–220', 'unit' => 'per sqft'],
                ['name' => 'Cavity and Partition Walls', 'labor' => '20–40', 'labor_material' => '70–130', 'unit' => 'per sqft'],
                ['name' => 'Masonry Reinforcement', 'labor' => '15–35', 'labor_material' => null, 'unit' => 'per sqft'],
            ],
        ];

        foreach ($data as $categoryName => $works) {
            $category = Category::firstOrCreate(['name' => $categoryName], ['is_active' => true]);

            foreach ($works as $item) {
                $unit = Unit::firstOrCreate(['name' => $item['unit']]);
                [$laborMin, $laborMax] = $this->parseRange($item['labor']);
                [$lmMin, $lmMax] = $this->parseRange($item['labor_material']);

                Work::create([
                    'category_id' => $category->id,
                    'unit_id' => $unit->id,
                    'name' => $item['name'],
                    'labor_min' => $laborMin,
                    'labor_max' => $laborMax,
                    'labor_material_min' => $lmMin,
                    'labor_material_max' => $lmMax,
                    'is_active' => true,
                ]);
            }
        }
    }

    private function parseRange(?string $text): array
    {
        if (!$text) return [null, null];
        $clean = str_replace([',', '₹', ' '], '', $text);
        $parts = preg_split('/[-–]/', $clean);
        return [
            isset($parts[0]) ? (float)$parts[0] : null,
            isset($parts[1]) ? (float)$parts[1] : null,
        ];
    }
}
