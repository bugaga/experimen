<?php

declare(strict_types=1);

namespace App\Client\Exchangerates;

use App\Client\Exception\BadResponseStatusCodeException;
use App\Client\Exchangerates\Response\Factory\ExchangeratesResponseFactory;
use App\Client\Exchangerates\Response\RatesResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ExchangeratesApiClient implements ExchangeratesClientInterface
{
    private string $baseUrl;
    private HttpClientInterface $client;
    private ExchangeratesResponseFactory $responseFactory;

    public function __construct(
        string $baseUrl,
        HttpClientInterface $client,
        ExchangeratesResponseFactory $responseFactory
    ) {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
        $this->responseFactory = $responseFactory;
    }

    public function getRates(): RatesResponse
    {
        $url = sprintf('%s/latest', $this->baseUrl);
        $response = $this->client->request('GET', $url);

        if (299 < $response->getStatusCode()) {
            throw new BadResponseStatusCodeException($response->getStatusCode(), $url);
        }

        return $this->responseFactory->createRatesResponseFromApiData($response->toArray());
    }
}
