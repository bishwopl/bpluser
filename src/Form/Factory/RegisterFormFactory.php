<?php

namespace BplUser\Form\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;

class RegisterFormFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $em = $container->get('doctrine.entitymanager.orm_default');
        $registerForm = new \BplUser\Form\Register('register-form', $moduleOptions);
        $registerForm->setInputFilter(new \BplUser\Form\Filter\RegisterFilter($moduleOptions));
        $registerForm->setHydrator(new DoctrineHydrator($em));
        $registerForm->setUseAsBaseFieldset(true);
        return $registerForm;
    }

}
