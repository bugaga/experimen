<?php

declare(strict_types=1);

namespace App\Transaction;

final class AmountDTO
{
    private const PRECISION = 2;

    private float $amount;

    public function __construct(float $amount)
    {
        $this->amount = round($amount, self::PRECISION);
    }

    public function __toString(): string
    {
        return number_format($this->amount, self::PRECISION);
    }

    public function mulitply(AmountDTO $operand): AmountDTO
    {
        return new AmountDTO($this->amount * $operand->amount);
    }

    public function devide(AmountDTO $operand): AmountDTO
    {
        if (0.0 === $operand->amount) {
            throw new \LogicException('Division by zero');
        }

        return new AmountDTO($this->amount / $operand->amount);
    }
}
