<?php

namespace BplUser\Service\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use CirclicalUser\Service\AuthenticationService;
use BplUser\Service\BplUserService;

class BplUserServiceFactory implements FactoryInterface {

    /**
     * 
     * @param ContainerInterface $container
     * @param type $requestedName
     * @param array $options
     * @return BplUserService
     */
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $config = $container->get('Config');
        $userMapperKey = $config['circlical']['user']['providers']['user'];
        $roleMapperKey = $config['circlical']['user']['providers']['role'];
        $passwordResetMapperKey = $config['bpl_user']['password_reset_mapper'];
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $userMapper = $container->get($userMapperKey);
        $roleMapper = $container->get($roleMapperKey);
        $passwordResetMapper = $container->get($passwordResetMapperKey);
        $viewRenderer = $container->get(\Laminas\View\Renderer\RendererInterface::class);
        return new BplUserService($moduleOptions, $userMapper, $roleMapper, $passwordResetMapper, $viewRenderer);
    }

}
