<?php

declare(strict_types=1);

namespace App\Entity;

class Product
{
    public function __construct(
        readonly private string $name,
        readonly private int $term,
        readonly private float $interestRate,
        readonly private float $amount,
    )
    {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getTerm(): int
    {
        return $this->term;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
