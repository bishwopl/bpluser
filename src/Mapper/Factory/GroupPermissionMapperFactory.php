<?php

declare(strict_types=1);

namespace BplUser\Mapper\Factory;

use BplUser\Mapper\GroupPermissionMapper;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class GroupPermissionMapperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $mapper = new GroupPermissionMapper();
        $mapper->setEntityManager($container->get('doctrine.entitymanager.orm_default'));

        return $mapper;
    }
}
