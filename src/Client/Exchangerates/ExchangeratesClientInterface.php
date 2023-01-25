<?php

declare(strict_types=1);

namespace App\Client\Exchangerates;

use App\Client\Exchangerates\Response\RatesResponse;

interface ExchangeratesClientInterface
{
    public function getRates(): RatesResponse;
}
