<?php

namespace App\Interface;

interface PaymentGatewayInterface
{
    public function createInvoice(array $params): array;
    public function callbackUrl(array $data): bool;
}
