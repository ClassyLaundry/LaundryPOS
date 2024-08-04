<?php

namespace Database\Factories\Data;

use App\Models\Data\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class JenisItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'kategori_id' => Kategori::all()->random()->id,
            'nama' => fake()->word(),
            'unit' => fake()->randomElement(['PCS', 'MTR']),
            'bobot_bucket' => fake()->randomFloat(1, 0.5, 5),
            'harga_kilo' => fake()->randomNumber(5, true),
            'harga_bucket' => fake()->randomNumber(5, true),
            'harga_premium' => fake()->randomNumber(5, true),
            'status_bucket' => fake()->boolean(),
            'status_kilo' => fake()->boolean(),
            'status_premium' => fake()->boolean(),
            'beban_produksi' => fake()->randomFloat(1, 0, 5, 20),
        ];
    }
}
