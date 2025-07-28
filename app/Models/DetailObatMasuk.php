<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailObatMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'obat_masuk_id',
        'data_obat_id',
        'jumlah_beli',
        'harga_beli',
        'harga_jual',
        'expired',
    ];

    public function obatMasuk()
    {
        return $this->belongsTo(ObatMasuk::class);
    }

    public function dataObat()
    {
        return $this->belongsTo(DataObat::class);
    }
}
