<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['aktif', 'nonaktif'];
        $tipeModems = ['FiberHome', 'Huawei', 'ZTE', 'Alcatel', 'Nokia', 'TP-Link', 'Cisco'];
        $lokasiKota = ['Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Makassar', 'Semarang', 'Palembang', 'Denpasar', 'Yogyakarta', 'Malang', 'Depok'];

        $data = [];
        for ($i = 1; $i <= 1000; $i++) {
            $data[] = [
                'nama_perangkat' => 'Modem ' . Str::upper(Str::random(3)) . '-' . random_int(100, 999),
                'lokasi_pemasangan' => $lokasiKota[array_rand($lokasiKota)] . ', Jalan ' . Str::random(10),
                'tipe_modem' => $tipeModems[array_rand($tipeModems)],
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('modems')->insert($data);
    }
}
