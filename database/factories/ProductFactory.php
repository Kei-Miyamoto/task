<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
//use Database\Factories;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
      
      return [
        'company_id' => $this->faker->numberBetween($min=1, $max=5),
        'product_name' => $this->faker->word(),
        'price' => $this->faker->numberBetween($min=80, $max=300),
        'image' => $this->faker->word(),
        'stock' => $this->faker->numberBetween($min=0, $max=10),
        'comment' => $this->faker->text(),
    ];
    }
}
