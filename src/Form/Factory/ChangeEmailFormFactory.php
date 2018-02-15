<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
namespace BplUser\Form\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use BplUser\Form\ChangeEmail;
use BplUser\Form\Filter\ChangeEmailFilter;

class ChangeEmailFormFactory implements FactoryInterface{
    /**
     * 
     * @param ContainerInterface $container
     * @param type $requestedName
     * @param array $options
     * @return ChangeEmail
     */
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $changeEmailForm = new ChangeEmail('change-email-form', $moduleOptions);
        $changeEmailForm->setInputFilter(new ChangeEmailFilter());
        return $changeEmailForm;
    }
}