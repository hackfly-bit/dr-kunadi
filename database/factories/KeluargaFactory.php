<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keluarga>
 */
class KeluargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $keluargaData = [
            ['nama' => 'Ayah', 'deskripsi' => 'Ayah'],
            ['nama' => 'Ibu', 'deskripsi' => 'Ibu'],
            ['nama' => 'Anak 1', 'deskripsi' => 'Anak Pertama'],
            ['nama' => 'Anak 2', 'deskripsi' => 'Anak Kedua'],
            ['nama' => 'Anak 3', 'deskripsi' => 'Anak Ketiga'],
            ['nama' => 'Anak 4', 'deskripsi' => 'Anak Keempat'],
        ];

        return $this->faker->randomElement($keluargaData);
    }
}
