<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObatMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id',
        'tanggal_terima',
        'total_harga',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function detailObatMasuks()
    {
        return $this->hasMany(DetailObatMasuk::class);
    }
}
