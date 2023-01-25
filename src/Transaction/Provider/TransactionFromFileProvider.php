<?php

declare(strict_types=1);

namespace App\Transaction\Provider;

use App\Transaction\Serializer\TransactionJsonSerializer;

final class TransactionFromFileProvider implements TransactionProviderInterface
{
    private string $filePath;
    private TransactionJsonSerializer $serializer;

    public function __construct(string $filePath, TransactionJsonSerializer $serializer)
    {
        $this->filePath = $filePath;
        $this->serializer = $serializer;
    }

    public function getTransactions(): iterable
    {
        if (false === file_exists($this->filePath)) {
            throw new \UnexpectedValueException(sprintf('File not exists "%s".', $this->filePath));
        }

        $resource = fopen($this->filePath, 'r');
        if (false === $resource) {
            throw new \RuntimeException(sprintf('Failed open file "%s".', $this->filePath));
        }

        while (($buffer = fgets($resource)) !== false) {
            $buffer = trim($buffer);
            if ('' === $buffer) {
                break;
            }

            yield $this->serializer->deserialize($buffer);
        }

        fclose($resource);
    }
}
