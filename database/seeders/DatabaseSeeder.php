<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keluarga as KeluargaModel;
use App\Models\NutritionLogSetting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

           $user =  User::factory()->create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);

            $user->roles()->updateOrCreate([
                'role' => 'admin'
            ]); 

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

        $nutrisiSettingLog   = [
            ['activity' => 'Makan Kacang', 'description' => 'Makan Kacang-Kancangan', 'active' => true],
            ['activity' => 'Makan Buah', 'description' => 'Makan Buah-Buahan', 'active' => true],
            ['activity' => 'Makan Sayur', 'description' => 'Makan Sayur-Sayuran', 'active' => true],
            ['activity' => 'Makan Daging', 'description' => 'Makan Daging-Dagingan', 'active' => true],
            ['activity' => 'Makan Ikan', 'description' => 'Makan Ikan', 'active' => true],
            ['activity' => 'Makan Telur', 'description' => 'Makan Telur', 'active' => true],
            ['activity' => 'Makan Susu', 'description' => 'Makan Susu', 'active' => true],
            ['activity' => 'Makan Minyak', 'description' => 'Makan Minyak', 'active' => true],
            ['activity' => 'Makan Gula', 'description' => 'Makan Gula', 'active' => true],
            ['activity' => 'Makan Garam', 'description' => 'Makan Garam', 'active' => true],
            ['activity' => 'Makan Karbohidrat', 'description' => 'Makan Karbohidrat', 'active' => true],
            ['activity' => 'Makan Protein', 'description' => 'Makan Protein', 'active' => true],
            ['activity' => 'Makan Lemak', 'description' => 'Makan Lemak', 'active' => true],
            ['activity' => 'Makan Serat', 'description' => 'Makan Serat', 'active' => true],
            ['activity' => 'Makan Vitamin', 'description' => 'Makan Vitamin', 'active' => true],
            ['activity' => 'Makan Mineral', 'description' => 'Makan Mineral', 'active' => true],
            ['activity' => 'Makan Air', 'description' => 'Makan Air', 'active' => true],
            ['activity' => 'Makan Kalori', 'description' => 'Makan Kalori', 'active' => true],
        ];

        foreach ($nutrisiSettingLog as $data) {
            NutritionLogSetting::create($data);
        }
    }
}
