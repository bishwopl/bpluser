<?php

namespace BplUser\Collector\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BplUser\Collector\BplUserCollector;
use CirclicalUser\Service\AuthenticationService;

/**
 * Factory class for BplUser Data Collector.
 *
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
class BplUserCollectorFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $user = $serviceLocator->get(AuthenticationService::class)->getIdentity();
        return new BplUserCollector($user);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        return $this->createService($serviceLocator);
    }
}
