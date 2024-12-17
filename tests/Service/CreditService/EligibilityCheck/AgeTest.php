<?php

declare(strict_types=1);

namespace App\Tests\Service\CreditService\EligibilityCheck;

use App\Entity\Client;
use App\Service\CreditService\EligibilityCheck\Age;
use App\Tests\Entity\ClientFactory;
use PHPUnit\Framework\TestCase;

class AgeTest extends TestCase
{
    public function testMinThresholdEligibility(): void
    {
        $client = $this->createClientWithAge(18);
        $check = new Age($client);

        $this->assertTrue($check->isEligible());
    }

    public function testMaxThresholdEligibility(): void
    {
        $client = $this->createClientWithAge(60);
        $check = new Age($client);

        $this->assertTrue($check->isEligible());
    }

    public function testBetweenMinAndMaxThresholdEligibility(): void
    {
        $client = $this->createClientWithAge(25);
        $check = new Age($client);

        $this->assertTrue($check->isEligible());
    }

    public function testLessThanMinThresholdRejection(): void
    {
        $client = $this->createClientWithAge(17);
        $check = new Age($client);

        $this->assertFalse($check->isEligible());
    }

    public function testMoreThanMaxThresholdRejection(): void
    {
        $client = $this->createClientWithAge(61);
        $check = new Age($client);

        $this->assertFalse($check->isEligible());
    }

    private function createClientWithAge(int $age): Client
    {
        $client = ClientFactory::create();
        $client->setAge($age);

        return $client;
    }
}
