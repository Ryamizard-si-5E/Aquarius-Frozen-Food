<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            if (!Schema::hasColumn('transaksi', 'status_pengiriman')) {
                $table->enum('status_pengiriman', ['diproses', 'dikirim', 'selesai'])
                      ->default('diproses')
                      ->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            if (Schema::hasColumn('transaksi', 'status_pengiriman')) {
                $table->dropColumn('status_pengiriman');
            }
        });
    }
};
