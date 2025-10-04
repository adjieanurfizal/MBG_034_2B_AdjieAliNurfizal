<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class BahanBaku extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari aturan jamak Laravel
    protected $table = 'bahan_baku';

    // Izinkan kolom-kolom ini untuk diisi secara massal (mass assignment)
    protected $fillable = [
        'nama',
        'kategori',
        'jumlah',
        'satuan',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'status',
    ];

    /**
     * Accessor untuk menghitung status secara otomatis.
     * Laravel akan otomatis memanggil fungsi ini saat kita mengakses $bahan->status
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Konversi tanggal string dari DB menjadi objek Carbon (untuk manipulasi tanggal)
                $expDate = Carbon::parse($this->tanggal_kadaluarsa);
                $today = Carbon::now();

                // Logika penentuan status berdasarkan requirement
                if ($this->jumlah <= 0) {
                    return 'habis';
                }
                if ($today->isAfter($expDate)) {
                    return 'kadaluarsa';
                }
                // diffInDays(..., false) -> bisa menghasilkan nilai negatif jika tanggal di masa lalu
                if ($today->diffInDays($expDate, false) <= 3) {
                    return 'segera_kadaluarsa';
                }
                
                return 'tersedia';
            }
        );
    }
}


