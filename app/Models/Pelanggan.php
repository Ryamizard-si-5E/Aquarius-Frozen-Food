<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pelanggan extends Authenticatable
{
    public $timestamps = false; // karena tabel tidak punya created_at & updated_at
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'nama_pelanggan',
        'password',
        'alamat',
        'email',
        'no_hp',
        'status',
    ];
    public function notifikasi() {
    return $this->hasMany(Notifikasi::class, 'id_pelanggan');
}

}

