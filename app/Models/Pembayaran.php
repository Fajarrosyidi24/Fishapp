<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';
    protected $fillable = [
        'merchant_order_id',
        'payment_amount',
        'customer_va_name',
        'email',
        'phone_number',
        'item_details',
        'customer_detail',
        'callback_url',
        'return_url',
        'expiry_period',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function merchant()
    {
        return $this->hasOne(Merchant::class, 'pembayaran_id', 'id');
    }

    public function pembayaran()
    {
        return $this->hasOne(StatusPembayaran::class, 'pembayaran_id', 'id');
    }

    public static function store($params)
    {
        $pembayaran = self::create([
            'merchant_order_id' => $params['merchantOrderId'],
            'payment_amount' => $params['paymentAmount'],
            'customer_va_name' => $params['customerVaName'],
            'email' => $params['email'],
            'phone_number' => $params['phoneNumber'],
            'item_details' => json_encode($params['itemDetails']),
            'customer_detail' => json_encode($params['customerDetail']),
            'callback_url' => $params['callbackUrl'],
            'return_url' => $params['returnUrl'],
            'expiry_period' => $params['expiryPeriod'],
            'user_id' => Auth::user()->id,
        ]);

        return $pembayaran;
    }
}
