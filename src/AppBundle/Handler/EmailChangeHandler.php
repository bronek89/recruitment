<?php

namespace AppBundle\Handler;

use AppBundle\Event\UserEmailChangeEvent;
use AppBundle\Exception\ActionValidationFailedException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmailChangeHandler implements HandlerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct(EventDispatcherInterface $eventDispatcher, ValidatorInterface $validator)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->validator = $validator;
    }

    /**
     * @param ActionInterface $action
     * @return bool
     */
    public function supports(ActionInterface $action)
    {
        return $action instanceof EmailChangeAction;
    }

    /**
     * @param ActionInterface $action
     * @throws ActionValidationFailedException
     */
    public function handle(ActionInterface $action)
    {
        if (false === $action instanceof EmailChangeAction) {
            throw new \LogicException("Unsupported action supplied");
        }

        /** @var EmailChangeAction $action */

        $user = $action->getUser();
        $newEmail = $action->getNewEmail();

        $oldEmail = $user->getEmail();
        $user->setEmail($newEmail);

        $validationErrors = $this->validator->validate($user);

        if (count($validationErrors) > 0) {
            throw new ActionValidationFailedException($validationErrors);
        }

        $event = new UserEmailChangeEvent($user, $oldEmail);
        $this->eventDispatcher->dispatch('user.email_change', $event);
    }
}
