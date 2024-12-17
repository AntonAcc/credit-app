<?php

declare(strict_types=1);

namespace App\Tests\Service\CreditService\EligibilityCheck;

use App\Entity\Client;
use App\Service\CreditService\EligibilityCheck\AddressState;
use App\Tests\Entity\ClientFactory;
use PHPUnit\Framework\TestCase;

class AddressStateTest extends TestCase
{
    public function testCaliforniaEligibility(): void
    {
        $client = $this->createClientWithState('CA');
        $check = new AddressState($client);

        $this->assertTrue($check->isEligible());
    }

    public function testNewYorkEligibility(): void
    {
        $client = $this->createClientWithState('NY');
        $check = new AddressState($client);

        $this->assertTrue($check->isEligible());
    }

    public function testNevadaEligibility(): void
    {
        $client = $this->createClientWithState('NV');
        $check = new AddressState($client);

        $this->assertTrue($check->isEligible());
    }

    public function testSomeOtherStateRejection(): void
    {
        $client = $this->createClientWithState('OS');
        $check = new AddressState($client);

        $this->assertFalse($check->isEligible());
    }

    private function createClientWithState(string $state): Client
    {
        $client = ClientFactory::create();
        $client->setState($state);

        return $client;
    }
}

