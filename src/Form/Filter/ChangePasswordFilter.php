<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BplUser\Form\Filter;

use Zend\InputFilter\InputFilter;

class ChangePasswordFilter extends InputFilter {

    public function __construct() {

        $this->add([
            'name' => 'current_password',
            'required' => true,
        ]);

        $this->add([
            'name' => 'new_password',
            'required' => true,
        ]);

        $this->add([
            'name' => 'new_password_verify',
            'required' => true,
            'validators' => [
                [
                    'name' => \Zend\Validator\Identical::class,
                    'options' => [
                        'token' => 'new_password'
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'csrf',
            'required' => true,
            'validators' => [
                [
                    'name' => \Zend\Validator\Csrf::class
                ]
            ]
        ]);
    }

}
