<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_obat_id',
        'obat_masuk_id',
        'stok',
        'harga',
        'expired',
    ];

    public function dataObat()
    {
        return $this->belongsTo(DataObat::class);
    }

    public function obatMasuk()
    {
        return $this->belongsTo(ObatMasuk::class);
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}