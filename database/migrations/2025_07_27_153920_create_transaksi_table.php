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
      Schema::create('transaksi', function (Blueprint $table) {
    $table->string('id_transaksi', 30)->primary();
    $table->unsignedBigInteger('id_pelanggan');
    $table->decimal('total_harga', 10, 2)->nullable();
    $table->string('metode', 10);
    $table->date('tanggal');
    $table->string('bukti_pembayaran', 255)->nullable();
    $table->timestamps();

    $table->foreign('id_pelanggan')
          ->references('id_pelanggan')
          ->on('pelanggan')
          ->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
