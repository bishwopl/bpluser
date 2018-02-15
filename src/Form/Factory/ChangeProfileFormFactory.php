<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
namespace BplUser\Form\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use BplUser\Form\ChangeProfile;
use BplUser\Form\Filter\ChangeProfileFilter;

class ChangeProfileFormFactory implements FactoryInterface{
    /**
     * 
     * @param ContainerInterface $container
     * @param type $requestedName
     * @param array $options
     * @return \BplUser\Form\ChangeProfile
     */
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $em = $container->get('doctrine.entitymanager.orm_default');
        $changeProfileForm = new ChangeProfile('change-profile-form', $moduleOptions);
        $changeProfileForm->setInputFilter(new ChangeProfileFilter());
        $changeProfileForm->setHydrator(new DoctrineHydrator($em));
        return $changeProfileForm;
    }
}