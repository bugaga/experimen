<?php

declare(strict_types=1);

namespace App\Client\Binlist;

use App\Client\Binlist\Response\CardInfoResponse;

interface BinlistClientInterface
{
    public function getCardInfo(string $cardFirstDigits): CardInfoResponse;
}
