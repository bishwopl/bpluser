<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form\Filter;
use Zend\InputFilter\InputFilter;
 
class ChangeEmailFilter extends InputFilter {
 
    public function __construct() {
 
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
        
        $this->add([
            'name' => 'password',
            'required' => true,
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