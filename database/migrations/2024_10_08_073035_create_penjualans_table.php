<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('id_nota')->unique();
            $table->string('kode_pelanggan');
            $table->double('subtotal');
            $table->timestamps();

            $table->foreign(['kode_pelanggan'])->references(['uid'])->on('pelanggans');
        });

        Schema::create('item_penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('id_nota');
            $table->string('kode_barang');
            $table->integer('qty');
            $table->timestamps();

            $table->foreign(['id_nota'])->references(['id_nota'])->on('penjualans');
            $table->foreign(['kode_barang'])->references(['kode'])->on('barangs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
