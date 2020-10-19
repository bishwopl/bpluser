<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
namespace BplUser\Controller\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use BplUser\Controller\ChangeProfileController;

class ChangeProfileControllerFactory implements FactoryInterface{
    /**
     * 
     * @param ContainerInterface $container
     * @param type $requestedName
     * @param array $options
     * @return \BplUser\Controller\ChangeProfileController
     */
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $config = $container->get('Config');
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $userEntity = $config['circlical']['user']['doctrine']['entity'];
        $changeProfileForm = $container->get($moduleOptions->getChangeProfileFormFactory());
        return new ChangeProfileController($moduleOptions, $changeProfileForm, new $userEntity);
    }
}