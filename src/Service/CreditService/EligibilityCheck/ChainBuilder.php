<?php

declare(strict_types=1);

namespace App\Service\CreditService\EligibilityCheck;

use App\Entity\Client;
use App\Service\CreditService\RandomDecisionCached;

class ChainBuilder
{
    private array $chainCache = [];

    public function __construct(
        readonly private RandomDecisionCached $randomDecisionCached,
    ) {}

    public function build(Client $client): Chain
    {
        if (!isset($this->chainCache[$client->getId()])) {
            // todo: think about moving this to config
            $this->chainCache[$client->getId()] = new Chain()
                ->with(new CreditScore($client))
                ->with(new MonthlyIncome($client))
                ->with(new Age($client))
                ->with(new AddressState($client))
                ->with(new NyRandomDecision($client, $this->randomDecisionCached));
        }

        return $this->chainCache[$client->getId()];
    }
}
