<?php

declare(strict_types=1);

namespace App\Country;

use App\Client\Binlist\BinlistClientInterface;

final class CountryClientResolver implements CountryResolverInterface
{
    private BinlistClientInterface $binlistClient;

    public function __construct(BinlistClientInterface $binlistClient)
    {
        $this->binlistClient = $binlistClient;
    }

    public function getCountryAlpha2(string $firstCardDigits): string
    {
        return $this->binlistClient->getCardInfo($firstCardDigits)->getCountryAlpha2();
    }
}
