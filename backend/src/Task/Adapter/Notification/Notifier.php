<?php

namespace App\Task\Adapter\Notification;

class Notifier
{
    /**
     * @var NotifyInterface[] $notifiers
     */
    private array $notifiers = [];

    public function addNotifier(NotifyInterface $notify): void
    {
        $this->notifiers[] = $notify;
    }

    public function sendMessage(string $message): void
    {
        foreach ($this->notifiers as $notifier) {
            $notifier->sendMessage($message);
        }
    }
}
