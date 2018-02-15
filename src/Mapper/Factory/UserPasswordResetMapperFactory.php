<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
namespace BplUser\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use BplUser\Mapper\UserPasswordResetMapper;
class UserPasswordResetMapperFactory implements FactoryInterface {

    /**
     * Create ModuleOptions Service
     * 
     * @param ContainerInterface $container
     * @param type $requestedName
     * @param mixed $options
     * @return ModuleOptions
     */
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $config = $container->get('Config');
        $forgotPasswordEntity = $config['bpl_user']['forgot_password_entity'];
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new UserPasswordResetMapper($entityManager, $forgotPasswordEntity);
    }

}