<?php

declare(strict_types=1);

namespace App\Service\NotificationService\Notification;

use App\Entity\Credit;
use App\Service\NotificationService\EmailService\NotificationEmailInterface;
use App\Service\NotificationService\SmsService\NotificationSmsInterface;

readonly class CreditNotification implements NotificationSmsInterface, NotificationEmailInterface
{
    public function __construct(
        private Credit $credit
    ) {}

    public function getSmsContent(): string
    {
        return sprintf("You have approved credit '%s'", $this->credit->getProductName());
    }

    public function getEmailSubject(): string
    {
        return sprintf("You have approved credit '%s'", $this->credit->getProductName());
    }

    public function getEmailBody(): string
    {
        $header = sprintf("Congratulations!!!\n\nYou have approved credit '%s'", $this->credit->getProductName());

        $details = ['Details:'];
        $details[] = sprintf("Amount: %s", $this->credit->getAmount());
        $details[] = sprintf("Term: %s", $this->credit->getTerm());
        $details[] = sprintf("Rate: %s", $this->credit->getInterestRate());

        return sprintf("%s\n\n%s", $header, implode("\n", $details));
    }
}
