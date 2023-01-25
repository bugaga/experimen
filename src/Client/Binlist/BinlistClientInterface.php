<?php

declare(strict_types=1);

namespace App\Client\Binlist;

interface BinlistClientInterface
{
    public function getCardInfo(string $cardFirstDigits): array;
}
