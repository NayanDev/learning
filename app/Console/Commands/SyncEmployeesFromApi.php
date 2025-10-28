<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class SyncEmployeesFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:sync-employees-from-api';
    protected $signature = 'sync:employees-from-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data karyawan dari API eksternal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Mulai sinkronisasi...");

        $response = Http::timeout(20)->get('https://simco.sampharindogroup.com/api/pegawai'); // GANTI dengan URL API-mu

        if (!$response->successful()) {
            $this->error('Gagal mengambil data dari API');
            return 1;
        }

        $employees = $response->json();

        if (!is_array($employees)) {
            $this->error('Format data dari API tidak valid');
            return 1;
        }

        $now = Carbon::now();

        foreach ($employees as $data) {
            if (!isset($data['nik'])) {
                $this->warn("Data tanpa NIK dilewati.");
                continue;
            }

            Employee::updateOrCreate(
                ['nik' => $data['nik']],
                [
                    'company'     => $data['company'] ?? null,
                    'nama'        => $data['nama'] ?? null,
                    'divisi'      => $data['divisi'] ?? null,
                    'unit_kerja'  => $data['unit_kerja'] ?? null,
                    'status'      => $data['status'] ?? null,
                    'jk'          => $data['jk'] ?? null,
                    'email'       => $data['email'] ?? null,
                    'telp'        => $data['telp'] ?? null,
                    'last_synced' => $now,
                ]
            );
        }

        $this->info("Sinkronisasi selesai: " . count($employees) . " data diproses.");
        return 0;
    }
}
