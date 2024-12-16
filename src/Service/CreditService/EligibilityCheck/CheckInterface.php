<?php

/**
 * @author Anton Acc <me@anton-a.cc>
 */
declare(strict_types=1);

namespace App\Service\CreditService\EligibilityCheck;

use App\Entity\Client;

interface CheckInterface
{
    public function isEligible(): bool;
    public function getRejectionReason(): string;
}
