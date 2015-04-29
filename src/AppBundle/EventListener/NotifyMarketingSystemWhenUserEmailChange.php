<?php

namespace AppBundle\EventListener;

use AppBundle\Event\UserEmailChangeEvent;
use AppBundle\Service\MarketingSystem;

class NotifyMarketingSystemWhenUserEmailChange
{
    /**
     * @var MarketingSystem
     */
    protected $marketingSystem;

    public function __construct(MarketingSystem $marketingSystem)
    {
        $this->marketingSystem = $marketingSystem;
    }

    public function onUserEmailChange(UserEmailChangeEvent $event)
    {
        $this->marketingSystem->postRequest([
            'user' => $event->getUser(),
            'old_email' => $event->getOldEmail(),
        ]);
    }
}
