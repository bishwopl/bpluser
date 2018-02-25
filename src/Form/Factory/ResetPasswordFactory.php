<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ResetPasswordFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, Array $options = null) {
        $resetPasswordForm = new \BplUser\Form\ResetPassword('reset-password-form');
        $resetPasswordForm->setInputFilter(new \BplUser\Form\Filter\ResetPasswordFilter());
        return $resetPasswordForm;
    }

}
