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

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'systemadmin@safedecision.com',
            'is_admin' => true,
        ]);

        // User::factory()->create([
        //     'name' => 'User',
        //     'email' => 'user@safedecision.com'
        // ]);

        // $rootCategories = collect(['Laptops', 'Mobile Phones', 'Headphones'])->transform(function ($name) {
        //     return Category::factory()->create([
        //         'name' => $name,
        //         'slug' => Str::slug($name),
        //     ]);
        // });

        // $cpus = collect(['Intel', 'AMD', 'snapdragon', 'exynos'])->transform(function ($name) {
        //     return Cpu::factory()->create([
        //         'name' => ucfirst($name),
        //     ]);
        // });

        // $rootCategories->each(function ($rootCat) use ($cpus) {
        //     $rootCat->children()->createMany(
        //         Category::factory()->times(3)->make([
        //             'parent_id' => $rootCat->id,
        //             'cpu_id' => $rootCat->id % 2 ? $cpus->random()->id : null,
        //         ])->toArray()
        //     );
        // });

        // $companies = collect(['Apple', 'Samsung', 'ASUS', 'DELL'])
        // ->map(fn ($name) => Company::factory()->create(['name' => $name]));

        // $allCats = Category::whereNotNull('parent_id')->get();

        // $allCats->each(function ($subCat) use ($admin, $companies) {
        //     $subCat->products()->saveMany(Product::factory(5)->make([
        //         'company_id' => $companies->random()->id,
        //         'created_by' => $admin->id,
        //     ]));
        // });
    }
}
