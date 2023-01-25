<?php

declare(strict_types=1);

namespace App\Country;

interface CountryResolverInterface
{
    public function getCountryAlpha2(string $firstCardDigits): string;
}
