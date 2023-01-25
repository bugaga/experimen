<?php

declare(strict_types=1);

namespace App\Client\Exchangerates;

use App\Client\Exception\BadResponseStatusCodeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ExchangeratesApiClient implements ExchangeratesClientInterface
{
    private string $baseUrl;
    private HttpClientInterface $client;

    public function __construct(string $baseUrl, HttpClientInterface $client)
    {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
    }

    public function getRates(): array
    {
        $url = sprintf('%s/latest', $this->baseUrl);
        $response = $this->client->request('GET', $url);

        if (299 < $response->getStatusCode()) {
            throw new BadResponseStatusCodeException($response->getStatusCode(), $url);
        }

        return $response->toArray();
    }
}
