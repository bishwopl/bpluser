<?php

namespace BplUser\Listener\Factory;

use BplUser\Listener\UserEntityListener;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserEntityListenerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        if (!isset($config['circlical']['user']['doctrine']['entity'])) {
            throw new \Exception("CirclicalUser - bpluser > You must specify the user Entity that CirclicalUser will use!");
        }

        return new UserEntityListener($config['circlical']['user']['doctrine']['entity']);
    }
}