<?php

declare(strict_types=1);

namespace App\Client\Binlist\Response\Factory;

use App\Client\Binlist\Response\CardInfoResponse;

class CardInfoResponseFactory
{
    public function createFromApiData(array $data): CardInfoResponse
    {
        $alpha2 = $data['country']['alpha2'] ?? null;
        if (null == $alpha2) {
            throw new \RuntimeException('Failed resolve country alpha2 by card digits');
        }

        return new CardInfoResponse($alpha2);
    }
}
