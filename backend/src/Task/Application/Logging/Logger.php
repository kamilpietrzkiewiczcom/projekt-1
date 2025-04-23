<?php

namespace App\Task\Application\Logging;

use Psr\Log\LoggerInterface;

readonly class Logger
{
    public function __construct(private LoggerInterface $logger) {}

    public function log(string $message): void
    {
        $this->logger->debug($message);
    }
}
