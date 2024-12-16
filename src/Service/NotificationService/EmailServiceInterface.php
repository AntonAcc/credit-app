<?php

/**
 * @author Anton Acc <me@anton-a.cc>
 */
declare(strict_types=1);

namespace App\Service\NotificationService;

use App\Service\NotificationService\EmailService\NotificationEmailInterface;

interface EmailServiceInterface
{
    public function sendEmail(string $email, NotificationEmailInterface $notification): void;
}
