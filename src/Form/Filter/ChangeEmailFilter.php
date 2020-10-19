<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form\Filter;
use Laminas\InputFilter\InputFilter;
 
class ChangeEmailFilter extends InputFilter {
 
    public function __construct() {
 
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
        
        $this->add([
            'name' => 'password',
            'required' => true,
        ]);
        
        $this->add([
            'name' => 'csrf',
            'required' => true,
            'validators' => [
                [
                    'name' => \Laminas\Validator\Csrf::class
                ]
            ]
        ]);
    }
}