<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RatingSeafood extends Model
{
    use HasFactory;
    protected $table = 'rating_seafoods';
    protected $fillable = [
        'seafood_id',
        'rating',
        'review',
    ];

    public function seafood()
    {
        return $this->belongsTo(Seafood::class, 'seafood_id', 'kode_seafood');
    }
}
