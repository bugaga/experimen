<?php

declare(strict_types=1);

namespace App\Transaction\Provider\Factory;

use App\Transaction\Provider\TransactionFromFileProvider;
use App\Transaction\Provider\TransactionProviderInterface;
use App\Transaction\Serializer\TransactionJsonSerializer;

final class TransactionProviderFactory
{
    public function createProviderFromFile(string $filePath): TransactionProviderInterface
    {
        return new TransactionFromFileProvider($filePath, new TransactionJsonSerializer());
    }
}
