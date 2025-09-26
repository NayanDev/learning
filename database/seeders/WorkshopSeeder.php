<?php

namespace Database\Seeders;

use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Workshop::create([
            'name' => 'Pelatihan K3',
            'department_id' => '1',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Penggunaan APD dan APAR',
            'department_id' => '1',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Line Clearance',
            'department_id' => '1',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Sanitasi & Higienitas',
            'department_id' => '1',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Lean manufacturing dan Penerapan OEE',
            'department_id' => '1',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Leadership',
            'department_id' => '1',
        ]);

        Workshop::create([
            'name' => 'Pelatihan CPOB 2024 & Good Documentation Practice',
            'department_id' => '1',
        ]);

        Workshop::create([
            'name' => 'Verifikasi Timbangan',
            'department_id' => '1',
        ]);

        Workshop::create([
            'name' => 'Penggunaan Aplikasi Analisa Data',
            'department_id' => '1',
        ]);

        Workshop::create([
            'name' => 'Organisasi Perusahaan',
            'department_id' => '5',
        ]);

        Workshop::create([
            'name' => 'Peraturan Perusahaan',
            'department_id' => '5',
        ]);

        Workshop::create([
            'name' => 'CPOB Dasar',
            'department_id' => '5',
        ]);

        Workshop::create([
            'name' => 'Regulasi Pemerintah',
            'department_id' => '5',
        ]);
    }
}
