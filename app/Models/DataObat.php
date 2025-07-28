<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataObat extends Model
{
    use HasFactory;

    protected $table = 'data_obats';

    protected $fillable = [
        'nama',
        'jenis',
        'kategori',
    ];

    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class);
    }

    public function detailObatMasuks()
    {
        return $this->hasMany(DetailObatMasuk::class);
    }

    public function obats()
    {
        return $this->hasMany(Obat::class);
    }
}