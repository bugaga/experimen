<?php

declare(strict_types=1);

namespace App\Country\Factory;

use App\Client\Binlist\Factory\BinlistClientFactory;
use App\Country\CountryClientResolver;
use App\Country\CountryResolverInterface;

final class CountryResolverFactory
{
    private BinlistClientFactory $clientFactory;

    public function __construct(BinlistClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function createCountryApiResolver(): CountryResolverInterface
    {
        return new CountryClientResolver($this->clientFactory->createClient());
    }
}
