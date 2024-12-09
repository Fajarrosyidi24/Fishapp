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

        if ($httpCode == 200) {
            $result = json_decode($request, true);
            return $result;
        }

        throw new \Exception("API request failed with status code: " . $httpCode);
    }

    public function callbackUrl(array $data): bool
    {
        $apiKey = $this->merchantKey;
        $merchantCode = isset($_POST['merchantCode']) ? $_POST['merchantCode'] : null;
        $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
        $merchantOrderId = isset($_POST['merchantOrderId']) ? $_POST['merchantOrderId'] : null;
        $productDetail = isset($_POST['productDetail']) ? $_POST['productDetail'] : null;
        $additionalParam = isset($_POST['additionalParam']) ? $_POST['additionalParam'] : null;
        $paymentCode = isset($_POST['paymentCode']) ? $_POST['paymentCode'] : null;
        $resultCode = isset($_POST['resultCode']) ? $_POST['resultCode'] : null;
        $merchantUserId = isset($_POST['merchantUserId']) ? $_POST['merchantUserId'] : null;
        $reference = isset($_POST['reference']) ? $_POST['reference'] : null;
        $signature = isset($_POST['signature']) ? $_POST['signature'] : null;
        $publisherOrderId = isset($_POST['publisherOrderId']) ? $_POST['publisherOrderId'] : null;
        $spUserHash = isset($_POST['spUserHash']) ? $_POST['spUserHash'] : null;
        $settlementDate = isset($_POST['settlementDate']) ? $_POST['settlementDate'] : null;
        $issuerCode = isset($_POST['issuerCode']) ? $_POST['issuerCode'] : null;

        if (!empty($merchantCode) && !empty($amount) && !empty($merchantOrderId) && !empty($signature)) {
            $params = $merchantCode . $amount . $merchantOrderId . $apiKey;
            $calcSignature = md5($params);

            if ($signature == $calcSignature) {
                //Callback tervalidasi
                //Silahkan rubah status transaksi anda disini
                // file_put_contents('callback.txt', "* Berhasil *\r\n\r\n", FILE_APPEND | LOCK_EX);

            } else {
                // file_put_contents('callback.txt', "* Bad Signature *\r\n\r\n", FILE_APPEND | LOCK_EX);
                throw new \Exception('Bad Signature: Validation failed.');
            }
        } else {
            // file_put_contents('callback.txt', "* Bad Parameter *\r\n\r\n", FILE_APPEND | LOCK_EX);
            throw new \Exception('Bad Signature: Validation failed.');
        }

        return true;
    }
}
