<?php

namespace AppBundle\Event;

use AppBundle\Model\User;
use Symfony\Component\EventDispatcher\Event;

class UserEmailChangeEvent extends Event
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $oldEmail;

    /**
     * @param User $user
     * @param string $oldEmail
     */
    public function __construct(User $user, $oldEmail)
    {
        $this->user = $user;
        $this->oldEmail = $oldEmail;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getOldEmail()
    {
        return $this->oldEmail;
    }

    /**
     * @param string $oldEmail
     */
    public function setOldEmail($oldEmail)
    {
        $this->oldEmail = $oldEmail;
    }
}
