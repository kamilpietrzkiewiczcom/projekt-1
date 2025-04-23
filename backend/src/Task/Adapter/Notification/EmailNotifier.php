<?php

namespace App\Task\Adapter\Notification;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailNotifier implements NotifyInterface
{
    public function __construct(private readonly MailerInterface $mailer) {}

    public function sendMessage(string $message): void
    {
        $email = (new TemplatedEmail())
            ->from('test@zadanie.test')
            ->to(new Address('test@zadanie.test'))
            ->subject('This is some message')
            ->htmlTemplate('emails/notification.html.twig')
        ;

        $this->mailer->send($email);
    }
}
