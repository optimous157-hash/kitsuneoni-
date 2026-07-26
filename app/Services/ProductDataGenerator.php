<?php

namespace App\Services;

use App\Models\Category;

class ProductDataGenerator
{
    protected array $categoryKeywords = [
        'katana' => 'Katanas',
        'tanto' => 'Tanto',
        'wakizashi' => 'Wakizashi',
        'stand' => 'Display Stands',
        'display' => 'Display Stands',
        'accessory' => 'Accessories',
        'resin' => 'Accessories',
        'keychain' => 'Accessories',
    ];

    protected array $regionPricing = [
        'cis' => 1.0,
        'eu_am' => 1.2,
        'af_au' => 1.1,
    ];

    public function generateFromName(string $name): array
    {
        $name = trim($name);
        $slug = str($name)->slug()->toString();

        return [
            'name' => $this->generateTitle($name),
            'slug' => $slug,
            'short_description' => $this->generateShortDescription($name),
            'description' => $this->generateDescription($name),
            'meta_title' => $this->generateMetaTitle($name),
            'meta_description' => $this->generateMetaDescription($name),
            'category_id' => $this->detectCategoryId($name),
            'tags' => $this->detectTags($name),
        ];
    }

    public function generateTitle(string $name): string
    {
        return collect(explode('-', $name))
            ->map(fn($w) => ucwords(trim($w)))
            ->implode(' ');
    }

    public function generateShortDescription(string $name): string
    {
        $type = $this->detectType($name);
        $material = $this->randomMaterial();

        return "A premium handcrafted {$type} featuring {$material} construction. Forged by skilled artisans and finished with meticulous attention to detail. Each piece is unique and ready to become the centerpiece of any collection.";
    }

    public function generateDescription(string $name): string
    {
        $type = $this->detectType($name);
        $material = $this->randomMaterial();
        $steel = $this->randomSteel();
        $handle = $this->randomHandle();
        $hardness = rand(56, 62);
        $overall = rand(70, 105);
        $blade = rand(50, 75);

        return <<<HTML
<p>Introducing the <strong>{$name}</strong> — a masterfully crafted {$type} that embodies the perfect fusion of traditional Japanese artistry and modern precision engineering.</p>

<p>Each {$type} in our collection is hand-forged from premium {$steel}, carefully selected for its exceptional grain structure and edge-holding capabilities. The blade undergoes a rigorous heat treatment process, achieving a hardness of {$hardness} HRC for the ideal balance of sharpness and durability.</p>

<p>The handle is wrapped in genuine {$handle}, providing a secure and comfortable grip that feels natural in the hand. Every detail, from the precise geometry of the blade to the elegant wrapping of the handle, reflects the dedication of our master craftsmen.</p>

<p>Whether displayed as a collector's piece or used for serious practice, the {$name} delivers uncompromising performance and timeless beauty.</p>

<h3>Key Features</h3>
<ul>
<li>Hand-forged {$steel} blade ({$blade}cm / {$overall}cm overall)</li>
<li>{$hardness} HRC hardness rating for exceptional edge retention</li>
<li>Premium {$handle} handle with traditional wrapping</li>
<li>Includes premium protective gift case</li>
<li>Perfect for collectors and practitioners alike</li>
</ul>
HTML;
    }

    public function generateMetaTitle(string $name): string
    {
        $type = $this->detectType($name);
        return "{$name} — Premium Handcrafted {$type} | Kitsuneoni";
    }

    public function generateMetaDescription(string $name): string
    {
        $type = $this->detectType($name);
        $material = $this->randomMaterial();
        return "Discover the {$name}, a premium handcrafted {$type} forged from {$material}. ✓ Worldwide shipping ✓ 100% handmade ✓ Collector quality. Order yours today.";
    }

    protected function detectType(string $name): string
    {
        $lower = strtolower($name);

        if (str_contains($lower, 'katana') || str_contains($lower, 'sword') || str_contains($lower, 'blade')) {
            return 'katana';
        }
        if (str_contains($lower, 'tanto') || str_contains($lower, 'knife')) {
            return 'tantō';
        }
        if (str_contains($lower, 'wakizashi')) {
            return 'wakizashi';
        }
        if (str_contains($lower, 'stand')) {
            return 'display stand';
        }

        return 'collectible blade';
    }

