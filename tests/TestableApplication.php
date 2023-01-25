<?php

declare(strict_types=1);

namespace Test\App;

use App\Application;
use App\Client\Binlist\Factory\BinlistClientFactory;
use App\Client\Exchangerates\Factory\ExchangeratesClientFactory;
use App\Commission\CommissionCalculator;
use App\Country\Factory\CountryResolverFactory;
use App\Currency\Factory\CurrencyConvertorFactory;
use App\Transaction\Provider\TransactionProviderInterface;

final class TestableApplication extends Application
{
    public function __construct(
        TransactionProviderInterface $transactionProvider,
        ExchangeratesClientFactory $exchangeratesClientFactory,
        BinlistClientFactory $binlistClientFactory
    ) {
        $this->transactionProvider = $transactionProvider;
        $this->currencyConvertor = (new CurrencyConvertorFactory(
            $exchangeratesClientFactory
        ))->createCurrencyApiConvertor();
        $this->countryResolver = (new CountryResolverFactory($binlistClientFactory))->createCountryApiResolver();
        $this->commissionCalculator = new CommissionCalculator();
    }
}
