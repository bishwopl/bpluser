<?php

namespace BplUser\Form\Filter;

use Zend\InputFilter\InputFilter;
use BplUser\Provider\RegistrationOptionsInterface;

class RegisterFilter extends InputFilter {

    public function __construct(RegistrationOptionsInterface $registerOptions) {
        $this->add([
            'name' => 'email',
            'required' => true,
            'filter' => [
                ['name' => \Zend\Filter\StringTrim::class]
            ],
            'validators' => [
                ['name' => \Zend\Validator\EmailAddress::class]
            ]
        ]);

        if (!$registerOptions->getEnableEmailVerification()) {
            $this->add([
                'name' => 'password',
                'required' => true,
            ]);

            $this->add([
                'name' => 'password_verify',
                'required' => true,
                'validators' => [
                    [
                        'name' => \Zend\Validator\Identical::class,
                        'options' => [
                            'token' => 'password'
                        ]
                    ]
                ]
            ]);
        }
    }

}
