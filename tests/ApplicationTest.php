<?php

declare(strict_types=1);

namespace Test\App;

use App\Client\Binlist\BinlistClientInterface;
use App\Client\Binlist\Factory\BinlistClientFactory;
use App\Client\Exchangerates\ExchangeratesClientInterface;
use App\Client\Exchangerates\Factory\ExchangeratesClientFactory;
use App\Transaction\AmountDTO;
use App\Transaction\Provider\TransactionProviderInterface;
use App\Transaction\Transaction;

final class ApplicationTest extends \PHPUnit\Framework\TestCase
{
    public function testSuccessful(): void
    {
        $transaction = new Transaction('12345', new AmountDTO(100.0), 'UAH');
        $transactionProvider = $this->createStub(TransactionProviderInterface::class);
        $transactionProvider->method('getTransactions')->willReturn([$transaction]);

        $exchangeratesClient = $this->createStub(ExchangeratesClientInterface::class);
        $exchangeratesClient
            ->method('getRates')
            ->willReturn(
                [
                    'rates' => [
                        'UAH' => 40.5,
                    ],
                ]
            );
        $exchangeratesClientFactory = $this->createStub(ExchangeratesClientFactory::class);
        $exchangeratesClientFactory->method('createClient')->willReturn($exchangeratesClient);

        $binlistClient = $this->createStub(BinlistClientInterface::class);
        $binlistClient
            ->method('getCardInfo')
            ->with('12345')
            ->willReturn(['country' => ['alpha2' => 'UA']]);
        $binlistClientFactory = $this->createStub(BinlistClientFactory::class);
        $binlistClientFactory->method('createClient')->willReturn($binlistClient);

        $applicateion = new TestableApplication(
            $transactionProvider,
            $exchangeratesClientFactory,
            $binlistClientFactory
        );
        $applicateion->run();

        $expectedFinalAmount = new AmountDTO((100 / 40.5) * 0.02);

        $this->expectOutputString(
            sprintf('Final amount of transaction for card "%s" is %s', '12345', $expectedFinalAmount)
        );
    }
}
