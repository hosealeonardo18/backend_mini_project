<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'kode_pelanggan', 'uid')->select('uid', 'nama');
    }

    public function itemPenjualan()
    {
        return $this->hasMany(ItemPenjualan::class, 'id_nota', 'id_nota')->with('barang')->select('id_nota', 'kode_barang', 'qty');
    }
}
