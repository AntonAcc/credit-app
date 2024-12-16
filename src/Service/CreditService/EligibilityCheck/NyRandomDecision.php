<?php

declare(strict_types=1);

namespace App\Service\CreditService\EligibilityCheck;

use App\Entity\Client;
use App\Entity\Client\AddressState as AddressStateEnum;
use App\Service\CreditService\RandomDecisionCached;

readonly class NyRandomDecision implements CheckInterface
{
    public function __construct(
        private Client $client,
        private RandomDecisionCached $randomDecisionCached
    ) {}

    public function isEligible(): bool
    {
        if ($this->client->getState() === AddressStateEnum::NEW_YORK->value) {
            return $this->randomDecisionCached->getByClient($this->client);
        }

        return true;
    }

    public function getRejectionReason(): string
    {
        return 'Random rejection for NY clients.';
    }
}
