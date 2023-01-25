<?php

declare(strict_types=1);

namespace App\Currency;

use App\Transaction\AmountDTO;

interface CurrencyConvertorInterface
{
    public function convertToEur(AmountDTO $amount, string $baseCurrency): AmountDTO;
}
