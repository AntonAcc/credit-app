<?php

declare(strict_types=1);

namespace App\Service\NotificationService\SmsService;

interface NotificationSmsInterface
{
    public function getSmsContent(): string;
}
