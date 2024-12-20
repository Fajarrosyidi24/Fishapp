<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchant extends Model
{
    use HasFactory;

    protected $table = 'merchants';

    protected $fillable = [
        'pembayaran_id',
        'merchantCode',
        'reference',
        'paymentUrl',
        'amount',
        'statusCode',
        'statusMessage',
    ];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id', 'id');
    }

    public static function store($invoice, $idpembayaran)
    {
        return self::create([
            'pembayaran_id' => $idpembayaran,
            'merchantCode' => $invoice['merchantCode'],
            'reference' => $invoice['reference'],
            'paymentUrl' => $invoice['paymentUrl'],
            'amount' => $invoice['amount'],
            'statusCode' => $invoice['statusCode'],
            'statusMessage' => $invoice['statusMessage'],
        ]);
    }
}
