<?php

namespace BplUser\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use BplUser\Controller\ForgotController;

class ForgotPasswordControllerFactory implements FactoryInterface {

    /**
     * 
     * @param ContainerInterface $container
     * @param type $requestedName
     * @param array $options
     * @return BplUserController
     */
    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $bplUserService = $container->get(\BplUser\Service\BplUserService::class);
        $moduleOptions = $container->get(\BplUser\Options\ModuleOptions::class);
        $forgotPasswordForm = $container->get(\BplUser\Form\Forgot::class);
        $resetPasswordForm = $container->get(\BplUser\Form\ResetPassword::class);
        $translator = $container->get('MvcTranslator');
        return new ForgotController(
                $moduleOptions, $bplUserService, $forgotPasswordForm, $resetPasswordForm, $translator
        );
    }

}
