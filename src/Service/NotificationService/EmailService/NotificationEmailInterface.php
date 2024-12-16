<?php

declare(strict_types=1);

namespace App\Service\NotificationService\EmailService;

interface NotificationEmailInterface
{
    public function getEmailSubject(): string;
    public function getEmailBody(): string;
}
