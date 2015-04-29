<?php

namespace AppBundle\EventListener;

use AppBundle\Event\UserEmailChangeEvent;
use Symfony\Bridge\Monolog\Logger;

class LogWhenUserEmailChange
{
    /**
     * @var Logger
     */
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function onUserEmailChange(UserEmailChangeEvent $event)
    {
        $this->logger->info(sprintf(
            'User %d changed email from %s to %s.',
            $event->getUser()->getId(),
            $event->getOldEmail(),
            $event->getUser()->getEmail()
        ));
    }
}
