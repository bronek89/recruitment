<?php

namespace AppBundle\EventListener;

use AppBundle\Event\UserEmailChangeEvent;
use AppBundle\Service\StatsSystem;

class NotifyStatsSystemWhenUserEmailChange
{
    /**
     * @var StatsSystem
     */
    protected $statsSystem;

    public function __construct(StatsSystem $statsSystem)
    {
        $this->statsSystem = $statsSystem;
    }

    public function onUserEmailChange(UserEmailChangeEvent $event)
    {
        $this->statsSystem->postRequest([
            'user' => $event->getUser(),
            'old_email' => $event->getOldEmail(),
        ]);
    }
}
