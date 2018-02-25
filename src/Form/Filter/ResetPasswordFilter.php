<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form\Filter;

use Zend\InputFilter\InputFilter;

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
                    'name' => \Zend\Validator\Identical::class,
                    'options' => [
                        'token' => 'password'
                    ]
                ]
            ]
        ]);
    }

}
