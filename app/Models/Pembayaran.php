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
        'biaya_admin',
        'total_ongkir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function create($user, $total, $admin, $totalshiping, $subtotalproduk, $pesanan)
    {
        $cleanedTotal = preg_replace('/[^0-9.]/', '', $total);
        $finalTotal = (int) str_replace('.', '', $cleanedTotal);

        $name = $user->name;
        $nameParts = explode(' ', $name);
        $firstname1 = implode(' ', array_slice($nameParts, 0, 2));
        $lastname1 = implode(' ', array_slice($nameParts, 2));

        $paymentAmount = $finalTotal;
        $merchantOrderId = time() . ''; // dari merchant, unique
        $productDetails = 'Test Pay with duitku';
        $email = $user->email; // email pelanggan merchant
        $phoneNumber = $user->updateProfile->no_telepon; // nomor tlp pelanggan merchant (opsional)
        $additionalParam = ''; // opsional
        $merchantUserInfo = ''; // opsional
        $customerVaName = $user->name; // menampilkan nama pelanggan pada tampilan konfirmasi bank
        $callbackUrl = 'http://example.com/api-pop/backend/callback.php'; // url untuk callback
        $returnUrl = 'http://example.com/api-pop/backend/redirect.php'; //'http://example.com/return'; // url untuk redirect
        $expiryPeriod = 60*24; // untuk menentukan waktu kedaluarsa dalam menit

        // // Detail pelanggan
        $firstName = $firstname1;
        $lastName = $lastname1;

        //Detail Alamat
        $alamat1 = AlamatTujuanSeafood::where('user_id', $user->id)->first();
        $destination = "$alamat1->provinsi, $alamat1->kabupaten, $alamat1->kecamatan, $alamat1->desa, RT.$alamat1->rt/RW.$alamat1->rw, Kode Pos : $alamat1->code_pos";
        $alamat = $destination;
        $city = $alamat1->kabupaten;
        $postalCode = $alamat1->code_pos;
        $countryCode = "ID";

        $address = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'address' => $alamat,
            'city' => $city,
            'postalCode' => $postalCode,
            'phone' => $phoneNumber,
            'countryCode' => $countryCode
        );

        $customerDetail = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'billingAddress' => $address,
            'shippingAddress' => $address
        );

        $itemDetails = [];
        $counter = 1;
        foreach ($pesanan as $data) {
            $item = [
                'name' => "Pesanan $counter",  
                'price' => $data->total_keseluruhan_harga,     
                'quantity' => $data->jumlah_item, 
            ];
            $itemDetails[] = $item;
        }
        $adminFee = 5000;
        $itemDetails[] = [
            'name' => 'biaya admin',
            'price' => $adminFee,
            'quantity' => 1,
        ];

        $params = array(
            'paymentAmount' => $paymentAmount,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'additionalParam' => $additionalParam,
            'merchantUserInfo' => $merchantUserInfo,
            'customerVaName' => $customerVaName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'itemDetails' => $itemDetails,
            'customerDetail' => $customerDetail,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'expiryPeriod' => $expiryPeriod
        );

        return $params;
    }
}
