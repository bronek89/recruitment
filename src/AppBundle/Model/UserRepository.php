<?php

namespace AppBundle\Model;

class UserRepository
{
	/** @var \SplObjectStorage|User[] */
	protected $users;

	public function __construct()
	{
		$this->users = new \SplObjectStorage();

		$this->users->attach(new User(1034, 'Rafael', 'rafael@example.com'));
		$this->users->attach(new User(1035, 'Donatello', 'donatello@example.com'));
		$this->users->attach(new User(1036, 'Michelangelo', 'michelangelo@example.com'));
		$this->users->attach(new User(1037, 'Leonardo', 'leonardo@example.com'));
	}

    /**
     * @param int $id
     * @return User|null
     */
    public function find($id)
    {
        /** @var User $user */
        foreach ($this->users as $user) {
            if ($user->getId() === (int) $id) {
                return $user;
            }
        }

        return null;
    }
}
