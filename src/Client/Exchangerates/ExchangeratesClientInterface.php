<?php

declare(strict_types=1);

namespace App\Client\Exchangerates;

interface ExchangeratesClientInterface
{
    public function getRates(): array;
}
