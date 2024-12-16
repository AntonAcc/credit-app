<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Credit;
use App\Service\NotificationService\EmailServiceInterface;
use App\Service\NotificationService\Notification\CreditNotification;
use App\Service\NotificationService\SmsServiceInterface;

readonly class NotificationService
{
    public function __construct(
        private EmailServiceInterface $emailService,
        private SmsServiceInterface $smsService,
    ) {}

    public function sendCreditNotification(Credit $credit): void
    {
        $client = $credit->getClient();
        $notification = new CreditNotification($credit);

        if ($client->getEmail()) {
            $this->emailService->sendEmail($client->getEmail(), $notification);
        }
        if ($client->getPhoneNumber()) {
            $this->smsService->sendSms($client->getPhoneNumber(), $notification);
        }
    }
}
