<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = false; // Karena id_transaksi bukan auto increment
    protected $keyType = 'string';

    protected $fillable = [
        'id_transaksi',
        'id_pelanggan',
        'total_harga',
        'total_barang',
        'metode',
        'tanggal',
        'alamatt',
        'bukti_pembayaran',
        'status_pengiriman',
        'status',
        'metode_pengiriman',
        'jarak',
        'ongkir'
    ];

    // Relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // Relasi ke detail transaksi
    public function details()
    {
        return $this->hasMany(Detail::class, 'id_transaksi', 'id_transaksi');
    }
}
