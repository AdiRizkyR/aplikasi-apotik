<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'nohp'];

    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class);
    }
}
