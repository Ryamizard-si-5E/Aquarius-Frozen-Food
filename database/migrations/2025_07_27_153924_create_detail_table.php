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
       Schema::create('detail', function (Blueprint $table) {
    $table->string('id_transaksi', 30);
    $table->unsignedBigInteger('id_barang');
    $table->integer('jumlah_barang');

    $table->primary(['id_transaksi', 'id_barang']);

    $table->foreign('id_transaksi')
          ->references('id_transaksi')
          ->on('transaksi')
          ->onDelete('cascade');

    $table->foreign('id_barang')
          ->references('id_barang')
          ->on('barang')
          ->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
