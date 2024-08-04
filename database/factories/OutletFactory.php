<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outlet>
 */
class OutletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'kode' => fake()->unique()->ean8(),
            'nama' => fake()->city(),
            'alamat' => fake()->address(),
            'telp_1' => fake()->phoneNumber(),
        ];
    }
}
