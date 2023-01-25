<?php

declare(strict_types=1);

namespace App\Currency\Factory;

use App\Client\Exchangerates\Factory\ExchangeratesClientFactory;
use App\Currency\CurrencyClientConvertor;
use App\Currency\CurrencyConvertorInterface;

class CurrencyConvertorFactory
{
    private ExchangeratesClientFactory $clientFactory;

    public function __construct(ExchangeratesClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function createCurrencyApiConvertor(): CurrencyConvertorInterface
    {
        return new CurrencyClientConvertor($this->clientFactory->createClient());
    }
}
