<?php

declare(strict_types=1);

namespace App\Service\NotificationService;

use App\Service\NotificationService\SmsService\NotificationSmsInterface;
use App\Service\NotificationService\SmsService\SomeExternalSmsTransport;

readonly class SmsTransportAdaptor implements SmsServiceInterface
{
    public function __construct(
        private SomeExternalSmsTransport $transport,
    ) {}

    public function sendSms(string $phoneNumber, NotificationSmsInterface $notification): void
    {
        $this->transport->sendSms(
            $phoneNumber,
            $notification->getSmsContent(),
        );
    }

}
