<?php

declare(strict_types=1);

namespace App\Currency;

use App\Client\Exchangerates\ExchangeratesClientInterface;
use App\Transaction\AmountDTO;

final class CurrencyClientConvertor implements CurrencyConvertorInterface
{
    private const CURRENCY_CODE_EUR = 'EUR';

    private ExchangeratesClientInterface $client;

    public function __construct(ExchangeratesClientInterface $client)
    {
        $this->client = $client;
    }

    public function convertToEur(AmountDTO $amount, string $baseCurrency): AmountDTO
    {
        if (self::CURRENCY_CODE_EUR === $baseCurrency) {
            return $amount;
        }

        $response = $this->client->getRates();
        $rate = (float) ($response['rates'][$baseCurrency] ?? 0);
        if (0 >= $rate) {
            return $amount;
        }

        return $amount->devide(new AmountDTO($rate));
    }
}
