<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
namespace BplUser\Form\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use BplUser\Form\ChangePassword;
use BplUser\Form\Filter\ChangePasswordFilter;

class ChangePasswordFormFactory implements FactoryInterface{
    /**
     * 
     * @param ContainerInterface $container
     * @param type $requestedName
     * @param array $options
     * @return type
     */
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $changePasswordForm = new ChangePassword('change-password-form', $moduleOptions);
        $changePasswordForm->setInputFilter(new ChangePasswordFilter());
        return $changePasswordForm;
    }
}