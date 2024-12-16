<?php

declare(strict_types=1);

namespace App\Service\NotificationService;

use App\Service\NotificationService\SmsService\NotificationSmsInterface;

interface SmsServiceInterface
{
    public function sendSms(string $phoneNumber, NotificationSmsInterface $notification): void;
}
