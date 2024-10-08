<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggans = array(
            array(
                "uid" => "NuMWOs10rJbc0w",
                "nama" => "ANDI",
                "domisili" => "JAK-UT",
                "jenis_kelamin" => "pria",
                "created_at" => "2024-10-08 08:58:54",
                "updated_at" => "2024-10-08 08:58:54",
            ),
            array(
                "uid" => "rkCSwFL-OK1AGg",
                "nama" => "BUDI",
                "domisili" => "JAK-BAR",
                "jenis_kelamin" => "pria",
                "created_at" => "2024-10-08 08:59:31",
                "updated_at" => "2024-10-08 08:59:31",
            ),
            array(
                "uid" => "ERts0SVFLMMj7g",
                "nama" => "JOHAN",
                "domisili" => "JAK-SEL",
                "jenis_kelamin" => "pria",
                "created_at" => "2024-10-08 08:59:46",
                "updated_at" => "2024-10-08 08:59:46",
            ),
            array(
                "uid" => "apEIfpfnKZt_RQ",
                "nama" => "SINTHA",
                "domisili" => "JAK-TIM",
                "jenis_kelamin" => "wanita",
                "created_at" => "2024-10-08 09:00:09",
                "updated_at" => "2024-10-08 09:00:09",
            ),
            array(
                "uid" => "6HcKEdnX4FDPJA",
                "nama" => "ANTO",
                "domisili" => "JAK-UT",
                "jenis_kelamin" => "pria",
                "created_at" => "2024-10-08 09:00:44",
                "updated_at" => "2024-10-08 09:00:44",
            ),
            array(
                "uid" => "sMd6fib4cABBLg",
                "nama" => "BUJANG",
                "domisili" => "JAK-BAR",
                "jenis_kelamin" => "pria",
                "created_at" => "2024-10-08 09:01:03",
                "updated_at" => "2024-10-08 09:01:03",
            ),
            array(
                "uid" => "aNDXq-9WAjkpxQ",
                "nama" => "JOWAN",
                "domisili" => "JAK-SEL",
                "jenis_kelamin" => "pria",
                "created_at" => "2024-10-08 09:01:16",
                "updated_at" => "2024-10-08 09:01:16",
            ),
            array(
                "uid" => "k5F8TIOw97QY0g",
                "nama" => "SINTIA",
                "domisili" => "JAK-TIM",
                "jenis_kelamin" => "wanita",
                "created_at" => "2024-10-08 09:01:33",
                "updated_at" => "2024-10-08 09:01:33",
            ),
            array(
                "uid" => "Z_tTDAkAhQHdfA",
                "nama" => "BUTET",
                "domisili" => "JAK-BAR",
                "jenis_kelamin" => "wanita",
                "created_at" => "2024-10-08 09:01:52",
                "updated_at" => "2024-10-08 09:01:52",
            ),
        );

        Pelanggan::insert($pelanggans);
    }
}
