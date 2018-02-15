<?php

namespace BplUser\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class AuthenticationControllerFactory implements FactoryInterface {

    /**
     * 
     * @param ContainerInterface $container
     * @param type $requestedName
     * @param array $options
     * @return BplUserController
     */
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $bplUserService = $container->get(\BplUser\Service\BplUserService::class);
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $loginForm = $container->get(\BplUser\Form\Login::class);
        $translator = $container->get('MvcTranslator');
        return new \BplUser\Controller\AuthenticationController(
                $moduleOptions, $bplUserService, $loginForm, $translator
        );
    }

}
