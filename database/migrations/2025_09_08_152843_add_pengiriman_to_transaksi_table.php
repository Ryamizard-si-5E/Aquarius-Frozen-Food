<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->integer('total_barang')->after('id_pelanggan'); // harga barang saja
            $table->integer('ongkir')->default(0)->after('total_barang');
            $table->string('metode_pengiriman')->nullable()->after('metode'); 
            $table->enum('status_pengiriman', ['dikirim', 'selesai'])
                ->nullable()
                ->after('status'); // status pengiriman baru
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['total_barang', 'ongkir', 'metode_pengiriman', 'status_pengiriman']);
        });
    }
};
