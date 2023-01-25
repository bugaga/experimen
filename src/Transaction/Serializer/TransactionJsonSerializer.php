<?php

declare(strict_types=1);

namespace App\Transaction\Serializer;

use App\Transaction\AmountDTO;
use App\Transaction\Transaction;

final class TransactionJsonSerializer
{
    public function deserialize(string $json): Transaction
    {
        $rawData = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        return new Transaction($rawData['bin'], new AmountDTO((float) $rawData['amount']), $rawData['currency']);
    }
}
