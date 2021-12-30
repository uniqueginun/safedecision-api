<?php

namespace Database\Seeders;

use App\Models\Cpu;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admins = User::factory(2)->create([
            'is_admin' => true,
        ]);

        User::factory(4)->create();

        $rootCategories = collect(['Laptops', 'Mobile Phones', 'Headphones'])->map(function ($name) {
            return Category::factory()->create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        });

        $categories = $rootCategories->map(function ($category) {
            return Category::factory()->count(2)->create([
                'parent_id' => $category->id,
            ]);
        });


        $cpus = collect(['Intel', 'AMD', 'snapdragon', 'exynos'])->map(function ($name) {
            return Cpu::factory()->create([
                'name' => ucfirst($name),
            ]);
        });

        $subCategories = $categories->map(function ($cats) use ($cpus) {
            return $cats->map(function ($cat) use ($cpus) {
                return Category::factory(5)->create([
                    'parent_id' => $cat->id,
                    'cpu_id' => $cpus->random()->id,
                ]);
            });
        });

        collect(['Apple', 'Samsung', 'ASUS', 'DELL'])
        ->map(fn ($name) => Company::factory()->create(['name' => $name]))
        ->each(function ($company) use ($subCategories, $admins) {
           $subCategories->each(function ($catItem) use ($company, $admins) {
               $catItem->each(function ($cat) use ($company, $admins) {
                   $cat->each(function ($subCat) use ($company, $admins) {
                       $subCat->products()->saveMany(Product::factory(5)->make([
                           'company_id' => $company->id,
                           'created_by' => $admins->random()->id,
                       ]));
                   });
               });
           });
        });
    }
}
