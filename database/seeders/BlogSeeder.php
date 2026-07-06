<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Top 10 Construction Technology Trends to Watch in 2026',
                'slug' => 'top-10-construction-technology-trends-in-2026',
                'category' => 'Construction',
                'content' => "As we move into 2026, the construction sector is undergoing a massive digital transformation. From automated masonry robots to drone mapping and BIM integrations, technology is reshaping building speed, safety, and precision.

Here are the key trends driving this shift:

1. Building Information Modeling (BIM) Level 3:
Collaborative, cloud-based modeling enables architects, contractors, and owners to share real-time blueprints and structural calculations instantly.

2. Automated and Robotic Operations:
Bricklaying robots and automated excavators are filling labor gaps on repetitive tasks, improving efficiency by up to 35%.

3. IoT-Enabled Wearables:
Smart boots, helmets with thermal sensors, and real-time location beacons are safeguarding project laborers, decreasing overall job-site incidents significantly.

4. 3D Concrete Printing:
Architects are printing custom structural elements on-site, dropping concrete material waste by nearly half and opening creative architectural design options.",
                'image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&q=80&w=800',
                'meta_title' => 'Top 10 Construction Technology Trends in 2026 | Bloc-Infra',
                'meta_description' => 'Explore the primary technology trends transforming the construction sector in 2026, including BIM Level 3, robotic bricklayers, and IoT safety systems.',
                'meta_keywords' => 'construction trends, building technology, robotics, smart sites, BIM 2026',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'A Strategic Guide to Real Estate Investment in Kanpur',
                'slug' => 'strategic-guide-real-estate-investment-kanpur',
                'category' => 'Real Estate',
                'content' => "Kanpur is fast becoming one of the most attractive real estate markets in Uttar Pradesh. Supported by government initiatives, expanding metro networks, and regional development projects, cities are growing outwards, opening incredible long-term investment portfolios.

Key Factors to Consider:

1. Infrastructure Corridors:
Properties situated near the metro routes, highways, and designated IT corridors (like Vikas Nagar extensions) are showing a consistent 8-12% annual capital appreciation.

2. Residential vs. Commercial Portfolios:
While residential projects offer excellent tenant stability and secure rental yields, commercial developments (retail shops, warehouses, office spaces) provide higher, faster returns if managed properly.

3. Developer Credibility & RERA:
Verify that all projects you invest in have clear RERA registration numbers and verified land titles to eliminate regulatory and project delivery delays.

Invest wisely by performing thorough site audits and understanding the market trends of different local sub-neighborhoods.",
                'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=800',
                'meta_title' => 'Real Estate Investment Guide Kanpur | Bloc-Infra Insights',
                'meta_description' => 'Looking to invest in real estate in Kanpur? Learn the key growth drivers, regional trends, residential options, and RERA verification tips.',
                'meta_keywords' => 'Kanpur real estate, invest property, property appreciation, Kanpur metro investment',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Sustainable Building Materials Shaping the Future of Green Homes',
                'slug' => 'sustainable-building-materials-green-homes',
                'category' => 'Construction',
                'content' => "With rising concern over greenhouse gas emissions and environmental impact, sustainable building practices have shifted from a niche alternative to mainstream construction requirements. Specifying eco-friendly building products is critical for sustainable home certifications.

Top Sustainable Building Materials:

1. Bamboo Structural Elements:
Bamboo grows incredibly fast, absorbs high levels of carbon dioxide, and possesses high tensile strength comparable to steel, making it ideal for posts, scaffolding, and flooring.

2. Recycled Metal and Steel:
Manufacturing steel is incredibly energy-intensive. Using pre-recycled steel reduces energy consumption by nearly 75% while offering identical structural integrity.

3. Hempcrete Insulation blocks:
A blend of hemp fibers and lime plaster, Hempcrete is carbon-negative, self-insulating, lightweight, and completely fireproof, keeping interiors insulated.

4. Timbercrete Composite:
Made from sawdust and cement slurry, Timbercrete is lighter than standard concrete, highly insulating, and easily shaped for custom structural requirements.",
                'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=800',
                'meta_title' => 'Eco-Friendly & Sustainable Construction Materials | Bloc-Infra',
                'meta_description' => 'Discover the best green building products shaping sustainable home designs, including bamboo, recycled steel, and carbon-negative hempcrete blocks.',
                'meta_keywords' => 'green homes, sustainable building, eco friendly materials, hempcrete, timbercrete',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Mastering Infrastructure Project Management: Essential Strategies',
                'slug' => 'mastering-infrastructure-project-management-strategies',
                'category' => 'Project Management',
                'content' => "Managing a mega-infrastructure project demands flawless organization, real-time tracking, and strict risk assessment protocol. Unlike residential developments, infrastructure setups involve complex public stakeholder relationships, safety certifications, and tight government deadlines.

Core Principles of Infrastructure Project Management:

1. Dynamic Risk Mitigation Plans:
Identify environmental, geopolitical, and resource supply bottlenecks early. Design structured contingency plans for material price surges.

2. Unified Collaboration Tools:
Use central software platforms that allow contractors, site surveyors, and government inspectors to update tasks, verify field reports, and sign change-orders instantly.

3. Performance and Budget Tracking:
Set rigorous milestones (e.g. earthwork completion, structural framing, utility routing) and monitor cost variances weekly to avoid cost-overrun creep.

4. Environmental Compliance Auditing:
Maintain compliance checks on wastewater discharge, noise levels, and regional environmental rules to prevent regulatory stop-work mandates.",
                'image' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&q=80&w=800',
                'meta_title' => 'Infrastructure Project Management Guide | Bloc-Infra',
                'meta_description' => 'Understand the primary methods for managing large-scale infrastructure projects, preventing budget overruns, and managing public stakeholders.',
                'meta_keywords' => 'infrastructure project management, contract milestones, project overruns, construction safety',
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ]
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(
                ['slug' => $blog['slug']],
                $blog
            );
        }
    }
}
