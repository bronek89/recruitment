<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Controller\UserController;
use AppBundle\Exception\ActionValidationFailedException;
use AppBundle\Handler\HandlerInterface;
use AppBundle\Model\User;
use AppBundle\Model\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testChangeEmail()
    {
        $actionHandler = $this->getMock(HandlerInterface::class);
        $userRepository = $this->getMock(UserRepository::class);
        $request = $this->getMock(Request::class);
        $userMock = $this->getMock(User::class, [], [1, 'irrelevant', 'irrelevant']);

        $userRepository
            ->method('find')
            ->with(1)
            ->will(self::returnValue($userMock))
        ;

        $controller = new UserController($actionHandler, $userRepository);

        /** @var JsonResponse $response */
        $response = $controller->changeEmailAction($request, $userMock);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testChangeEmailWhenUserNotFound()
    {
        $actionHandler = $this->getMock(HandlerInterface::class);
        $userRepository = $this->getMock(UserRepository::class);
        $request = $this->getMock(Request::class);
        $userMock = null;

        $controller = new UserController($actionHandler, $userRepository);

        /** @var JsonResponse $response */
        $response = $controller->changeEmailAction($request, $userMock);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(404, $response->getStatusCode());
    }

    public function testChangeEmailWhenEmailIncorrect()
    {
        $actionHandler = $this->getMock(HandlerInterface::class);
        $userRepository = $this->getMock(UserRepository::class);
        $request = $this->getMock(Request::class);
        $userMock = $this->getMock(User::class, [], [1, 'irrelevant', 'irrelevant']);

        $actionHandler
            ->method('handle')
            ->will(self::throwException(new ActionValidationFailedException()))
            ;

        $controller = new UserController($actionHandler, $userRepository);

        /** @var JsonResponse $response */
        $response = $controller->changeEmailAction($request, $userMock);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }
}
