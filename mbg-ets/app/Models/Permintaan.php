<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;
    protected $table = 'permintaan';
    protected $fillable = ['pemohon_id', 'tgl_masak', 'menu_makan', 'jumlah_porsi', 'status'];

    // Relasi: Satu permintaan dimiliki oleh satu user (pemohon)
    public function pemohon()
    {
        return $this->belongsTo(User::class, 'pemohon_id');
    }

    // Relasi: Satu permintaan memiliki banyak detail bahan
    public function details()
    {
        return $this->hasMany(PermintaanDetail::class);
    }
}