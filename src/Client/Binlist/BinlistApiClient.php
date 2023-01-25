<?php

declare(strict_types=1);

namespace App\Client\Binlist;

use App\Client\Binlist\Response\CardInfoResponse;
use App\Client\Binlist\Response\Factory\CardInfoResponseFactory;
use App\Client\Exception\BadResponseStatusCodeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class BinlistApiClient implements BinlistClientInterface
{
    private string $baseUrl;
    private HttpClientInterface $client;
    private CardInfoResponseFactory $responseFactory;

    public function __construct(string $baseUrl, HttpClientInterface $client, CardInfoResponseFactory $responseFactory)
    {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
        $this->responseFactory = $responseFactory;
    }

    public function getCardInfo(string $cardFirstDigits): CardInfoResponse
    {
        $url = sprintf('%s/%s', $this->baseUrl, $cardFirstDigits);
        $response = $this->client->request('GET', $url);

        if (299 < $response->getStatusCode()) {
            throw new BadResponseStatusCodeException($response->getStatusCode(), $url);
        }

        return $this->responseFactory->createFromApiData($response->toArray());
    }
}
