<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form\Filter;
use Zend\InputFilter\InputFilter;
 
class ChangeProfileFilter extends InputFilter {
 
    public function __construct() {
 
        $this->add([
            'name' => 'firstName',
            'required' => true,
            'filter' => [
                ['name' => \Zend\Filter\StringTrim::class]
            ],
            'validators' => [
                ['name' => \Zend\I18n\Validator\Alpha::class]
            ]
        ]);
        
        $this->add([
            'name' => 'lastName',
            'required' => true,
            'filter' => [
                ['name' => \Zend\Filter\StringTrim::class]
            ],
            'validators' => [
                ['name' => \Zend\I18n\Validator\Alpha::class]
            ]
        ]);
        
        $this->add([
            'name' => 'address',
            'required' => FALSE,
            'filter' => [
                ['name' => \Zend\Filter\StringTrim::class]
            ],
            'validators' => [
                ['name' => \Zend\I18n\Validator\Alnum::class]
            ]
        ]);
        
        $this->add([
            'name' => 'phone',
            'required' => FALSE,
            'filter' => [
                ['name' => \Zend\Filter\StringTrim::class]
            ],
            'validators' => [
                ['name' => \Zend\I18n\Validator\PhoneNumber::class]
            ]
        ]);
    }
}