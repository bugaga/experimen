<?php

declare(strict_types=1);

namespace App\Client\Exception;

final class BadResponseStatusCodeException extends \RuntimeException
{
    public function __construct(int $statusCode, string $url)
    {
        parent::__construct(sprintf('Bad status code %d on request to %s.', $statusCode, $url), $statusCode);
    }
}
