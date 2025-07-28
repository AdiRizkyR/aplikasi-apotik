<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPemesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id',
        'data_obat_id',
        'jumlah_beli',
        'harga_beli',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function dataObat()
    {
        return $this->belongsTo(DataObat::class);
    }
}