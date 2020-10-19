<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form\Filter;

use Laminas\InputFilter\InputFilter;

class ResetPasswordFilter extends InputFilter {

    public function __construct() {

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
