<?php

namespace BplUser;

class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getViewHelperConfig() {
        return [
            'factories' => [
                'getUserEmail' => function($e) {
                    $authenticationService = $e->getServiceLocator()->get(\CirclicalUser\Service\AuthenticationService::class);
                    return new \BplUser\View\Helper\GetUserEmail($authenticationService);
                },
                'getUserRoles' => function($e) {
                    $accessService = $e->getServiceLocator()->get(\CirclicalUser\Service\AccessService::class);
                    return new \BplUser\View\Helper\GetUserRoles($accessService);
                },
                'isAllowed' => function($e) {
                    $accessService = $e->getServiceLocator()->get(\CirclicalUser\Service\AccessService::class);
                    return new \BplUser\View\Helper\IsAllowed($accessService);
                },
            ],
        ];
    }
}
