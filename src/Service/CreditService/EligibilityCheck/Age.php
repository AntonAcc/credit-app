<?php

declare(strict_types=1);

namespace App\Service\CreditService\EligibilityCheck;

use App\Entity\Client;

class Age implements CheckInterface
{
    private const int THRESHOLD_MIN = 18;
    private const int THRESHOLD_MAX = 60;

    public function __construct(
        readonly private Client $client
    ) {}

    public function isEligible(): bool
    {
        return $this->client->getAge() >= self::THRESHOLD_MIN && $this->client->getAge() <= self::THRESHOLD_MAX;
    }

    public function getRejectionReason(): string
    {
        return sprintf('Client age is not between %s and %s.', self::THRESHOLD_MIN, self::THRESHOLD_MAX);
    }
}
