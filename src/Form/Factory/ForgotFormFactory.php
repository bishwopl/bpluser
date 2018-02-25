<?php

namespace BplUser\Form\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use BplUser\Form\Forgot;

class ForgotFormFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $forgotPasswordForm = new Forgot('forgot-password-form',$moduleOptions);
        $forgotPasswordForm->setInputFilter(new \BplUser\Form\Filter\ForgotFilter());
        return $forgotPasswordForm;
    }

}