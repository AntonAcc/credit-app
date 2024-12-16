<?php

declare(strict_types=1);

namespace App\Service\CreditService\EligibilityCheck;

use App\Entity\Client;

class CreditScore implements CheckInterface
{
    private const int THRESHOLD = 500;

    public function __construct(
        readonly private Client $client
    ) {}

    public function isEligible(): bool
    {
        return $this->client->getCreditScore() > self::THRESHOLD;
    }

    public function getRejectionReason(): string
    {
        return sprintf('Credit score is less than %s', self::THRESHOLD);
    }
}
