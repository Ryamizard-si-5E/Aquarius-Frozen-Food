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
        Schema::create('keranjang', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_pelanggan');
    $table->unsignedBigInteger('id_barang');
    $table->integer('quantity')->default(1);
    $table->decimal('total_harga', 10, 2);
    $table->timestamps();

    $table->foreign('id_pelanggan')
          ->references('id_pelanggan')
          ->on('pelanggan')
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
