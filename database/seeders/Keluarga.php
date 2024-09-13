<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keluarga as KeluargaModel;

class Keluarga extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keluargaData = [
            ['nama' => 'Ayah', 'deskripsi' => 'Ayah'],
            ['nama' => 'Ibu', 'deskripsi' => 'Ibu'],
            ['nama' => 'Anak 1', 'deskripsi' => 'Anak Pertama'],
            ['nama' => 'Anak 2', 'deskripsi' => 'Anak Kedua'],
            ['nama' => 'Anak 3', 'deskripsi' => 'Anak Ketiga'],
            ['nama' => 'Anak 4', 'deskripsi' => 'Anak Keempat'],
        ];

        foreach ($keluargaData as $data) {
            KeluargaModel::create($data);
        }
    }
}
