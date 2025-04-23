<?php

namespace App\Task\Adapter\EventListener;

use App\Task\Application\Logging\Logger;
use App\Task\Domain\Product;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class ProductChangedNotifier
{
    public function __construct(
        private readonly Logger $logger,
        private readonly MailerInterface $mailer
    ) {}

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Product) {
            return;
        }
        $this->logger->log((string)$entity);
        $this->sendProductEmail($entity);
    }

    private function sendProductEmail(Product $product)
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