<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(4);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text,
            'price' => $this->faker->randomNumber(4, true),
            'company_id' => Company::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
