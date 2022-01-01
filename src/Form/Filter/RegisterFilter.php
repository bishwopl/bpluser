<?php

namespace BplUser\Form\Filter;

use Laminas\InputFilter\InputFilter;
use BplUser\Contract\RegistrationOptionsInterface;

class RegisterFilter extends InputFilter {

    public function __construct(RegistrationOptionsInterface $registerOptions) {
        $this->add([
            'name' => 'email',
            'required' => true,
            'filter' => [
                ['name' => \Laminas\Filter\StringTrim::class]
            ],
            'validators' => [
                ['name' => \Laminas\Validator\EmailAddress::class]
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
                        'name' => \Laminas\Validator\Identical::class,
                        'options' => [
                            'token' => 'password'
                        ]
                    ]
                ]
            ]);
        }
    }

}
