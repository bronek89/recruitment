<?php

namespace AppBundle\Request\ParamConverter;

use AppBundle\Model\User;
use AppBundle\Model\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class UserParamConverter implements ParamConverterInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $name = $configuration->getName();
        $id = $request->get($name);

        $user = $this->userRepository->find($id);
        $request->attributes->set($name, $user);
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === User::class;
    }
}
