<?php

namespace App\Tests\Task\Adapter\Notification;

use App\Task\Adapter\Notification\EmailNotifier;
use App\Task\Adapter\Notification\Notifier;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function SebastianBergmann\Type\TestFixture\voidReturnType;

class NotifierTest extends KernelTestCase
{
    public function testNotifier(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $notifier = new Notifier();

        $mailerMock = $this->createMock(EmailNotifier::class);
        $mailerMock->expects(self::once())
            ->method('sendMessage')
            ->with("test message");

        $notifier->addNotifier($mailerMock);
        $notifier->sendMessage("test message");
    }
}