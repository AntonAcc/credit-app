<?php

declare(strict_types=1);

namespace App\Service\CreditService\EligibilityCheck;

use App\Entity\Client;

class MonthlyIncome implements CheckInterface
{
    private const int THRESHOLD = 1000;

    public function __construct(
        readonly private Client $client
    ) {}

    public function isEligible(): bool
    {
        return $this->client->getMonthlyIncome() >= self::THRESHOLD;
    }

    public function getRejectionReason(): string
    {
        return sprintf('Monthly income is less than $%s.', self::THRESHOLD);
    }
}
