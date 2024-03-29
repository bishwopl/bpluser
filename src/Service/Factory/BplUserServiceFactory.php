<?php

namespace BplUser\Service\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use CirclicalUser\Service\AuthenticationService;
use BplUser\Service\BplUserService;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Mapper\RoleMapper;

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
        $userMapperKey = $config['circlical']['user']['providers']['user'] ?? UserMapper::class;
        $roleMapperKey = $config['circlical']['user']['providers']['role'] ?? RoleMapper::class;
        $passwordResetMapperKey = $config['bpl_user']['password_reset_mapper'];
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $userMapper = $container->get($userMapperKey);
        $roleMapper = $container->get($roleMapperKey);
        $passwordResetMapper = $container->get($passwordResetMapperKey);
        $authenticationService = $container->get(AuthenticationService::class);
        $viewRenderer = $container->get(\Laminas\View\Renderer\RendererInterface::class);
        return new BplUserService(
                $moduleOptions,
                $userMapper,
                $roleMapper,
                $passwordResetMapper,
                $viewRenderer,
                $authenticationService->getIdentity()
        );
    }
}
