<?php

namespace BplUser\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class RegisterControllerFactory implements FactoryInterface {

    /**
     * 
     * @param ContainerInterface $container
     * @param type $requestedName
     * @param array $options
     * @return BplUserController
     */
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $config = $container->get('Config');
        $userEntity = $config['circlical']['user']['doctrine']['entity'];
        $bplUserService = $container->get(\BplUser\Service\BplUserService::class);
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $registrationForm = $container->get($moduleOptions->getRegistrationFormFactory());
        return new \BplUser\Controller\RegisterController(
                $moduleOptions, $bplUserService, $registrationForm, new $userEntity
        );
    }

}
