<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
namespace BplUser\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use BplUser\Controller\Plugin\BplUserControllerPlugin;
use CirclicalUser\Service\AuthenticationService;
use CirclicalUser\Service\AccessService;

class BplUserControllerPluginFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $authMapperKey = $config['circlical']['user']['providers']['auth'];
        $userMapperKey = $config['circlical']['user']['providers']['user'];
        $authenticationService = $container->get(AuthenticationService::class);
        $accessService = $container->get(AccessService::class);
        $authenticationMapper = $container->get($authMapperKey);
        $userMapper = $container->get($userMapperKey);
        
        return new BplUserControllerPlugin(
            $authenticationService, $accessService, $authenticationMapper, $userMapper
        );
    }
}