<?php

declare(strict_types=1);

namespace App\Client\Exchangerates\Factory;

use App\Client\Exchangerates\ExchangeratesApiClient;
use App\Client\Exchangerates\ExchangeratesClientInterface;
use Symfony\Component\HttpClient\HttpClient;

class ExchangeratesClientFactory
{
    public function createClient(): ExchangeratesClientInterface
    {
        $baseUrl = $_ENV['EXCHANGEREATES_BASE_URL'] ?? null;
        if (false === is_string($baseUrl) || '' === $baseUrl) {
            throw new \InvalidArgumentException(
                sprintf('EXCHANGEREATES_BASE_URL is required to be string %s given', print_r($baseUrl, true))
            );
        }

        return new ExchangeratesApiClient($baseUrl, HttpClient::create());
    }
}
