<?php

declare(strict_types=1);

namespace App\Commission;

use App\Transaction\AmountDTO;

final class CommissionCalculator implements CommissionCalculatorInterface
{
    private const COUNTRIES_MEMBERS_OF_EU = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];
    private const EU_MEMBER_COMMISSION = 0.01;
    private const DEFAULT_COMMISSION = 0.02;

    public function calculateBasedOnCountry(AmountDTO $amountInEur, string $alpha2): AmountDTO
    {
        if ($this->isEUCountry($alpha2)) {
            return $amountInEur->mulitply(new AmountDTO(self::EU_MEMBER_COMMISSION));
        }

        return $amountInEur->mulitply(new AmountDTO(self::DEFAULT_COMMISSION));
    }

    private function isEUCountry(string $alpha2): bool
    {
        return in_array($alpha2, self::COUNTRIES_MEMBERS_OF_EU);
    }
}
