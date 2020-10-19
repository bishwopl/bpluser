<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form\Filter;
use Laminas\InputFilter\InputFilter;
 
class ChangeProfileFilter extends InputFilter {
 
    public function __construct() {
 
        $this->add([
            'name' => 'firstName',
            'required' => true,
            'filter' => [
                ['name' => \Laminas\Filter\StringTrim::class]
            ],
            'validators' => [
                ['name' => \Laminas\I18n\Validator\Alpha::class]
            ]
        ]);
        
        $this->add([
            'name' => 'lastName',
            'required' => true,
            'filter' => [
                ['name' => \Laminas\Filter\StringTrim::class]
            ],
            'validators' => [
                ['name' => \Laminas\I18n\Validator\Alpha::class]
            ]
        ]);
        
        $this->add([
            'name' => 'address',
            'required' => FALSE,
            'filter' => [
                ['name' => \Laminas\Filter\StringTrim::class]
            ],
            'validators' => [
                ['name' => \Laminas\I18n\Validator\Alnum::class]
            ]
        ]);
        
        $this->add([
            'name' => 'phone',
            'required' => FALSE,
            'filter' => [
                ['name' => \Laminas\Filter\StringTrim::class]
            ],
            'validators' => [
                ['name' => \Laminas\I18n\Validator\PhoneNumber::class]
            ]
        ]);
    }
}