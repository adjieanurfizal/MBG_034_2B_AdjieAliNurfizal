<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanDetail extends Model
{
    use HasFactory;
    protected $table = 'permintaan_detail';
    protected $fillable = ['permintaan_id', 'bahan_id', 'jumlah_diminta'];

    // Relasi: Satu detail permintaan merujuk ke satu bahan baku
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_id');
    }
}