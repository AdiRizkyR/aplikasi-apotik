<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'nohp'];

    public function penjualans(): HasMany
    {
        return $this->hasMany(Penjualan::class);
    }
}
