<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $name = $this->faker->sentence(2);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->numberBetween(1, 10),
            'parent_id' => null,
            'cpu_id' => null,
        ];
    }
}
