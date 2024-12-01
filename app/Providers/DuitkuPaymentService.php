<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use App\Interface\PaymentGatewayInterface;

class DuitkuPaymentService implements PaymentGatewayInterface
{
    protected $merchantCode;
    protected $merchantKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->merchantCode = env('SANDBOX_MERCHANTCODE');
        $this->merchantKey = env('SANDBOX_KEY');
        $this->baseUrl = 'https://api-sandbox.duitku.com/api/merchant/createinvoice';

        // $url = 'https://api-sandbox.duitku.com/api/merchant/createinvoice'; // Sandbox
        // // $url = 'https://api-prod.duitku.com/api/merchant/createinvoice'; // Production
    }

    public function createInvoice(array $params): array
    {
        $timestamp = round(microtime(true) * 1000);
        $signature = hash('sha256', $this->merchantCode . $timestamp . $this->merchantKey);

        $params_string = json_encode($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params_string),
                'x-duitku-signature:' . $signature,
                'x-duitku-timestamp:' . $timestamp,
                'x-duitku-merchantcode:' . $this->merchantCode
            )
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $request = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($httpCode == 200)
    {
        $result = json_decode($request, true);
        return $result;
    }

    throw new \Exception($httpCode->body());
    }
}
