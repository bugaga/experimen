<?php

declare(strict_types=1);

namespace App\Transaction;

final class Transaction
{
    private string $bin;
    private AmountDTO $amount;
    private string $currency;

    public function __construct(string $bin, AmountDTO $amount, string $currency)
    {
        $this->bin = $bin;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getBin(): string
    {
        return $this->bin;
    }

    public function getAmount(): AmountDTO
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
