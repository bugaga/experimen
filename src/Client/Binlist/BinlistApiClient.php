<?php

declare(strict_types=1);

namespace App\Client\Binlist;

use App\Client\Exception\BadResponseStatusCodeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class BinlistApiClient implements BinlistClientInterface
{
    private string $baseUrl;
    private HttpClientInterface $client;

    public function __construct(string $baseUrl, HttpClientInterface $client)
    {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
    }

    public function getCardInfo(string $cardFirstDigits): array
    {
        $url = sprintf('%s/%s', $this->baseUrl, $cardFirstDigits);
        $response = $this->client->request('GET', $url);

        if (299 < $response->getStatusCode()) {
            throw new BadResponseStatusCodeException($response->getStatusCode(), $url);
        }

        return $response->toArray();
    }
}
