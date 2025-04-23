<?php

namespace App\Task\Adapter\EventListener;

use App\Task\Adapter\Notification\Notifier;
use App\Task\Application\Logging\Logger;
use App\Task\Domain\Product;
use Doctrine\Persistence\Event\LifecycleEventArgs;

readonly class ProductChangedNotifier
{
    public function __construct(
        private Logger   $logger,
        private Notifier $notifier
    ) {}

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof Product) {
            return;
        }
        $this->logger->log((string)$entity);
        $this->sendProductEmail($entity);
    }

    private function sendProductEmail(Product $product): void
    {
        $this->notifier->sendMessage("Test message");
    }
}