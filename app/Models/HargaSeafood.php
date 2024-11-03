<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HargaSeafood extends Model
{
    use HasFactory;

    protected $table = 'harga_seafoods';
    protected $primaryKey = 'kode_harga';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_harga',
        'harga',
        'seafood_id',
    ];

    public function seafood()
    {
        return $this->belongsTo(Seafood::class, 'seafood_id', 'kode_seafood');
    }
}
