<?php

/**
 * @author Anton Acc <me@anton-a.cc>
 */
declare(strict_types=1);

namespace App\Tests\Service\CreditService\EligibilityCheck;

use App\Entity\Client;
use App\Service\CreditService\EligibilityCheck\NyRandomDecision;
use App\Service\CreditService\RandomDecisionCached;
use App\Tests\Entity\ClientFactory;
use PHPUnit\Framework\TestCase;

class NyRandomDecisionTest extends TestCase
{
    public function testNotNewYorkEligibility(): void
    {
        $randomDecisionCachedMock = $this->createMock(RandomDecisionCached::class);
        $client = $this->createClientWithState('OS');
        $check = new NyRandomDecision($client, $randomDecisionCachedMock);

        $this->assertTrue($check->isEligible());
    }

    public function testNewYorkAndPositiveRandomDecisionEligibility(): void
    {
        $randomDecisionCachedMock = $this->createMock(RandomDecisionCached::class);
        $randomDecisionCachedMock->method('getByClient')->willReturn(true);

        $client = $this->createClientWithState('NY');
        $check = new NyRandomDecision($client, $randomDecisionCachedMock);

        $this->assertTrue($check->isEligible());
    }

    public function testNewYorkAndNegativeRandomDecisionRejection(): void
    {
        $randomDecisionCachedMock = $this->createMock(RandomDecisionCached::class);
        $randomDecisionCachedMock->method('getByClient')->willReturn(false);

        $client = $this->createClientWithState('NY');
        $check = new NyRandomDecision($client, $randomDecisionCachedMock);

        $this->assertFalse($check->isEligible());
    }

    private function createClientWithState(string $state): Client
    {
        $client = ClientFactory::create();
        $client->setState($state);

        return $client;
    }
}

