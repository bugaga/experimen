<?php

declare(strict_types=1);

namespace App\Client\Binlist\Response;

final class CardInfoResponse
{
    private string $countryAlpha2;

    public function __construct(string $countryAlpha2)
    {
        $this->countryAlpha2 = $countryAlpha2;
    }

    public function getCountryAlpha2(): string
    {
        return $this->countryAlpha2;
    }
}
