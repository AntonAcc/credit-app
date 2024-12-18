<?php

declare(strict_types=1);

namespace App\Tests\Service\CreditService\EligibilityCheck;

use App\Service\CreditService\EligibilityCheck\Chain as EligibilityCheckChain;
use App\Service\CreditService\EligibilityCheck\CheckInterface;
use PHPUnit\Framework\TestCase;

class ChainTest extends TestCase
{
    public function testEmptyChain(): void
    {
        $chain = new EligibilityCheckChain();

        $this->assertTrue($chain->isEligible());
        $this->assertEquals(0, count($chain->getRejectionReasons()));
    }

    public function testChainWithOneEligibleCheckOnly(): void
    {
        $checkEligible = $this->createMock(CheckInterface::class);
        $checkEligible->method('isEligible')->willReturn(true);

        $chain = new EligibilityCheckChain();
        $chain->with($checkEligible);

        $this->assertTrue($chain->isEligible());
        $this->assertEquals(0, count($chain->getRejectionReasons()));
    }

    public function testChainWithOneRejectedCheckOnly(): void
    {
        $checkRejected = $this->createMock(CheckInterface::class);
        $checkRejected->method('isEligible')->willReturn(false);

        $chain = new EligibilityCheckChain();
        $chain->with($checkRejected);

        $this->assertFalse($chain->isEligible());
        $this->assertEquals(1, count($chain->getRejectionReasons()));
    }

    public function testChainWithFirstEligibleCheck(): void
    {
        $checkEligible = $this->createMock(CheckInterface::class);
        $checkEligible->method('isEligible')->willReturn(true);
        $checkRejected = $this->createMock(CheckInterface::class);
        $checkRejected->method('isEligible')->willReturn(false);

        $chain = new EligibilityCheckChain();
        $chain->with($checkEligible);
        $chain->with($checkRejected);

        $this->assertFalse($chain->isEligible());
        $this->assertEquals(1, count($chain->getRejectionReasons()));
    }

    public function testChainWithFirstRejectedCheck(): void
    {
        $checkEligible = $this->createMock(CheckInterface::class);
        $checkEligible->method('isEligible')->willReturn(true);
        $checkRejected = $this->createMock(CheckInterface::class);
        $checkRejected->method('isEligible')->willReturn(false);

        $chain = new EligibilityCheckChain();
        $chain->with($checkRejected);
        $chain->with($checkEligible);

        $this->assertFalse($chain->isEligible());
        $this->assertEquals(1, count($chain->getRejectionReasons()));
    }

    public function testAllRejectedChecksProcessed(): void
    {
        $checkRejected = $this->createMock(CheckInterface::class);
        $checkRejected->method('isEligible')->willReturn(false);

        $chain = new EligibilityCheckChain();
        $chain->with($checkRejected);
        $chain->with($checkRejected);
        $chain->with($checkRejected);
        $chain->with($checkRejected);
        $chain->with($checkRejected);

        $this->assertFalse($chain->isEligible());
        $this->assertEquals(5, count($chain->getRejectionReasons()));
    }

    public function testResetAfterAddingAnotherCheckEligibility(): void
    {
        $checkRejected = $this->createMock(CheckInterface::class);
        $checkRejected->method('isEligible')->willReturn(false);

        $chain = new EligibilityCheckChain();

        $this->assertTrue($chain->isEligible());

        $chain->with($checkRejected);

        $this->assertFalse($chain->isEligible());
    }

    public function testResetAfterAddingAnotherCheckRejectionReasons(): void
    {
        $checkRejected = $this->createMock(CheckInterface::class);
        $checkRejected->method('isEligible')->willReturn(false);

        $chain = new EligibilityCheckChain();

        $this->assertEquals(0, count($chain->getRejectionReasons()));

        $chain->with($checkRejected);

        $this->assertEquals(1, count($chain->getRejectionReasons()));

        $chain->with($checkRejected);

        $this->assertEquals(2, count($chain->getRejectionReasons()));
    }
}



