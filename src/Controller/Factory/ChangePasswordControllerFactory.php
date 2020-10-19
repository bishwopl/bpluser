<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
namespace BplUser\Controller\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use BplUser\Controller\ChangePasswordController;

class ChangePasswordControllerFactory implements FactoryInterface{
    /**
     * 
     * @param ContainerInterface $container
     * @param type $requestedName
     * @param array $options
     * @return \BplUser\Controller\ChangePasswordController
     */
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $changePasswordForm = $container->get(\BplUser\Form\ChangePassword::class);
        return new ChangePasswordController($changePasswordForm);
    }
}