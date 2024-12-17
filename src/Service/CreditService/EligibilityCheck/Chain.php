<?php

declare(strict_types=1);

namespace App\Service\CreditService\EligibilityCheck;

use App\Entity\Client;

class Chain
{
    /** @var CheckInterface[]  */
    private array $checks = [];

    private bool|null $isEligible = null;
    private array|null $rejectionReasons = null;

    public function with(CheckInterface $check): self
    {
        $this->checks[] = $check;

        return $this;
    }

    public function isEligible(): bool
    {
        if ($this->isEligible === null) {
            $this->check();
        }

        return $this->isEligible;
    }

    public function getRejectionReasons(): array
    {
        if ($this->rejectionReasons === null) {
            $this->check();
        }

        return $this->rejectionReasons;
    }

    private function check(): void
    {
        $this->rejectionReasons = [];
        foreach ($this->checks as $check) {
            if (!$check->isEligible()) {
                $this->rejectionReasons[] = $check->getRejectionReason();
            }
        }

        $this->isEligible = true;
        if (count($this->rejectionReasons) > 0) {
            $this->isEligible = false;
        }
    }
}
