<?php

namespace AppBundle\Handler;

use AppBundle\Model\User;

class EmailChangeAction implements ActionInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $newEmail;

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
    public function getNewEmail()
    {
        return $this->newEmail;
    }

    /**
     * @param string $newEmail
     */
    public function setNewEmail($newEmail)
    {
        $this->newEmail = $newEmail;
    }
}
