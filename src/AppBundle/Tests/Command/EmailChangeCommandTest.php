<?php

namespace AppBundle\Tests\Command;

use AppBundle\Command\EmailChangeCommand;
use AppBundle\Handler\HandlerInterface;
use AppBundle\Model\User;
use AppBundle\Model\UserRepository;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class EmailChangeCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $actionHandler = $this->getMock(HandlerInterface::class);
        $userRepository = $this->getMock(UserRepository::class);
        $userMock = $this->getMock(User::class, [], [1, 'irrelevant', 'irrelevant']);

        $userRepository
            ->method('find')
            ->with(1)
            ->will(self::returnValue($userMock))
            ;

        $application = new Application();
        $application->add(new EmailChangeCommand($actionHandler, $userRepository));

        $command = $application->find('email:change');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'user' => 1,
            'email' => 'irrelevant',
        ]);

        self::assertEquals('Email has been changed.', trim($commandTester->getDisplay()));
    }

    public function testExecuteWhenUserNotFound()
    {
        $actionHandler = $this->getMock(HandlerInterface::class);
        $userRepository = $this->getMock(UserRepository::class);

        $userRepository
            ->method('find')
            ->with(1)
            ->will(self::returnValue(null))
            ;

        $application = new Application();
        $application->add(new EmailChangeCommand($actionHandler, $userRepository));

        $command = $application->find('email:change');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'user' => 1,
            'email' => 'irrelevant',
        ]);

        self::assertEquals('User 1 not found!', trim($commandTester->getDisplay()));
    }
}
