<?php

declare(strict_types=1);

namespace App\Client\Exchangerates\Response;

final class RatesResponse
{
    private array $rates;

    public function __construct(array $rates)
    {
        $this->rates = $rates;
    }

    public function getRateForCurrency(string $currency): ?float
    {
        if (false === array_key_exists($currency, $this->rates)) {
            return null;
        }

        return (float) $this->rates[$currency];
    }
}
