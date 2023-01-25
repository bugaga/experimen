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
        $result = $this->binlistClient->getCardInfo($firstCardDigits);
        $alpha2 = $result['country']['alpha2'] ?? null;
        if (null == $alpha2) {
            throw new \RuntimeException('Failed resolve country alpha2 by card digits');
        }

        return $alpha2;
    }
}
