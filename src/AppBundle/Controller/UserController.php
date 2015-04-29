<?php

namespace AppBundle\Controller;

use AppBundle\Exception\ActionValidationFailedException;
use AppBundle\Handler\EmailChangeAction;
use AppBundle\Handler\HandlerInterface;
use AppBundle\Model\User;
use AppBundle\Model\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(service="app.controller.user")
 */
class UserController
{
    /**
     * @var HandlerInterface
     */
    private $actionHandler;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(HandlerInterface $actionHandler, UserRepository $userRepository)
    {
        $this->actionHandler = $actionHandler;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/{user}/changeEmail")
     * @Method("PUT")
     */
    public function changeEmailAction(Request $request, User $user = null)
    {
        if (null === $user) {
            return new JsonResponse([
                'status' => 'User not found.',
            ], 404);
        }

        $newEmail = $request->get('email');

        $action = new EmailChangeAction();
        $action->setNewEmail($newEmail);
        $action->setUser($user);

        try {
            $this->actionHandler->handle($action);
        } catch (ActionValidationFailedException $exception) {
            return new JsonResponse([
                'status' => 'Validation error.',
                'errors' => (string) $exception->getValidationErrors(),
            ], 400);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'status' => 'Unexpected error occurs during executing the action.',
            ], 500);
        }

        return new JsonResponse([
            'status' => 'Ok.',
        ]);
    }
}
