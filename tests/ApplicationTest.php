<?php

declare(strict_types=1);

namespace Test\App;

use App\Client\Binlist\BinlistClientInterface;
use App\Client\Binlist\Factory\BinlistClientFactory;
use App\Client\Binlist\Response\CardInfoResponse;
use App\Client\Exchangerates\ExchangeratesClientInterface;
use App\Client\Exchangerates\Factory\ExchangeratesClientFactory;
use App\Client\Exchangerates\Response\RatesResponse;
use App\Transaction\AmountDTO;
use App\Transaction\Provider\TransactionProviderInterface;
use App\Transaction\Transaction;

final class ApplicationTest extends \PHPUnit\Framework\TestCase
{
    public function testSuccessful(): void
    {
        $transaction1 = new Transaction('12345', new AmountDTO(100.0), 'UAH');
        $transaction2 = new Transaction('09876', new AmountDTO(32.8), 'EUR');

        $transactionProvider = $this->createStub(TransactionProviderInterface::class);
        $transactionProvider->method('getTransactions')->willReturn([$transaction1, $transaction2]);

        $exchangeratesClient = $this->createStub(ExchangeratesClientInterface::class);
        $exchangeratesClient
            ->method('getRates')
            ->willReturn(new RatesResponse(['UAH' => 40.5]));
        $exchangeratesClientFactory = $this->createStub(ExchangeratesClientFactory::class);
        $exchangeratesClientFactory->method('createClient')->willReturn($exchangeratesClient);

        $binlistClient = $this->createStub(BinlistClientInterface::class);
        $binlistClient
            ->method('getCardInfo')
            ->willReturnMap(
                [
                    ['12345', new CardInfoResponse('UA')],
                    ['09876', new CardInfoResponse('FR')],
                ]
            );
        $binlistClientFactory = $this->createStub(BinlistClientFactory::class);
        $binlistClientFactory->method('createClient')->willReturn($binlistClient);

        $applicateion = new TestableApplication(
            $transactionProvider,
            $exchangeratesClientFactory,
            $binlistClientFactory
        );
        $applicateion->run();

        $expectedFinalAmountUah = new AmountDTO((100 / 40.5) * 0.02);
        $expectedFinalAmountEur = new AmountDTO(32.8 * 0.01);

        $expectedOutput = <<<OUTPUT
Final amount of transaction for card "12345" is %s
Final amount of transaction for card "09876" is %s

OUTPUT;

        $this->expectOutputString(sprintf($expectedOutput, $expectedFinalAmountUah, $expectedFinalAmountEur));
    }
}
