<?php

declare(strict_types=1);

namespace App\Service\CreditService\EligibilityCheck;

use App\Entity\Client;
use App\Entity\Client\AddressState as AddressStateEnum;

class AddressState implements CheckInterface
{
    private const array ELIGIBLE_STATES = [
        AddressStateEnum::CALIFORNIA,
        AddressStateEnum::NEW_YORK,
        AddressStateEnum::NEVADA
    ];

    public function __construct(
        readonly private Client $client
    ) {}

    public function isEligible(): bool
    {
        return in_array($this->client->getState(), $this->getEligibleStatesValues(), true);
    }

    public function getRejectionReason(): string
    {
        return sprintf('Client does not live in %s.', implode(', ', $this->getEligibleStatesValues()));
    }

    private function getEligibleStatesValues()
    {
        return array_map(fn(AddressStateEnum $state) => $state->value, self::ELIGIBLE_STATES);
    }
}
