<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Menu;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Menu::class;
    public function definition(): array
    {
        return [
            'nama' => $this->faker()->randomElement(['nasgor', 'mie goreng', 'teh panas', 'kopi', 'sate']),
            'deksripsi' => $this->faker()->text(),
            'harga' => $this->faker->numberBetween(5000, 30000)

        ];
    }
}
