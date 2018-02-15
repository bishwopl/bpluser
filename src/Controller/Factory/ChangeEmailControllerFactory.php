<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
namespace BplUser\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use BplUser\Controller\ChangeEmailController;

class ChangeEmailControllerFactory implements FactoryInterface{
    /**
     * 
     * @param ContainerInterface $container
     * @param type $requestedName
     * @param array $options
     * @return \BplUser\Controller\ChangeEmailController
     */
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $changeEmailForm = $container->get(\BplUser\Form\ChangeEmail::class);
        return new ChangeEmailController($changeEmailForm);
    }
}