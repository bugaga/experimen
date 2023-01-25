<?php

declare(strict_types=1);

namespace App\Client\Binlist\Factory;

use App\Client\Binlist\BinlistApiClient;
use App\Client\Binlist\BinlistClientInterface;
use Symfony\Component\HttpClient\HttpClient;

class BinlistClientFactory
{
    public function createClient(): BinlistClientInterface
    {
        $baseUrl = $_ENV['BINLIST_BASE_URL'] ?? null;
        if (false === is_string($baseUrl) || '' === $baseUrl) {
            throw new \InvalidArgumentException(
                sprintf('BINLIST_BASE_URL is required to be string %s given', print_r($baseUrl, true))
            );
        }

        return new BinlistApiClient($baseUrl, HttpClient::create());
    }
}
