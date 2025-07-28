<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'supplier_id',
        'tanggal_pesan',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class);
    }

    public function obatMasuks()
    {
        return $this->hasOne(ObatMasuk::class);
    }
}
