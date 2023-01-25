<?php

declare(strict_types=1);

namespace App;

use App\Client\Binlist\Factory\BinlistClientFactory;
use App\Client\Exchangerates\Factory\ExchangeratesClientFactory;
use App\Commission\CommissionCalculator;
use App\Commission\CommissionCalculatorInterface;
use App\Country\CountryResolverInterface;
use App\Country\Factory\CountryResolverFactory;
use App\Currency\CurrencyConvertorInterface;
use App\Currency\Factory\CurrencyConvertorFactory;
use App\Transaction\Provider\Factory\TransactionProviderFactory;
use App\Transaction\Provider\TransactionProviderInterface;
use Symfony\Component\Dotenv\Dotenv;

class Application
{
    protected TransactionProviderInterface $transactionProvider;
    protected CurrencyConvertorInterface $currencyConvertor;
    protected CountryResolverInterface $countryResolver;
    protected CommissionCalculatorInterface $commissionCalculator;

    public function __construct(array $argv)
    {
        $dotenv = new Dotenv();
        $dotenv->loadEnv(__DIR__ . '/../.env');

        $transactionsFile = (string) ($argv[1] ?? '');
        if ('' === $transactionsFile) {
            throw new \InvalidArgumentException('File path argument is required to run program!');
        }

        $this->transactionProvider = (new TransactionProviderFactory())->createProviderFromFile($transactionsFile);
        $this->currencyConvertor = (new CurrencyConvertorFactory(
            new ExchangeratesClientFactory()
        ))->createCurrencyApiConvertor();
        $this->countryResolver = (new CountryResolverFactory(new BinlistClientFactory()))->createCountryApiResolver();
        $this->commissionCalculator = new CommissionCalculator();
    }

    final public function run(): void
    {
        foreach ($this->transactionProvider->getTransactions() as $transaction) {
            $amount = $this->currencyConvertor->convertToEur($transaction->getAmount(), $transaction->getCurrency());

            $finalAmount = $this->commissionCalculator->calculateBasedOnCountry(
                $amount,
                $this->countryResolver->getCountryAlpha2($transaction->getBin())
            );

            printf('Final amount of transaction for card "%s" is %s%s', $transaction->getBin(), $finalAmount, PHP_EOL);
        }
    }
}
