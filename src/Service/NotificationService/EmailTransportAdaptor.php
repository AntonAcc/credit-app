<?php

declare(strict_types=1);

namespace App\Service\NotificationService;

use App\Service\NotificationService\EmailService\NotificationEmailInterface;
use App\Service\NotificationService\EmailService\SomeExternalEmailTransport;

readonly class EmailTransportAdaptor implements EmailServiceInterface
{
    public function __construct(
        private SomeExternalEmailTransport $transport,
    ) {}

    public function sendEmail(string $email, NotificationEmailInterface $notification): void
    {
        $this->transport->sendEmail(
            $email,
            $notification->getEmailSubject(),
            $notification->getEmailBody()
        );
    }
}
