<?php

namespace App\Task\Adapter\Notification;

use Symfony\Component\Mailer\MailerInterface;

readonly class NotifierFactory
{
    public function __construct(private MailerInterface $mailer) {}

    public function getNotifier(): Notifier
    {
        $notifier = new Notifier();
        $notifier->addNotifier(new EmailNotifier($this->mailer));
        return $notifier;
    }
}
