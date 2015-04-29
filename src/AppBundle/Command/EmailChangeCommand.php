<?php

namespace AppBundle\Command;

use AppBundle\Exception\ActionValidationFailedException;
use AppBundle\Handler\EmailChangeAction;
use AppBundle\Handler\HandlerInterface;
use AppBundle\Model\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmailChangeCommand extends Command
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
        parent::__construct();

        $this->actionHandler = $actionHandler;
        $this->userRepository = $userRepository;
    }

    protected function configure()
    {
        $this
            ->setName('email:change')
            ->setDescription('Changes user e-mail.')
            ->addArgument(
                'user',
                InputArgument::REQUIRED
            )
            ->addArgument(
                'email',
                InputArgument::REQUIRED
            )
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $newEmail = $input->getArgument('email');
        $userId = (int)$input->getArgument('user');

        $user = $this->userRepository->find($userId);

        if (null === $user) {
            $output->writeln(sprintf(
                '<fg=red>User %d not found!</fg=red>',
                $userId
            ));
            return;
        }

        $action = new EmailChangeAction();
        $action->setNewEmail($newEmail);
        $action->setUser($user);

        try {
            $this->actionHandler->handle($action);
            $output->writeln('<fg=green>Email has been changed.</fg=green>');
        } catch (ActionValidationFailedException $exception) {
            $output->writeln(sprintf(
                '<fg=red>Validation failed: %s.</fg=red>',
                (string) $exception->getValidationErrors()
            ));
        } catch (\Exception $exception) {
            $output->writeln(sprintf(
                '<fg=red>Unexpected error occurs during executing the action: %s.</fg=red>',
                $exception->getMessage()
            ));
        }
    }
}
