<?php

declare(strict_types=1);

namespace App\Commission;

use App\Transaction\AmountDTO;

interface CommissionCalculatorInterface
{
    public function calculateBasedOnCountry(AmountDTO $amountInEur, string $alpha2): AmountDTO;
}
