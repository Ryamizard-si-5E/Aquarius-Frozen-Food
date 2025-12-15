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
        Schema::create('pelanggan', function (Blueprint $table) {
    $table->id('id_pelanggan'); // BIGINT unsigned auto-increment
    $table->string('username', 30);
    $table->string('nama_pelanggan', 30);
    $table->string('password', 255);
    $table->string('alamat', 255);
    $table->string('no_hp', 15);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
