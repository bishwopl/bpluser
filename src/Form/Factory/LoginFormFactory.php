<?php

namespace BplUser\Form\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class LoginFormFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $loginForm = new \BplUser\Form\Login('login-fom',$moduleOptions);
        $loginForm->setInputFilter(new \BplUser\Form\Filter\LoginFilter());
        return $loginForm;
    }

}
