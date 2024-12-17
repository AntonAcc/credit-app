<?php

declare(strict_types=1);

namespace App\Tests\Service\CreditService\EligibilityCheck;

use App\Entity\Client;
use App\Service\CreditService\EligibilityCheck\CreditScore;
use App\Tests\Entity\ClientFactory;
use PHPUnit\Framework\TestCase;

class CreditScoreTest extends TestCase
{
    public function testMoreThanThresholdEligibility(): void
    {
        $client = $this->createClientWithCreditScore(501);
        $check = new CreditScore($client);

        $this->assertTrue($check->isEligible());
    }

    public function testThresholdRejection(): void
    {
        $client = $this->createClientWithCreditScore(500);
        $check = new CreditScore($client);

        $this->assertFalse($check->isEligible());
    }

    public function testLessThanThresholdRejection(): void
    {
        $client = $this->createClientWithCreditScore(499);
        $check = new CreditScore($client);

        $this->assertFalse($check->isEligible());
    }

    private function createClientWithCreditScore(int $creditScore): Client
    {
        $client = ClientFactory::create();
        $client->setCreditScore($creditScore);

        return $client;
    }
}
