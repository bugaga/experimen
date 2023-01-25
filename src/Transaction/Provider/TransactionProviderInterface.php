<?php

declare(strict_types=1);

namespace App\Transaction\Provider;

use App\Transaction\Transaction;

interface TransactionProviderInterface
{
    /**
     * @return Transaction[]
     */
    public function getTransactions(): iterable;
}
