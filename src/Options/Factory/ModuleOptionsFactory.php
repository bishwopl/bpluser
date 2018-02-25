<?php

namespace BplUser\Options\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ModuleOptionsFactory implements FactoryInterface {

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
        return new \BplUser\Options\ModuleOptions(
            isset($config['bpl_user']) ? $config['bpl_user'] : []
        );
    }

}
