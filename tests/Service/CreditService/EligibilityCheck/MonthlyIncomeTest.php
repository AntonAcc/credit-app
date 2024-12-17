<?php

declare(strict_types=1);

namespace App\Tests\Service\CreditService\EligibilityCheck;

use App\Entity\Client;
use App\Service\CreditService\EligibilityCheck\MonthlyIncome;
use App\Tests\Entity\ClientFactory;
use PHPUnit\Framework\TestCase;

class MonthlyIncomeTest extends TestCase
{
    public function testMoreThanThresholdEligibility(): void
    {
        $client = $this->createClientWithMonthlyIncome(1001);
        $check = new MonthlyIncome($client);

        $this->assertTrue($check->isEligible());
    }

    public function testThresholdEligibility(): void
    {
        $client = $this->createClientWithMonthlyIncome(1000);
        $check = new MonthlyIncome($client);

        $this->assertTrue($check->isEligible());
    }

    public function testLessThanThresholdRejection(): void
    {
        $client = $this->createClientWithMonthlyIncome(999);
        $check = new MonthlyIncome($client);

        $this->assertFalse($check->isEligible());
    }

    private function createClientWithMonthlyIncome(int $monthlyIncome): Client
    {
        $client = ClientFactory::create();
        $client->setMonthlyIncome($monthlyIncome);

        return $client;
    }

}

