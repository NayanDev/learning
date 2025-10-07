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
            'divisi' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Penggunaan APD dan APAR',
            'divisi' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Line Clearance',
            'divisi' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Sanitasi & Higienitas',
            'divisi' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Lean manufacturing dan Penerapan OEE',
            'divisi' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Leadership',
            'divisi' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Pelatihan CPOB 2024 & Good Documentation Practice',
            'divisi' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Verifikasi Timbangan',
            'divisi' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Penggunaan Aplikasi Analisa Data',
            'divisi' => 'PRODUKSI',
        ]);

        Workshop::create([
            'name' => 'Warehouse in Pharmaceutical Industry',
            'divisi' => 'SCM',
        ]);

        Workshop::create([
            'name' => 'Leadership',
            'divisi' => 'SCM',
        ]);

        Workshop::create([
            'name' => 'Tanggap Darurat',
            'divisi' => 'SCM',
        ]);

        Workshop::create([
            'name' => 'Manual Handling K3',
            'divisi' => 'SCM',
        ]);

        Workshop::create([
            'name' => 'Penggunaan APD',
            'divisi' => 'TEKNIK',
        ]);

        Workshop::create([
            'name' => '5R',
            'divisi' => 'TEKNIK',
        ]);

        Workshop::create([
            'name' => 'K3 Listrik',
            'divisi' => 'TEKNIK',
        ]);

        Workshop::create([
            'name' => 'Pengelasan Argon',
            'divisi' => 'TEKNIK',
        ]);

        Workshop::create([
            'name' => 'Service AC',
            'divisi' => 'TEKNIK',
        ]);

        Workshop::create([
            'name' => 'Service HVAC',
            'divisi' => 'TEKNIK',
        ]);

        Workshop::create([
            'name' => 'Operasional Boiler K3',
            'divisi' => 'TEKNIK',
        ]);

        Workshop::create([
            'name' => 'Leadership',
            'divisi' => 'TEKNIK',
        ]);

        Workshop::create([
            'name' => 'CPOB Dasar',
            'divisi' => 'TEKNIK',
        ]);

        Workshop::create([
            'name' => 'Good Review Practice',
            'divisi' => 'RND',
        ]);

        Workshop::create([
            'name' => 'UDT dan Uji Bioekivalensi',
            'divisi' => 'RND',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Umum',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Regulasi Pemerintah',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Teknis',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Time Management',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Pelatihan AMT',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Operator Udara PPPU',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Penanggung Jawab Udara PPPU',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Operator OPL B3',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => '3Penanggung Jawab OPL B3',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'SKP dan Lisensi K3',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Ekternal - Tanggap darurat & APAR',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Ekternal - PMI',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'K3 Dasar Karyawan Baru',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Safety Riding',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Simulasi Tanggap Darurat Tumpahan',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Pengelolaan Limbah',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Kebersihan Lingkungan',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Pelatihan 5R',
            'divisi' => 'UMUM & SDM',
        ]);

        Workshop::create([
            'name' => 'Pelatihan gDocP-Laboratorium',
            'divisi' => 'QC',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Line Clearance',
            'divisi' => 'QC',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Good Weighing practice',
            'divisi' => 'QC',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Problem Resolve HPLC',
            'divisi' => 'QC',
        ]);

        Workshop::create([
            'name' => 'Pelatihan Problem Resolver AAS',
            'divisi' => 'QC',
        ]);

        Workshop::create([
            'name' => 'Pelatihan sampling produk padat, cair dan semi solid',
            'divisi' => 'QC',
        ]);

        Workshop::create([
            'name' => 'Pelatihan pengisian dokumen yang baik dan benar',
            'divisi' => 'QC',
        ]);

        Workshop::create([
            'name' => 'Jobdesk',
            'divisi' => 'QA',
        ]);

        Workshop::create([
            'name' => 'Refresh CPOB Dasar',
            'divisi' => 'QA',
        ]);

        Workshop::create([
            'name' => 'Minitab',
            'divisi' => 'QA',
        ]);

        Workshop::create([
            'name' => '2D Barcode',
            'divisi' => 'QA',
        ]);

        Workshop::create([
            'name' => 'Refresh Sistem Halal',
            'divisi' => 'QA',
        ]);
    }
}
