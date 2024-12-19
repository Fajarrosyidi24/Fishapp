<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusPembayaran extends Model
{
    use HasFactory;
    protected $table = 'status_pembayarans';

    protected $fillable = [
        'pembayaran_id',
        'status_pembayaran',
    ];

    public function pembayaran()
{
    return $this->belongsTo(Pembayaran::class, 'pembayaran_id', 'id');
}

    public static function store($idpembayaran)
    {
        return self::create([
            'pembayaran_id' => $idpembayaran,
            'status_pembayaran' => 'menunggu pembayaran',
        ]);
    }

    public static function updateStatus($idStatus)
    {
        $data = self::find($idStatus); 
        if ($data) {
            $data->status_pembayaran = 'PAID';
            $data->save();
    
            return $data;
        } else {
            return null;
        }
    }
}
