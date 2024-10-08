<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{

    public function run(): void
    {
        $barangs = array(
            array(
                "kode" => "atk-002",
                "nama" => "PENSIL UPDATE",
                "kategori" => "ATK",
                "harga" => 11000,
                "created_at" => "2024-10-08 10:47:19",
                "updated_at" => "2024-10-08 15:45:08",
            ),
            array(
                "kode" => "rt-001",
                "nama" => "PAYUNG",
                "kategori" => "RT",
                "harga" => 70000,
                "created_at" => "2024-10-08 10:48:38",
                "updated_at" => "2024-10-08 10:48:38",
            ),
            array(
                "kode" => "masak-001",
                "nama" => "PANCI",
                "kategori" => "MASAK",
                "harga" => 110000,
                "created_at" => "2024-10-08 10:51:11",
                "updated_at" => "2024-10-08 10:51:11",
            ),
            array(
                "kode" => "rt-002",
                "nama" => "SAPU",
                "kategori" => "RT",
                "harga" => 40000,
                "created_at" => "2024-10-08 10:51:38",
                "updated_at" => "2024-10-08 10:51:38",
            ),
            array(
                "kode" => "elektronik-001",
                "nama" => "KIPAS",
                "kategori" => "ELEKTRONIK",
                "harga" => 200000,
                "created_at" => "2024-10-08 10:51:55",
                "updated_at" => "2024-10-08 10:51:55",
            ),
            array(
                "kode" => "masak-002",
                "nama" => "KUALI",
                "kategori" => "MASAK",
                "harga" => 120000,
                "created_at" => "2024-10-08 10:52:14",
                "updated_at" => "2024-10-08 10:52:14",
            ),
            array(
                "kode" => "rt-003",
                "nama" => "GELAS",
                "kategori" => "RT",
                "harga" => 25000,
                "created_at" => "2024-10-08 10:59:54",
                "updated_at" => "2024-10-08 10:59:54",
            ),
            array(
                "kode" => "rt-004",
                "nama" => "PIRING",
                "kategori" => "RT",
                "harga" => 35000,
                "created_at" => "2024-10-08 11:10:58",
                "updated_at" => "2024-10-08 11:10:58",
            ),
        );

        Barang::insert($barangs);
    }
}
