<?php

namespace BplUser;

use Laminas\Console\Console;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;

class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getViewHelperConfig() {
        return [
            'factories' => [
                'getUserEmail' => function($e) {
                    $authenticationService = $e->get(\CirclicalUser\Service\AuthenticationService::class);
                    return new \BplUser\View\Helper\GetUserEmail($authenticationService);
                },
                'getUserRoles' => function($e) {
                    $accessService = $e->get(\CirclicalUser\Service\AccessService::class);
                    return new \BplUser\View\Helper\GetUserRoles($accessService);
                },
                'isAllowed' => function($e) {
                    $accessService = $e->get(\CirclicalUser\Service\AccessService::class);
                    return new \BplUser\View\Helper\IsAllowed($accessService);
                },
                'getBplUserIdentity' => function($e) {
                    $authenticationService = $e->get(\CirclicalUser\Service\AuthenticationService::class);
                    return new \BplUser\View\Helper\GetBplUserIdentity($authenticationService);
                },
            ],
        ];
    }

    public function onBootstrap(MvcEvent $mvcEvent) {
        if (Console::isConsole()) {
            return;
        }
        $application = $mvcEvent->getApplication();
        $serviceLocator = $application->getServiceManager();
        $authorizationService = $serviceLocator->get(\CirclicalUser\Service\AuthenticationService::class);
        $user = $authorizationService->getIdentity();
        $time = time();
        
        if ($user !== NULL) {
            $session = new Container($user->getId() . '_lastActivityTimestamp');
        }
        
        if ($user !== NULL && $session->offsetExists('lastActivityTimestamp')) {
            $options = $serviceLocator->get(\BplUser\Options\ModuleOptions::class);
            $autoloagoutPeriod = $options->getAutoLogoutPeriod();
            
            $lastActivityTimestamp = $session->lastActivityTimestamp;
            
            if ($time - $lastActivityTimestamp > $autoloagoutPeriod) {
                $session->offsetUnset('lastActivityTimestamp');
                $authorizationService->clearIdentity();
                $mvcEvent->stopPropagation(TRUE);
            }
        }

        if ($user !== NULL) {
            $session->lastActivityTimestamp = $time;
        }
    }

}
