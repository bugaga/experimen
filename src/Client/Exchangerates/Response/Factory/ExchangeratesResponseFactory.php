<?php

declare(strict_types=1);

namespace App\Client\Exchangerates\Response\Factory;

use App\Client\Exchangerates\Response\RatesResponse;

class ExchangeratesResponseFactory
{
    public function createRatesResponseFromApiData(array $data): RatesResponse
    {
        return new RatesResponse($data['rates'] ?? []);
    }
}
