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
            'department' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Penggunaan APD dan APAR',
            'department' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Line Clearance',
            'department' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Sanitasi & Higienitas',
            'department' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Lean manufacturing dan Penerapan OEE',
            'department' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Leadership',
            'department' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan CPOB 2024 & Good Documentation Practice',
            'department' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Verifikasi Timbangan',
            'department' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Penggunaan Aplikasi Analisa Data',
            'department' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Organisasi Perusahaan',
            'department' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Peraturan Perusahaan',
            'department' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'CPOB Dasar',
            'department' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Regulasi Pemerintah',
            'department' => 'UMUM & SDM',
        ]);
    }
}