    protected function detectCategoryId(string $name): ?int
    {
        $lower = strtolower($name);

        foreach ($this->categoryKeywords as $keyword => $categoryName) {
            if (str_contains($lower, $keyword)) {
                $category = Category::where('name', $categoryName)->first();
                if ($category) {
                    return $category->id;
                }
            }
        }

        $defaultCategory = Category::orderBy('id')->first();
        return $defaultCategory?->id;
    }

    protected function detectTags(string $name): string
    {
        $lower = strtolower($name);
        $tags = ['handcrafted', 'japanese', 'collector'];

        $type = $this->detectType($name);
        if ($type !== 'collectible blade') {
            $tags[] = $type;
        }

        foreach (['dragon', 'samurai', 'ninja', 'demon', 'spirit', 'warrior', 'storm', 'steel', 'moon', 'shadow', 'iron', 'gold', 'silver', 'black', 'red', 'blue', 'green', 'white', 'onyx', 'jade'] as $kw) {
            if (str_contains($lower, $kw)) {
                $tags[] = $kw;
            }
        }

        return implode(', ', array_unique($tags));
    }

    protected function randomMaterial(): string
    {
        $materials = [
            'premium high-carbon steel',
            'folded Damascus steel',
            'T-10 high-carbon steel',
            '1060 high-carbon steel',
            '1095 high-carbon steel',
        ];
        return $materials[array_rand($materials)];
    }

    protected function randomSteel(): string
    {
        $steels = [
            'T-10 tool steel',
            '1060 high-carbon steel',
            '1095 high-carbon steel',
            'folded Damascus steel',
            '5160 spring steel',
        ];
        return $steels[array_rand($steels)];
    }

    protected function randomHandle(): string
    {
        $handles = [
            'premium ray skin (samegawa)',
            'braided cotton (ito)',
            'genuine leather',
            'Japanese oak wood',
            'ebony wood',
            'cord wrap (tsuka-ito)',
        ];
        return $handles[array_rand($handles)];
    }

    public function inferSpecsFromSimilar(string $name): array
    {
        $type = $this->detectType($name);

        $specs = match ($type) {
            'katana' => [
                'steel_type' => $this->randomSteel(),
                'construction' => 'Full tang, hand-forged',
                'hardness_hrc' => rand(56, 62) . '.0',
                'overall_length' => (string) rand(95, 105),
                'blade_length' => (string) rand(65, 75),
                'blade_width' => '3.2',
                'blade_thickness' => '0.7',
                'handle_material' => $this->randomHandle(),
                'weight' => (string) rand(1100, 1400),
            ],
            'tantō' => [
                'steel_type' => $this->randomSteel(),
                'construction' => 'Full tang, hand-forged',
                'hardness_hrc' => rand(58, 62) . '.0',
                'overall_length' => (string) rand(25, 40),
                'blade_length' => (string) rand(15, 28),
                'blade_width' => '2.8',
                'blade_thickness' => '0.5',
                'handle_material' => $this->randomHandle(),
                'weight' => (string) rand(300, 600),
            ],
            'wakizashi' => [
                'steel_type' => $this->randomSteel(),
                'construction' => 'Full tang, hand-forged',
                'hardness_hrc' => rand(56, 60) . '.0',
                'overall_length' => (string) rand(50, 70),
                'blade_length' => (string) rand(35, 50),
                'blade_width' => '3.0',
                'blade_thickness' => '0.6',
                'handle_material' => $this->randomHandle(),
                'weight' => (string) rand(700, 950),
            ],
            default => [
                'steel_type' => $this->randomSteel(),
                'construction' => 'Hand-forged',
                'hardness_hrc' => rand(54, 60) . '.0',
                'handle_material' => $this->randomHandle(),
            ],
        };

        return $specs;
    }
}
