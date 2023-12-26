<?php

namespace BplUser\Controller\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use CirclicalUser\Mapper\UserAtomMapper;
use CirclicalUser\Service\AuthenticationService;
use BplUser\Controller\UserAtomController;

class UserAtomControllerFactory implements FactoryInterface {

    
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $config = $container->get('Config');
        $authService = $container->get(AuthenticationService::class);
        $userAtomKeys= $config['bpl_user']['user-atom-keys'];
        $currentUser = $authService->getIdentity();
        $userAtomMapper = $container->get(UserAtomMapper::class);
        
        return new UserAtomController($currentUser, $userAtomKeys, $userAtomMapper);
        
    }

}