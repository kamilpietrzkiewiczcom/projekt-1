<?php

namespace App\Task\Adapter\Notification;

interface NotifyInterface
{
    public function sendMessage(string $message): void;
}