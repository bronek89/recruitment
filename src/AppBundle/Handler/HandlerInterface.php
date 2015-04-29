<?php

namespace AppBundle\Handler;

use AppBundle\Exception\ActionFailedException;

interface HandlerInterface
{
    /**
     * @param ActionInterface $action
     * @return void
     * @throws ActionFailedException
     */
    public function handle(ActionInterface $action);

    /**
     * @param ActionInterface $action
     * @return bool
     * @throws \LogicException
     */
    public function supports(ActionInterface $action);
}
